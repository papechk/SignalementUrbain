<?php

namespace App\Http\Controllers;

use App\Models\Creneau;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\Terrain;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['terrain', 'paiement'])->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('terrain_id')) {
            $query->where('terrain_id', $request->terrain_id);
        }

        if ($request->filled('recherche')) {
            $term = $request->string('recherche')->toString();
            $query->where(function ($q) use ($term) {
                $q->where('reference', 'like', "%{$term}%")
                    ->orWhere('client_nom', 'like', "%{$term}%")
                    ->orWhere('client_email', 'like', "%{$term}%");
            });
        }

        $reservations = $query->paginate(12)->withQueryString();
        $terrains = Terrain::where('actif', true)->orderBy('nom')->get();

        return view('reservations.index', compact('reservations', 'terrains'));
    }

    public function create()
    {
        $terrains = Terrain::where('actif', true)->orderBy('nom')->get();

        return view('reservations.create', compact('terrains'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'terrain_id' => 'required|exists:terrains,id',
            'client_nom' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_telephone' => 'nullable|string|max:30',
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut',
            'statut' => 'nullable|in:en_attente,confirmee,annulee',
            'montant_total' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $debut = Carbon::parse($validated['debut']);
        $fin = Carbon::parse($validated['fin']);
        $this->assertNoOverlap((int) $validated['terrain_id'], $debut, $fin);

        $terrain = Terrain::findOrFail($validated['terrain_id']);
        $validated['montant_total'] = $validated['montant_total'] ?? $this->computeAmount($terrain, $debut, $fin);
        $validated['statut'] = $validated['statut'] ?? 'en_attente';

        $reservation = Reservation::create($validated);

        Paiement::updateOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'montant' => $reservation->montant_total,
                'mode_paiement' => 'autre',
                'statut' => 'en_attente',
            ]
        );

        if ($reservation->statut === 'confirmee') {
            $this->syncReservedSlot($reservation);
        }

        return redirect()
            ->route('admin.reservations.show', $reservation)
            ->with('success', 'Reservation creee avec succes.');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['terrain', 'paiement']);

        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $terrains = Terrain::where('actif', true)->orderBy('nom')->get();

        return view('reservations.edit', compact('reservation', 'terrains'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'terrain_id' => 'required|exists:terrains,id',
            'client_nom' => 'required|string|max:255',
            'client_email' => 'nullable|email|max:255',
            'client_telephone' => 'nullable|string|max:30',
            'debut' => 'required|date',
            'fin' => 'required|date|after:debut',
            'statut' => 'required|in:en_attente,confirmee,annulee',
            'montant_total' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $debut = Carbon::parse($validated['debut']);
        $fin = Carbon::parse($validated['fin']);
        $this->assertNoOverlap((int) $validated['terrain_id'], $debut, $fin, $reservation->id);

        $terrain = Terrain::findOrFail($validated['terrain_id']);
        $validated['montant_total'] = $validated['montant_total'] ?? $this->computeAmount($terrain, $debut, $fin);
        $reservation->update($validated);

        Paiement::updateOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'montant' => $reservation->montant_total,
                'mode_paiement' => $reservation->paiement?->mode_paiement ?? 'autre',
                'statut' => $reservation->paiement?->statut ?? 'en_attente',
                'date_paiement' => $reservation->paiement?->date_paiement,
                'transaction_id' => $reservation->paiement?->transaction_id,
                'notes' => $reservation->paiement?->notes,
            ]
        );

        if ($reservation->statut === 'confirmee') {
            $this->syncReservedSlot($reservation);
        }

        return redirect()
            ->route('admin.reservations.show', $reservation)
            ->with('success', 'Reservation mise a jour avec succes.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()
            ->route('admin.reservations.index')
            ->with('success', 'Reservation supprimee.');
    }

    public function confirmer(Reservation $reservation)
    {
        $reservation->update(['statut' => 'confirmee']);
        $this->syncReservedSlot($reservation);

        return redirect()
            ->back()
            ->with('success', 'Reservation confirmee.');
    }

    public function annuler(Reservation $reservation)
    {
        $reservation->update(['statut' => 'annulee']);

        Creneau::where('terrain_id', $reservation->terrain_id)
            ->where('debut', $reservation->debut)
            ->where('fin', $reservation->fin)
            ->where('statut', 'reserve')
            ->update([
                'statut' => 'disponible',
                'titre' => 'Disponible',
                'notes' => null,
            ]);

        return redirect()
            ->back()
            ->with('success', 'Reservation annulee.');
    }

    public function calendar()
    {
        $terrains = Terrain::orderBy('nom')->get();

        return view('reservations.calendar', compact('terrains'));
    }

    public function events(Request $request)
    {
        $start = $request->date('start', now()->startOfMonth());
        $end = $request->date('end', now()->endOfMonth());

        $terrainId = $request->integer('terrain_id');

        $creneaux = Creneau::with('terrain')
            ->when($terrainId, fn ($q) => $q->where('terrain_id', $terrainId))
            ->where('debut', '<', $end)
            ->where('fin', '>', $start)
            ->get()
            ->map(function (Creneau $creneau) {
                return [
                    'id' => 'creneau-' . $creneau->id,
                    'title' => ($creneau->titre ?: 'Creneau') . ' - ' . $creneau->terrain->nom,
                    'start' => $creneau->debut->toIso8601String(),
                    'end' => $creneau->fin->toIso8601String(),
                    'backgroundColor' => match ($creneau->statut) {
                        'disponible' => '#16a34a',
                        'reserve' => '#2563eb',
                        default => '#6b7280',
                    },
                    'borderColor' => 'transparent',
                ];
            });

        $reservations = Reservation::with('terrain')
            ->when($terrainId, fn ($q) => $q->where('terrain_id', $terrainId))
            ->where('debut', '<', $end)
            ->where('fin', '>', $start)
            ->get()
            ->map(function (Reservation $reservation) {
                return [
                    'id' => 'reservation-' . $reservation->id,
                    'title' => 'Reservation ' . $reservation->reference . ' - ' . $reservation->terrain->nom,
                    'start' => $reservation->debut->toIso8601String(),
                    'end' => $reservation->fin->toIso8601String(),
                    'backgroundColor' => match ($reservation->statut) {
                        'confirmee' => '#0ea5e9',
                        'annulee' => '#ef4444',
                        default => '#f59e0b',
                    },
                    'borderColor' => 'transparent',
                    'textColor' => '#111827',
                ];
            });

        return response()->json($creneaux->merge($reservations)->values());
    }

    private function assertNoOverlap(int $terrainId, Carbon $debut, Carbon $fin, ?int $ignoreReservationId = null): void
    {
        $conflict = Reservation::where('terrain_id', $terrainId)
            ->where('statut', '!=', 'annulee')
            ->when($ignoreReservationId, fn ($q) => $q->where('id', '!=', $ignoreReservationId))
            ->where('debut', '<', $fin)
            ->where('fin', '>', $debut)
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'debut' => "Ce terrain est deja reserve sur ce creneau.",
            ]);
        }
    }

    private function computeAmount(Terrain $terrain, Carbon $debut, Carbon $fin): float
    {
        $minutes = max(60, $debut->diffInMinutes($fin));
        $hours = $minutes / 60;

        return (float) round($hours * (float) $terrain->prix_heure, 2);
    }

    private function syncReservedSlot(Reservation $reservation): void
    {
        Creneau::updateOrCreate(
            [
                'terrain_id' => $reservation->terrain_id,
                'debut' => $reservation->debut,
                'fin' => $reservation->fin,
            ],
            [
                'titre' => 'Reserve - ' . $reservation->reference,
                'statut' => 'reserve',
                'notes' => 'Reservation ' . $reservation->reference,
            ]
        );
    }
}

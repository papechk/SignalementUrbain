<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Paiement::with('reservation.terrain')->latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('recherche')) {
            $term = $request->string('recherche')->toString();
            $query->where(function ($q) use ($term) {
                $q->where('reference', 'like', "%{$term}%")
                    ->orWhere('transaction_id', 'like', "%{$term}%")
                    ->orWhereHas('reservation', function ($rq) use ($term) {
                        $rq->where('reference', 'like', "%{$term}%")
                            ->orWhere('client_nom', 'like', "%{$term}%");
                    });
            });
        }

        $paiements = $query->paginate(12)->withQueryString();

        return view('paiements.index', compact('paiements'));
    }

    public function create(Request $request)
    {
        $reservations = Reservation::with('terrain')
            ->whereDoesntHave('paiement')
            ->latest()
            ->get();

        $selectedReservation = null;
        if ($request->filled('reservation_id')) {
            $selectedReservation = Reservation::with('terrain')->find($request->reservation_id);
        }

        return view('paiements.create', compact('reservations', 'selectedReservation'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id|unique:paiements,reservation_id',
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|in:carte,especes,virement,mobile_money,autre',
            'statut' => 'required|in:en_attente,partiel,paye,rembourse,echec',
            'date_paiement' => 'nullable|date',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validated['statut'] === 'paye' && empty($validated['date_paiement'])) {
            $validated['date_paiement'] = now();
        }

        $paiement = Paiement::create($validated);

        return redirect()
            ->route('admin.paiements.edit', $paiement)
            ->with('success', 'Paiement cree avec succes.');
    }

    public function edit(Paiement $paiement)
    {
        $paiement->load('reservation.terrain');

        return view('paiements.edit', compact('paiement'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        $validated = $request->validate([
            'montant' => 'required|numeric|min:0',
            'mode_paiement' => 'required|in:carte,especes,virement,mobile_money,autre',
            'statut' => 'required|in:en_attente,partiel,paye,rembourse,echec',
            'date_paiement' => 'nullable|date',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($validated['statut'] === 'paye' && empty($validated['date_paiement'])) {
            $validated['date_paiement'] = now();
        }

        $paiement->update($validated);

        return redirect()
            ->route('admin.paiements.index')
            ->with('success', 'Paiement mis a jour.');
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();

        return redirect()
            ->route('admin.paiements.index')
            ->with('success', 'Paiement supprime.');
    }

    public function updateStatut(Request $request, Paiement $paiement)
    {
        $validated = $request->validate([
            'statut' => 'required|in:en_attente,partiel,paye,rembourse,echec',
        ]);

        $data = ['statut' => $validated['statut']];
        if ($validated['statut'] === 'paye' && !$paiement->date_paiement) {
            $data['date_paiement'] = now();
        }

        $paiement->update($data);

        return redirect()
            ->back()
            ->with('success', 'Statut du paiement mis a jour.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Terrain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TerrainController extends Controller
{
    public function index(Request $request)
    {
        $query = Terrain::with('proprietaire')->latest();

        if ($request->filled('recherche')) {
            $term = $request->string('recherche')->toString();
            $query->where(function ($q) use ($term) {
                $q->where('nom', 'like', "%{$term}%")
                    ->orWhere('adresse', 'like', "%{$term}%")
                    ->orWhere('ville', 'like', "%{$term}%");
            });
        }

        if ($request->filled('actif')) {
            $query->where('actif', $request->actif === '1');
        }

        $terrains = $query->paginate(10)->withQueryString();

        return view('terrains.index', compact('terrains'));
    }

    public function create()
    {
        $proprietaires = User::orderBy('name')->get();

        return view('terrains.create', compact('proprietaires'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:terrains,nom',
            'type' => 'required|in:football,basketball,tennis,multi_sport,autre',
            'surface' => 'required|string|max:255',
            'capacite' => 'nullable|integer|min:1|max:1000',
            'prix_heure' => 'required|numeric|min:0',
            'adresse' => 'required|string|max:255',
            'ville' => 'nullable|string|max:255',
            'proprietaire_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['nom']) . '-' . Str::lower(Str::random(4));
        $validated['actif'] = $request->boolean('actif', true);

        $terrain = Terrain::create($validated);

        return redirect()
            ->route('admin.terrains.show', $terrain)
            ->with('success', 'Terrain cree avec succes.');
    }

    public function show(Terrain $terrain)
    {
        $terrain->load([
            'proprietaire',
            'reservations' => fn ($q) => $q->latest()->take(10),
        ]);

        return view('terrains.show', compact('terrain'));
    }

    public function edit(Terrain $terrain)
    {
        $proprietaires = User::orderBy('name')->get();

        return view('terrains.edit', compact('terrain', 'proprietaires'));
    }

    public function update(Request $request, Terrain $terrain)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:terrains,nom,' . $terrain->id,
            'type' => 'required|in:football,basketball,tennis,multi_sport,autre',
            'surface' => 'required|string|max:255',
            'capacite' => 'nullable|integer|min:1|max:1000',
            'prix_heure' => 'required|numeric|min:0',
            'adresse' => 'required|string|max:255',
            'ville' => 'nullable|string|max:255',
            'proprietaire_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'actif' => 'nullable|boolean',
        ]);

        $validated['slug'] = $terrain->slug ?: Str::slug($validated['nom']) . '-' . Str::lower(Str::random(4));
        $validated['actif'] = $request->boolean('actif', false);

        $terrain->update($validated);

        return redirect()
            ->route('admin.terrains.show', $terrain)
            ->with('success', 'Terrain mis a jour avec succes.');
    }

    public function destroy(Terrain $terrain)
    {
        if ($terrain->reservations()->exists()) {
            return redirect()
                ->route('admin.terrains.index')
                ->with('error', 'Suppression impossible: ce terrain a des reservations.');
        }

        $terrain->delete();

        return redirect()
            ->route('admin.terrains.index')
            ->with('success', 'Terrain supprime avec succes.');
    }
}

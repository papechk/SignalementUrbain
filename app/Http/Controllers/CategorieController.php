<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Afficher la liste des catégories
     */
    public function index()
    {
        $categories = Categorie::withCount('signalements')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Enregistrer une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:255|unique:categories,nom',
            'icone'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'actif'       => 'boolean',
        ]);

        $validated['actif'] = $request->has('actif');

        Categorie::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    /**
     * Mettre à jour une catégorie
     */
    public function update(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'nom'         => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
            'icone'       => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'actif'       => 'boolean',
        ]);

        $validated['actif'] = $request->has('actif');

        $categorie->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Supprimer une catégorie
     */
    public function destroy(Categorie $categorie)
    {
        if ($categorie->signalements()->count() > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Impossible de supprimer : cette catégorie contient des signalements.');
        }

        $categorie->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}

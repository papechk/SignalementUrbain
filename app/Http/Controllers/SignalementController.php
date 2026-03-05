<?php

namespace App\Http\Controllers;

use App\Models\Signalement;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SignalementController extends Controller
{
    /**
     * Afficher la liste des signalements avec filtres
     */
    public function index(Request $request)
    {
        $query = Signalement::with('categorie')->latest();

        // Filtrage par statut
        if ($request->filled('statut')) {
            $query->parStatut($request->statut);
        }

        // Filtrage par priorité
        if ($request->filled('priorite')) {
            $query->parPriorite($request->priorite);
        }

        // Filtrage par catégorie
        if ($request->filled('categorie_id')) {
            $query->parCategorie($request->categorie_id);
        }

        // Recherche par mot-clé
        if ($request->filled('recherche')) {
            $recherche = $request->recherche;
            $query->where(function ($q) use ($recherche) {
                $q->where('titre', 'like', "%{$recherche}%")
                  ->orWhere('reference', 'like', "%{$recherche}%")
                  ->orWhere('adresse', 'like', "%{$recherche}%")
                  ->orWhere('signale_par', 'like', "%{$recherche}%");
            });
        }

        $signalements = $query->paginate(10)->withQueryString();
        $categories = Categorie::actives()->get();

        return view('signalements.index', compact('signalements', 'categories'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $categories = Categorie::actives()->get();
        return view('signalements.create', compact('categories'));
    }

    /**
     * Enregistrer un nouveau signalement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre'                => 'required|string|max:255',
            'description'          => 'required|string',
            'categorie_id'         => 'required|exists:categories,id',
            'adresse'              => 'required|string|max:255',
            'quartier'             => 'nullable|string|max:255',
            'priorite'             => 'required|in:faible,moyenne,haute,urgente',
            'photo'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude'             => 'nullable|numeric|between:-90,90',
            'longitude'            => 'nullable|numeric|between:-180,180',
            'signale_par'          => 'required|string|max:255',
            'email_signaleur'      => 'nullable|email|max:255',
            'telephone_signaleur'  => 'nullable|string|max:20',
        ]);

        // Gestion de l'upload de photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $nomPhoto = time() . '_' . Str::slug($validated['titre']) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads'), $nomPhoto);
            $validated['photo'] = 'uploads/' . $nomPhoto;
        }

        $validated['reference'] = 'SIG-' . strtoupper(Str::random(8));

        $signalement = Signalement::create($validated);

        return redirect()
            ->route('admin.signalements.show', $signalement)
            ->with('success', 'Signalement créé avec succès ! Référence : ' . $signalement->reference);
    }

    /**
     * Afficher un signalement
     */
    public function show(Signalement $signalement)
    {
        $signalement->load('categorie');
        return view('signalements.show', compact('signalement'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(Signalement $signalement)
    {
        $categories = Categorie::actives()->get();
        return view('signalements.edit', compact('signalement', 'categories'));
    }

    /**
     * Mettre à jour un signalement
     */
    public function update(Request $request, Signalement $signalement)
    {
        $validated = $request->validate([
            'titre'                => 'required|string|max:255',
            'description'          => 'required|string',
            'categorie_id'         => 'required|exists:categories,id',
            'adresse'              => 'required|string|max:255',
            'quartier'             => 'nullable|string|max:255',
            'statut'               => 'required|in:nouveau,en_cours,resolu,rejete',
            'priorite'             => 'required|in:faible,moyenne,haute,urgente',
            'photo'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'signale_par'          => 'required|string|max:255',
            'email_signaleur'      => 'nullable|email|max:255',
            'telephone_signaleur'  => 'nullable|string|max:20',
            'commentaire_mairie'   => 'nullable|string',
        ]);

        // Gestion de l'upload de photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($signalement->photo && file_exists(public_path($signalement->photo))) {
                unlink(public_path($signalement->photo));
            }
            $photo = $request->file('photo');
            $nomPhoto = time() . '_' . Str::slug($validated['titre']) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads'), $nomPhoto);
            $validated['photo'] = 'uploads/' . $nomPhoto;
        }

        // Gestion de la date de résolution
        if ($validated['statut'] === 'resolu' && $signalement->statut !== 'resolu') {
            $validated['date_resolution'] = now();
        } elseif ($validated['statut'] !== 'resolu') {
            $validated['date_resolution'] = null;
        }

        $signalement->update($validated);

        return redirect()
            ->route('admin.signalements.show', $signalement)
            ->with('success', 'Signalement mis à jour avec succès !');
    }

    /**
     * Supprimer un signalement
     */
    public function destroy(Signalement $signalement)
    {
        // Supprimer la photo si elle existe
        if ($signalement->photo && file_exists(public_path($signalement->photo))) {
            unlink(public_path($signalement->photo));
        }

        $signalement->delete();

        return redirect()
            ->route('admin.signalements.index')
            ->with('success', 'Signalement supprimé avec succès !');
    }

    /**
     * Changer rapidement le statut d'un signalement
     */
    public function changerStatut(Request $request, Signalement $signalement)
    {
        $validated = $request->validate([
            'statut'             => 'required|in:nouveau,en_cours,resolu,rejete',
            'commentaire_mairie' => 'nullable|string',
        ]);

        $signalement->statut = $validated['statut'];
        $signalement->commentaire_mairie = $validated['commentaire_mairie'] ?? $signalement->commentaire_mairie;

        if ($validated['statut'] === 'resolu') {
            $signalement->date_resolution = now();
        }

        $signalement->save();

        return redirect()
            ->back()
            ->with('success', 'Statut mis à jour : ' . $signalement->statut_label);
    }
}

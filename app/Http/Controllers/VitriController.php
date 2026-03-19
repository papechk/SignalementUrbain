<?php

namespace App\Http\Controllers;

use App\Models\Signalement;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VitriController extends Controller
{
    /**
     * Page d'accueil publique
     */
    public function accueil()
    {
        $stats = [
            'total'    => Signalement::count(),
            'resolu'   => Signalement::where('statut', 'resolu')->count(),
            'en_cours' => Signalement::where('statut', 'en_cours')->count(),
        ];
        $tauxResolution = $stats['total'] > 0
            ? (int) round(($stats['resolu'] / $stats['total']) * 100)
            : 0;

        $categories = Categorie::actives()
            ->withCount('signalements')
            ->orderBy('signalements_count', 'desc')
            ->get();

        $derniers = Signalement::with('categorie')
            ->latest()
            ->take(6)
            ->get();

        return view('vitrine.accueil', compact('stats', 'categories', 'derniers', 'tauxResolution'));
    }

    /**
     * Liste publique des signalements
     */
    public function signalements(Request $request)
    {
        $query = Signalement::with('categorie')->latest();

        if ($request->filled('statut')) {
            $query->parStatut($request->statut);
        }

        if ($request->filled('priorite')) {
            $query->parPriorite($request->priorite);
        }

        if ($request->filled('categorie_id')) {
            $query->parCategorie($request->categorie_id);
        }

        if ($request->filled('recherche')) {
            $recherche = $request->recherche;
            $query->where(function ($q) use ($recherche) {
                $q->where('titre', 'like', "%{$recherche}%")
                  ->orWhere('reference', 'like', "%{$recherche}%")
                  ->orWhere('adresse', 'like', "%{$recherche}%");
            });
        }

        $signalements = $query->paginate(9)->withQueryString();
        $categories = Categorie::actives()->get();

        return view('vitrine.signalements', compact('signalements', 'categories'));
    }

    /**
     * Détail public d'un signalement
     */
    public function detail(Signalement $signalement)
    {
        $signalement->load('categorie');

        $similaires = Signalement::with('categorie')
            ->where('categorie_id', $signalement->categorie_id)
            ->where('id', '!=', $signalement->id)
            ->latest()
            ->take(3)
            ->get();

        return view('vitrine.detail', compact('signalement', 'similaires'));
    }

    /**
     * Formulaire public de signalement
     */
    public function signaler()
    {
        $categories = Categorie::actives()->get();
        return view('vitrine.signaler', compact('categories'));
    }

    /**
     * Traitement du formulaire public de signalement
     */
    public function signalerStore(Request $request)
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
            'telephone_signaleur'  => 'nullable|string|max:20',
        ]);

        // Auto-fill from authenticated user
        $validated['signale_par']     = auth()->user()->name;
        $validated['email_signaleur'] = auth()->user()->email;

        // Upload photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $nomPhoto = time() . '_' . Str::slug($validated['titre']) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads'), $nomPhoto);
            $validated['photo'] = 'uploads/' . $nomPhoto;
        }

        $validated['reference'] = 'SIG-' . strtoupper(Str::random(8));

        $signalement = Signalement::create($validated);

        return redirect()
            ->route('vitrine.confirmation', $signalement)
            ->with('success', 'Votre signalement a été enregistré avec succès !');
    }

    /**
     * Page de confirmation après soumission
     */
    public function confirmation(Signalement $signalement)
    {
        return view('vitrine.confirmation', compact('signalement'));
    }

    /**
     * Page de suivi d'un signalement par référence
     */
    public function suivi(Request $request)
    {
        $signalement = null;
        $recherche = $request->get('reference');

        if ($recherche) {
            $signalement = Signalement::with('categorie')
                ->where('reference', $recherche)
                ->first();
        }

        return view('vitrine.suivi', compact('signalement', 'recherche'));
    }

    /**
     * Carte interactive des signalements (style Waze)
     */
    public function carte()
    {
        $signalements = Signalement::with('categorie')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $categories = Categorie::actives()->get();

        $stats = [
            'nouveau'  => Signalement::where('statut', 'nouveau')->count(),
            'en_cours' => Signalement::where('statut', 'en_cours')->count(),
            'resolu'   => Signalement::where('statut', 'resolu')->count(),
            'rejete'   => Signalement::where('statut', 'rejete')->count(),
        ];

        return view('vitrine.carte', compact('signalements', 'categories', 'stats'));
    }

    /**
     * Page de contact
     */
    public function contact()
    {
        return view('vitrine.contact');
    }

    /**
     * Traitement du formulaire de contact
     */
    public function contactStore(Request $request)
    {
        $request->validate([
            'nom'     => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'sujet'   => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Ici on pourrait envoyer un email, stocker en BDD, etc.
        // Pour l'instant on redirige avec un message de succès

        return redirect()
            ->route('vitrine.contact')
            ->with('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
    }
}

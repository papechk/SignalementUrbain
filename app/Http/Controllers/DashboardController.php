<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Signalement;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Tableau de bord principal.
     */
    public function index()
    {
        $stats = [
            'total' => Signalement::count(),
            'nouveau' => Signalement::parStatut('nouveau')->count(),
            'en_cours' => Signalement::parStatut('en_cours')->count(),
            'resolu' => Signalement::parStatut('resolu')->count(),
            'rejete' => Signalement::parStatut('rejete')->count(),
        ];

        $parPriorite = [
            'faible' => Signalement::parPriorite('faible')->count(),
            'moyenne' => Signalement::parPriorite('moyenne')->count(),
            'haute' => Signalement::parPriorite('haute')->count(),
            'urgente' => Signalement::parPriorite('urgente')->count(),
        ];

        $parCategorie = Categorie::withCount('signalements')
            ->has('signalements')
            ->orderByDesc('signalements_count')
            ->get();

        $derniers = Signalement::with('categorie')
            ->latest()
            ->take(5)
            ->get();

        $urgents = Signalement::with('categorie')
            ->where('priorite', 'urgente')
            ->whereNotIn('statut', ['resolu', 'rejete'])
            ->latest()
            ->get();

        $tauxResolution = $stats['total'] > 0
            ? round(($stats['resolu'] / $stats['total']) * 100, 1)
            : 0;

        $nbUtilisateurs = User::count();

        $signalementsMois = Signalement::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $nbQuartiers = Signalement::whereNotNull('quartier')
            ->distinct('quartier')
            ->count('quartier');

        return view('dashboard.index-tw', compact(
            'stats',
            'parPriorite',
            'parCategorie',
            'derniers',
            'urgents',
            'tauxResolution',
            'nbUtilisateurs',
            'signalementsMois',
            'nbQuartiers'
        ));
    }
}

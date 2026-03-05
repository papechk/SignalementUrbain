<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\Signalement;
use App\Models\Terrain;

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

        $widget = [
            'terrains_total' => Terrain::count(),
            'terrains_actifs' => Terrain::where('actif', true)->count(),
            'reservations_jour' => Reservation::duJour()
                ->where('statut', '!=', 'annulee')
                ->count(),
            'revenu_jour' => Paiement::where('statut', 'paye')
                ->whereDate('date_paiement', today())
                ->sum('montant'),
            'revenu_mois' => Paiement::where('statut', 'paye')
                ->whereYear('date_paiement', now()->year)
                ->whereMonth('date_paiement', now()->month)
                ->sum('montant'),
        ];

        $prochainesReservations = Reservation::with('terrain')
            ->where('debut', '>=', now())
            ->where('statut', '!=', 'annulee')
            ->orderBy('debut')
            ->take(5)
            ->get();

        $paiementsRecents = Paiement::with('reservation.terrain')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'parPriorite',
            'parCategorie',
            'derniers',
            'urgents',
            'tauxResolution',
            'widget',
            'prochainesReservations',
            'paiementsRecents'
        ));
    }
}

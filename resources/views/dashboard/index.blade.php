@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('breadcrumb')
<li class="breadcrumb-item active">Tableau de bord</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</h2>
        <p class="text-muted mb-0">Vue globale: signalements, terrains, reservations et paiements</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nouvelle reservation
        </a>
        <a href="{{ route('admin.reservations.calendar') }}" class="btn btn-outline-primary">
            <i class="bi bi-calendar3 me-1"></i> Calendrier
        </a>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3"><i class="bi bi-clipboard-data"></i></div>
                <div><div class="text-muted small">Signalements total</div><div class="fs-4 fw-bold">{{ $stats['total'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-info bg-opacity-10 text-info me-3"><i class="bi bi-bell"></i></div>
                <div><div class="text-muted small">Nouveaux</div><div class="fs-4 fw-bold text-info">{{ $stats['nouveau'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3"><i class="bi bi-hourglass-split"></i></div>
                <div><div class="text-muted small">En cours</div><div class="fs-4 fw-bold text-warning">{{ $stats['en_cours'] }}</div></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body d-flex align-items-center">
                <div class="stat-icon bg-success bg-opacity-10 text-success me-3"><i class="bi bi-check-circle"></i></div>
                <div><div class="text-muted small">Resolus</div><div class="fs-4 fw-bold text-success">{{ $stats['resolu'] }}</div></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small">Terrains actifs</div>
                <div class="fs-4 fw-bold">{{ $widget['terrains_actifs'] }} <span class="fs-6 text-muted">/ {{ $widget['terrains_total'] }}</span></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small">Reservations du jour</div>
                <div class="fs-4 fw-bold">{{ $widget['reservations_jour'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small">Revenu du jour</div>
                <div class="fs-4 fw-bold">{{ number_format($widget['revenu_jour'], 2, ',', ' ') }} MAD</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="text-muted small">Revenu du mois</div>
                <div class="fs-4 fw-bold">{{ number_format($widget['revenu_mois'], 2, ',', ' ') }} MAD</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-graph-up me-2"></i>Taux de resolution</div>
            <div class="card-body text-center">
                <div class="display-3 fw-bold mb-2 {{ $tauxResolution >= 70 ? 'text-success' : ($tauxResolution >= 40 ? 'text-warning' : 'text-danger') }}">
                    {{ $tauxResolution }}%
                </div>
                <p class="text-muted">des signalements resolus</p>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-success" style="width: {{ $tauxResolution }}%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-flag me-2"></i>Par priorite</div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3"><span><span class="badge bg-info">Faible</span></span><strong>{{ $parPriorite['faible'] }}</strong></div>
                <div class="d-flex justify-content-between align-items-center mb-3"><span><span class="badge bg-primary">Moyenne</span></span><strong>{{ $parPriorite['moyenne'] }}</strong></div>
                <div class="d-flex justify-content-between align-items-center mb-3"><span><span class="badge bg-warning text-dark">Haute</span></span><strong>{{ $parPriorite['haute'] }}</strong></div>
                <div class="d-flex justify-content-between align-items-center"><span><span class="badge bg-danger">Urgente</span></span><strong>{{ $parPriorite['urgente'] }}</strong></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-tags me-2"></i>Par categorie</div>
            <div class="card-body">
                @forelse($parCategorie as $cat)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $cat->nom }}</span>
                        <span class="badge bg-secondary rounded-pill">{{ $cat->signalements_count }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Aucune donnee</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar2-week me-2"></i>Prochaines reservations</span>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Terrain</th>
                            <th>Client</th>
                            <th>Debut</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($prochainesReservations as $reservation)
                        <tr>
                            <td><code>{{ $reservation->reference }}</code></td>
                            <td>{{ $reservation->terrain?->nom ?? '-' }}</td>
                            <td>{{ $reservation->client_nom }}</td>
                            <td>{{ $reservation->debut->format('d/m H:i') }}</td>
                            <td><span class="badge bg-{{ $reservation->statut_badge }}">{{ $reservation->statut_label }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucune reservation a venir</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-credit-card me-2"></i>Paiements recents</span>
                <a href="{{ route('admin.paiements.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Reservation</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($paiementsRecents as $paiement)
                        <tr>
                            <td><code>{{ $paiement->reference }}</code></td>
                            <td>{{ $paiement->reservation?->reference ?? '-' }}</td>
                            <td>{{ number_format($paiement->montant, 2, ',', ' ') }} MAD</td>
                            <td><span class="badge bg-{{ $paiement->statut_badge }}">{{ $paiement->statut_label }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Aucun paiement</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if($urgents->count() > 0)
<div class="card mb-4 border-danger">
    <div class="card-header text-danger">
        <i class="bi bi-exclamation-octagon me-2"></i>Signalements urgents non resolus ({{ $urgents->count() }})
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Titre</th>
                    <th>Categorie</th>
                    <th>Adresse</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($urgents as $sig)
                <tr>
                    <td><code>{{ $sig->reference }}</code></td>
                    <td>{{ \Illuminate\Support\Str::limit($sig->titre, 30) }}</td>
                    <td>{{ $sig->categorie->nom }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($sig->adresse, 25) }}</td>
                    <td><span class="badge bg-{{ $sig->statut_badge }}">{{ $sig->statut_label }}</span></td>
                    <td>{{ $sig->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('admin.signalements.show', $sig) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2"></i>Derniers signalements</span>
        <a href="{{ route('admin.signalements.index') }}" class="btn btn-sm btn-outline-primary">Voir tout</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Titre</th>
                    <th>Categorie</th>
                    <th>Priorite</th>
                    <th>Statut</th>
                    <th>Signale par</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($derniers as $sig)
                <tr>
                    <td><code>{{ $sig->reference }}</code></td>
                    <td>{{ \Illuminate\Support\Str::limit($sig->titre, 30) }}</td>
                    <td>{{ $sig->categorie->nom }}</td>
                    <td><span class="badge bg-{{ $sig->priorite_badge }}">{{ ucfirst($sig->priorite) }}</span></td>
                    <td><span class="badge bg-{{ $sig->statut_badge }}">{{ $sig->statut_label }}</span></td>
                    <td>{{ $sig->signale_par }}</td>
                    <td>{{ $sig->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.signalements.show', $sig) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Aucun signalement pour le moment</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

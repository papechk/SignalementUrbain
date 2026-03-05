@extends('layouts.admin')

@section('title', 'Reservations')

@section('breadcrumb')
<li class="breadcrumb-item active">Reservations</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-calendar2-check me-2"></i>Gestion des reservations</h2>
        <p class="text-muted mb-0">CRUD complet, confirmation et annulation</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reservations.calendar') }}" class="btn btn-outline-primary">
            <i class="bi bi-calendar3 me-1"></i> Calendrier
        </a>
        <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nouvelle reservation
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form class="row g-2">
            <div class="col-md-4">
                <input type="text" class="form-control" name="recherche" value="{{ request('recherche') }}" placeholder="Reference, client...">
            </div>
            <div class="col-md-3">
                <select name="terrain_id" class="form-select">
                    <option value="">Tous les terrains</option>
                    @foreach($terrains as $terrain)
                        <option value="{{ $terrain->id }}" @selected((string) request('terrain_id') === (string) $terrain->id)>{{ $terrain->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="statut" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" @selected(request('statut') === 'en_attente')>En attente</option>
                    <option value="confirmee" @selected(request('statut') === 'confirmee')>Confirmee</option>
                    <option value="annulee" @selected(request('statut') === 'annulee')>Annulee</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-outline-primary w-100">Filtrer</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Terrain</th>
                    <th>Client</th>
                    <th>Debut</th>
                    <th>Fin</th>
                    <th>Montant</th>
                    <th>Paiement</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td><code>{{ $reservation->reference }}</code></td>
                    <td>{{ $reservation->terrain?->nom ?? '-' }}</td>
                    <td>{{ $reservation->client_nom }}</td>
                    <td>{{ $reservation->debut->format('d/m/Y H:i') }}</td>
                    <td>{{ $reservation->fin->format('d/m/Y H:i') }}</td>
                    <td>{{ number_format($reservation->montant_total, 2, ',', ' ') }} MAD</td>
                    <td>
                        @if($reservation->paiement)
                            <span class="badge bg-{{ $reservation->paiement->statut_badge }}">{{ $reservation->paiement->statut_label }}</span>
                        @else
                            <span class="badge bg-secondary">Aucun</span>
                        @endif
                    </td>
                    <td><span class="badge bg-{{ $reservation->statut_badge }}">{{ $reservation->statut_label }}</span></td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.reservations.show', $reservation) }}"><i class="bi bi-eye"></i></a>
                        <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.reservations.edit', $reservation) }}"><i class="bi bi-pencil"></i></a>

                        @if($reservation->statut !== 'confirmee')
                            <form method="POST" action="{{ route('admin.reservations.confirmer', $reservation) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-success" title="Confirmer"><i class="bi bi-check2-circle"></i></button>
                            </form>
                        @endif

                        @if($reservation->statut !== 'annulee')
                            <form method="POST" action="{{ route('admin.reservations.annuler', $reservation) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-outline-danger" title="Annuler"><i class="bi bi-x-circle"></i></button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.reservations.destroy', $reservation) }}" class="d-inline" onsubmit="return confirm('Supprimer cette reservation ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Aucune reservation</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($reservations->hasPages())
        <div class="card-body border-top">{{ $reservations->links() }}</div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Detail reservation')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}" class="text-decoration-none">Reservations</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-calendar2-check me-2"></i>{{ $reservation->reference }}</h2>
        <p class="text-muted mb-0">{{ $reservation->client_nom }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Modifier</a>
        @if($reservation->statut !== 'confirmee')
            <form method="POST" action="{{ route('admin.reservations.confirmer', $reservation) }}" class="d-inline">
                @csrf @method('PATCH')
                <button class="btn btn-success"><i class="bi bi-check2-circle me-1"></i> Confirmer</button>
            </form>
        @endif
        @if($reservation->statut !== 'annulee')
            <form method="POST" action="{{ route('admin.reservations.annuler', $reservation) }}" class="d-inline">
                @csrf @method('PATCH')
                <button class="btn btn-danger"><i class="bi bi-x-circle me-1"></i> Annuler</button>
            </form>
        @endif
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">Retour</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-info-circle me-1"></i> Informations</div>
            <div class="card-body">
                <p class="mb-2"><strong>Reference :</strong> <code>{{ $reservation->reference }}</code></p>
                <p class="mb-2"><strong>Terrain :</strong> {{ $reservation->terrain?->nom ?? '—' }}</p>
                <p class="mb-2"><strong>Debut :</strong> {{ $reservation->debut->format('d/m/Y H:i') }}</p>
                <p class="mb-2"><strong>Fin :</strong> {{ $reservation->fin->format('d/m/Y H:i') }}</p>
                <p class="mb-2"><strong>Duree :</strong> {{ $reservation->debut->diffForHumans($reservation->fin, true) }}</p>
                <p class="mb-2"><strong>Montant :</strong> {{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</p>
                <p class="mb-0"><strong>Statut :</strong>
                    <span class="badge bg-{{ $reservation->statut_badge }}">{{ $reservation->statut_label }}</span>
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="bi bi-person me-1"></i> Client</div>
            <div class="card-body">
                <p class="mb-2"><strong>Nom :</strong> {{ $reservation->client_nom }}</p>
                <p class="mb-2"><strong>Email :</strong> {{ $reservation->client_email ?: '—' }}</p>
                <p class="mb-0"><strong>Telephone :</strong> {{ $reservation->client_telephone ?: '—' }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-credit-card me-1"></i> Paiement</div>
            <div class="card-body">
                @if($reservation->paiement)
                    <p class="mb-2"><strong>Reference :</strong> <code>{{ $reservation->paiement->reference }}</code></p>
                    <p class="mb-2"><strong>Montant :</strong> {{ number_format($reservation->paiement->montant, 0, ',', ' ') }} FCFA</p>
                    <p class="mb-2"><strong>Mode :</strong> {{ ucfirst(str_replace('_', ' ', $reservation->paiement->mode_paiement)) }}</p>
                    <p class="mb-2"><strong>Statut :</strong>
                        <span class="badge bg-{{ $reservation->paiement->statut_badge }}">{{ $reservation->paiement->statut_label }}</span>
                    </p>
                    <p class="mb-0"><strong>Date :</strong> {{ $reservation->paiement->date_paiement?->format('d/m/Y H:i') ?? '—' }}</p>
                    <hr>
                    <a href="{{ route('admin.paiements.edit', $reservation->paiement) }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i> Modifier le paiement
                    </a>
                @else
                    <p class="text-muted mb-3">Aucun paiement enregistre</p>
                    <a href="{{ route('admin.paiements.create', ['reservation_id' => $reservation->id]) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Creer un paiement
                    </a>
                @endif
            </div>
        </div>

        @if($reservation->notes)
        <div class="card">
            <div class="card-header"><i class="bi bi-journal-text me-1"></i> Notes</div>
            <div class="card-body">{{ $reservation->notes }}</div>
        </div>
        @endif
    </div>
</div>
@endsection

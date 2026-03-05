@extends('layouts.admin')

@section('title', 'Detail terrain')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.terrains.index') }}" class="text-decoration-none">Terrains</a></li>
<li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-grid me-2"></i>{{ $terrain->nom }}</h2>
        <p class="text-muted mb-0">{{ $terrain->adresse }} {{ $terrain->ville ? '- '.$terrain->ville : '' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.terrains.edit', $terrain) }}" class="btn btn-warning"><i class="bi bi-pencil me-1"></i> Modifier</a>
        <a href="{{ route('admin.terrains.index') }}" class="btn btn-outline-secondary">Retour</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">Informations</div>
            <div class="card-body">
                <p class="mb-2"><strong>Type:</strong> {{ $terrain->type_label }}</p>
                <p class="mb-2"><strong>Surface:</strong> {{ $terrain->surface }}</p>
                <p class="mb-2"><strong>Capacite:</strong> {{ $terrain->capacite ?: '-' }}</p>
                <p class="mb-2"><strong>Prix/h:</strong> {{ number_format($terrain->prix_heure, 2, ',', ' ') }} MAD</p>
                <p class="mb-2"><strong>Proprietaire:</strong> {{ $terrain->proprietaire?->name ?: '-' }}</p>
                <p class="mb-0"><strong>Etat:</strong> <span class="badge bg-{{ $terrain->actif ? 'success' : 'secondary' }}">{{ $terrain->actif ? 'Actif' : 'Inactif' }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">Dernieres reservations</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Client</th>
                            <th>Debut</th>
                            <th>Fin</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($terrain->reservations as $reservation)
                            <tr>
                                <td><code>{{ $reservation->reference }}</code></td>
                                <td>{{ $reservation->client_nom }}</td>
                                <td>{{ $reservation->debut->format('d/m/Y H:i') }}</td>
                                <td>{{ $reservation->fin->format('d/m/Y H:i') }}</td>
                                <td><span class="badge bg-{{ $reservation->statut_badge }}">{{ $reservation->statut_label }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Aucune reservation</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

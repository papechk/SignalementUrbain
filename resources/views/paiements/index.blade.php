@extends('layouts.admin')

@section('title', 'Paiements')

@section('breadcrumb')
<li class="breadcrumb-item active">Paiements</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-credit-card me-2"></i>Gestion des paiements</h2>
        <p class="text-muted mb-0">Suivi des paiements lies aux reservations</p>
    </div>
    <a href="{{ route('admin.paiements.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouveau paiement
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form class="row g-2">
            <div class="col-md-5">
                <input type="text" class="form-control" name="recherche" value="{{ request('recherche') }}" placeholder="Reference, transaction, client...">
            </div>
            <div class="col-md-4">
                <select name="statut" class="form-select">
                    <option value="">Tous les statuts</option>
                    @foreach(['en_attente' => 'En attente', 'partiel' => 'Partiel', 'paye' => 'Payé', 'rembourse' => 'Remboursé', 'echec' => 'Échec'] as $val => $label)
                        <option value="{{ $val }}" @selected(request('statut') === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
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
                    <th>Reservation</th>
                    <th>Client</th>
                    <th>Montant</th>
                    <th>Mode</th>
                    <th>Statut</th>
                    <th>Date paiement</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($paiements as $paiement)
                <tr>
                    <td><code>{{ $paiement->reference }}</code></td>
                    <td><code>{{ $paiement->reservation?->reference ?? '—' }}</code></td>
                    <td>{{ $paiement->reservation?->client_nom ?? '—' }}</td>
                    <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</td>
                    <td><span class="badge bg-{{ $paiement->statut_badge }}">{{ $paiement->statut_label }}</span></td>
                    <td>{{ $paiement->date_paiement?->format('d/m/Y H:i') ?? '—' }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.paiements.edit', $paiement) }}"><i class="bi bi-pencil"></i></a>

                        @if($paiement->statut !== 'paye')
                            <form method="POST" action="{{ route('admin.paiements.updateStatut', $paiement) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="statut" value="paye">
                                <button class="btn btn-sm btn-outline-success" title="Marquer payé"><i class="bi bi-check2-circle"></i></button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.paiements.destroy', $paiement) }}" class="d-inline"
                              onsubmit="return confirm('Supprimer ce paiement ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Aucun paiement enregistre</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($paiements->hasPages())
        <div class="card-footer">{{ $paiements->links() }}</div>
    @endif
</div>
@endsection

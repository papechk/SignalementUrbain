@extends('layouts.admin')

@section('title', 'Liste des signalements')

@section('breadcrumb')
<li class="breadcrumb-item active">Signalements</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-exclamation-triangle me-2"></i>Signalements</h2>
        <p class="text-muted mb-0">Gestion de tous les signalements urbains</p>
    </div>
    <a href="{{ route('admin.signalements.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouveau signalement
    </a>
</div>

<!-- Filtres -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.signalements.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Recherche</label>
                <input type="text" name="recherche" class="form-control" placeholder="Titre, référence, adresse..."
                       value="{{ request('recherche') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Statut</label>
                <select name="statut" class="form-select">
                    <option value="">Tous</option>
                    <option value="nouveau" {{ request('statut') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                    <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="resolu" {{ request('statut') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                    <option value="rejete" {{ request('statut') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Priorité</label>
                <select name="priorite" class="form-select">
                    <option value="">Toutes</option>
                    <option value="faible" {{ request('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                    <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                    <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                    <option value="urgente" {{ request('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Catégorie</label>
                <select name="categorie_id" class="form-select">
                    <option value="">Toutes</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-1"></i> Filtrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Liste des signalements -->
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Réf.</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Adresse</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Signalé par</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($signalements as $sig)
                <tr>
                    <td><code>{{ $sig->reference }}</code></td>
                    <td>
                        <a href="{{ route('admin.signalements.show', $sig) }}" class="text-decoration-none fw-semibold">
                            {{ Str::limit($sig->titre, 30) }}
                        </a>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $sig->categorie->nom }}</span>
                    </td>
                    <td>{{ Str::limit($sig->adresse, 25) }}</td>
                    <td>
                        <span class="badge bg-{{ $sig->priorite_badge }}">
                            {{ ucfirst($sig->priorite) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $sig->statut_badge }}">
                            {{ $sig->statut_label }}
                        </span>
                    </td>
                    <td>{{ $sig->signale_par }}</td>
                    <td>{{ $sig->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.signalements.show', $sig) }}" class="btn btn-outline-primary" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.signalements.edit', $sig) }}" class="btn btn-outline-warning" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.signalements.destroy', $sig) }}" method="POST"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce signalement ?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Aucun signalement trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($signalements->hasPages())
    <div class="card-footer">
        {{ $signalements->links() }}
    </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Terrains')

@section('breadcrumb')
<li class="breadcrumb-item active">Terrains</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-grid me-2"></i>Gestion des terrains</h2>
        <p class="text-muted mb-0">CRUD admin/proprietaire</p>
    </div>
    <a href="{{ route('admin.terrains.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouveau terrain
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form class="row g-2">
            <div class="col-md-5">
                <input type="text" class="form-control" name="recherche" value="{{ request('recherche') }}" placeholder="Nom, adresse, ville...">
            </div>
            <div class="col-md-3">
                <select name="actif" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="1" @selected(request('actif') === '1')>Actifs</option>
                    <option value="0" @selected(request('actif') === '0')>Inactifs</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search me-1"></i> Filtrer</button>
                <a href="{{ route('admin.terrains.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Prix/h</th>
                    <th>Ville</th>
                    <th>Proprietaire</th>
                    <th>Etat</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($terrains as $terrain)
                <tr>
                    <td>{{ $terrain->nom }}</td>
                    <td>{{ $terrain->type_label }}</td>
                    <td>{{ number_format($terrain->prix_heure, 2, ',', ' ') }} MAD</td>
                    <td>{{ $terrain->ville ?: '-' }}</td>
                    <td>{{ $terrain->proprietaire?->name ?: '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $terrain->actif ? 'success' : 'secondary' }}">
                            {{ $terrain->actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.terrains.show', $terrain) }}"><i class="bi bi-eye"></i></a>
                        <a class="btn btn-sm btn-outline-warning" href="{{ route('admin.terrains.edit', $terrain) }}"><i class="bi bi-pencil"></i></a>
                        <form method="POST" action="{{ route('admin.terrains.destroy', $terrain) }}" class="d-inline" onsubmit="return confirm('Supprimer ce terrain ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucun terrain</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($terrains->hasPages())
        <div class="card-body border-top">{{ $terrains->links() }}</div>
    @endif
</div>
@endsection

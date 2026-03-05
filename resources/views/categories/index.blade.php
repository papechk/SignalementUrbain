@extends('layouts.admin')

@section('title', 'Catégories')

@section('breadcrumb')
<li class="breadcrumb-item active">Catégories</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-tags me-2"></i>Catégories</h2>
        <p class="text-muted mb-0">Gestion des catégories de signalement</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nouvelle catégorie
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Icône</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Signalements</th>
                    <th>État</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td>
                        @if($cat->icone)
                            <i class="bi bi-{{ $cat->icone }} fs-5"></i>
                        @else
                            <i class="bi bi-tag fs-5 text-muted"></i>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $cat->nom }}</td>
                    <td>{{ Str::limit($cat->description, 50) }}</td>
                    <td>
                        <span class="badge bg-secondary rounded-pill">{{ $cat->signalements_count }}</span>
                    </td>
                    <td>
                        @if($cat->actif)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-outline-warning" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                                  onsubmit="return confirm('Supprimer cette catégorie ?')" class="d-inline">
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
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Aucune catégorie créée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

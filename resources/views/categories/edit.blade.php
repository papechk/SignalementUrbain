@extends('layouts.admin')

@section('title', 'Modifier la catégorie')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Catégories</a></li>
<li class="breadcrumb-item active">Modifier</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-pencil me-2"></i>Modifier la catégorie</h2>
    <p class="text-muted">{{ $categorie->nom }}</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $categorie) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nom" class="form-label fw-bold">Nom de la catégorie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror"
                               id="nom" name="nom" value="{{ old('nom', $categorie->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icone" class="form-label fw-bold">Icône Bootstrap Icons</label>
                        <input type="text" class="form-control @error('icone') is-invalid @enderror"
                               id="icone" name="icone" value="{{ old('icone', $categorie->icone) }}"
                               placeholder="Ex: cone-striped, lightbulb, trash...">
                        @error('icone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description', $categorie->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1"
                                   {{ old('actif', $categorie->actif) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="actif">Catégorie active</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle me-1"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

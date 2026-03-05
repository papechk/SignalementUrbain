@extends('layouts.admin')

@section('title', 'Nouvelle catégorie')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Catégories</a></li>
<li class="breadcrumb-item active">Nouvelle</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-plus-circle me-2"></i>Nouvelle catégorie</h2>
    <p class="text-muted">Ajouter une catégorie de signalement</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nom" class="form-label fw-bold">Nom de la catégorie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror"
                               id="nom" name="nom" value="{{ old('nom') }}"
                               placeholder="Ex: Voirie, Éclairage public, Propreté..." required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icone" class="form-label fw-bold">Icône Bootstrap Icons</label>
                        <input type="text" class="form-control @error('icone') is-invalid @enderror"
                               id="icone" name="icone" value="{{ old('icone') }}"
                               placeholder="Ex: cone-striped, lightbulb, trash, tree...">
                        <div class="form-text">
                            Nom de l'icône sans le préfixe "bi-".
                            <a href="https://icons.getbootstrap.com/" target="_blank">Voir les icônes disponibles</a>
                        </div>
                        @error('icone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Description de la catégorie...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1"
                                   {{ old('actif', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="actif">Catégorie active</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between border-top pt-3">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Créer la catégorie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

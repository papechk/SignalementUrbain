@extends('layouts.admin')

@section('title', 'Nouveau signalement')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.signalements.index') }}">Signalements</a></li>
<li class="breadcrumb-item active">Nouveau</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-plus-circle me-2"></i>Nouveau signalement</h2>
    <p class="text-muted">Signaler un problème urbain à la mairie</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.signalements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <!-- Informations du signalement -->
                <div class="col-12">
                    <h5 class="text-primary border-bottom pb-2">
                        <i class="bi bi-info-circle me-2"></i>Informations du signalement
                    </h5>
                </div>

                <div class="col-md-8">
                    <label for="titre" class="form-label fw-bold">Titre du signalement <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('titre') is-invalid @enderror"
                           id="titre" name="titre" value="{{ old('titre') }}"
                           placeholder="Ex: Nid-de-poule avenue de la République" required>
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="categorie_id" class="form-label fw-bold">Catégorie <span class="text-danger">*</span></label>
                    <select class="form-select @error('categorie_id') is-invalid @enderror"
                            id="categorie_id" name="categorie_id" required>
                        <option value="">-- Choisir --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-bold">Description détaillée <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4"
                              placeholder="Décrivez le problème en détail..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="priorite" class="form-label fw-bold">Priorité <span class="text-danger">*</span></label>
                    <select class="form-select @error('priorite') is-invalid @enderror"
                            id="priorite" name="priorite" required>
                        <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                        <option value="moyenne" {{ old('priorite', 'moyenne') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                        <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    @error('priorite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8">
                    <label for="photo" class="form-label fw-bold">Photo (optionnel)</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                           id="photo" name="photo" accept="image/*">
                    <div class="form-text">Formats acceptés : JPEG, PNG, GIF. Max : 2 Mo</div>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Localisation -->
                <div class="col-12 mt-4">
                    <h5 class="text-primary border-bottom pb-2">
                        <i class="bi bi-geo-alt me-2"></i>Localisation
                    </h5>
                </div>

                <div class="col-md-8">
                    <label for="adresse" class="form-label fw-bold">Adresse <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('adresse') is-invalid @enderror"
                           id="adresse" name="adresse" value="{{ old('adresse') }}"
                           placeholder="Ex: 12 Rue de la Paix" required>
                    @error('adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="quartier" class="form-label fw-bold">Quartier</label>
                    <input type="text" class="form-control @error('quartier') is-invalid @enderror"
                           id="quartier" name="quartier" value="{{ old('quartier') }}"
                           placeholder="Ex: Centre-ville">
                    @error('quartier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Coordonnées du signaleur -->
                <div class="col-12 mt-4">
                    <h5 class="text-primary border-bottom pb-2">
                        <i class="bi bi-person me-2"></i>Vos coordonnées
                    </h5>
                </div>

                <div class="col-md-4">
                    <label for="signale_par" class="form-label fw-bold">Nom complet <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('signale_par') is-invalid @enderror"
                           id="signale_par" name="signale_par" value="{{ old('signale_par') }}"
                           placeholder="Votre nom" required>
                    @error('signale_par')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email_signaleur" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control @error('email_signaleur') is-invalid @enderror"
                           id="email_signaleur" name="email_signaleur" value="{{ old('email_signaleur') }}"
                           placeholder="votre@email.com">
                    @error('email_signaleur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="telephone_signaleur" class="form-label fw-bold">Téléphone</label>
                    <input type="text" class="form-control @error('telephone_signaleur') is-invalid @enderror"
                           id="telephone_signaleur" name="telephone_signaleur" value="{{ old('telephone_signaleur') }}"
                           placeholder="Ex: 06 12 34 56 78">
                    @error('telephone_signaleur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Boutons -->
            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                <a href="{{ route('admin.signalements.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Annuler
                </a>
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-send me-1"></i> Envoyer le signalement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

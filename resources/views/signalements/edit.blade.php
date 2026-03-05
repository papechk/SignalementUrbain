@extends('layouts.admin')

@section('title', 'Modifier - ' . $signalement->reference)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.signalements.index') }}">Signalements</a></li>
<li class="breadcrumb-item active">Modifier {{ $signalement->reference }}</li>
@endsection

@section('content')
<div class="page-header">
    <h2><i class="bi bi-pencil me-2"></i>Modifier le signalement {{ $signalement->reference }}</h2>
    <p class="text-muted">Mettre à jour les informations du signalement</p>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.signalements.update', $signalement) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- Informations du signalement -->
                <div class="col-12">
                    <h5 class="text-primary border-bottom pb-2">
                        <i class="bi bi-info-circle me-2"></i>Informations du signalement
                    </h5>
                </div>

                <div class="col-md-6">
                    <label for="titre" class="form-label fw-bold">Titre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('titre') is-invalid @enderror"
                           id="titre" name="titre" value="{{ old('titre', $signalement->titre) }}" required>
                    @error('titre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="categorie_id" class="form-label fw-bold">Catégorie <span class="text-danger">*</span></label>
                    <select class="form-select @error('categorie_id') is-invalid @enderror"
                            id="categorie_id" name="categorie_id" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('categorie_id', $signalement->categorie_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('categorie_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="statut" class="form-label fw-bold">Statut <span class="text-danger">*</span></label>
                    <select class="form-select @error('statut') is-invalid @enderror"
                            id="statut" name="statut" required>
                        <option value="nouveau" {{ old('statut', $signalement->statut) == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                        <option value="en_cours" {{ old('statut', $signalement->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="resolu" {{ old('statut', $signalement->statut) == 'resolu' ? 'selected' : '' }}>Résolu</option>
                        <option value="rejete" {{ old('statut', $signalement->statut) == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4" required>{{ old('description', $signalement->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="priorite" class="form-label fw-bold">Priorité <span class="text-danger">*</span></label>
                    <select class="form-select @error('priorite') is-invalid @enderror"
                            id="priorite" name="priorite" required>
                        <option value="faible" {{ old('priorite', $signalement->priorite) == 'faible' ? 'selected' : '' }}>Faible</option>
                        <option value="moyenne" {{ old('priorite', $signalement->priorite) == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="haute" {{ old('priorite', $signalement->priorite) == 'haute' ? 'selected' : '' }}>Haute</option>
                        <option value="urgente" {{ old('priorite', $signalement->priorite) == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    @error('priorite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-8">
                    <label for="photo" class="form-label fw-bold">Photo</label>
                    @if($signalement->photo)
                        <div class="mb-2">
                            <img src="{{ asset($signalement->photo) }}" alt="Photo actuelle"
                                 class="img-thumbnail" style="max-height: 100px;">
                            <small class="text-muted d-block">Photo actuelle</small>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                           id="photo" name="photo" accept="image/*">
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
                           id="adresse" name="adresse" value="{{ old('adresse', $signalement->adresse) }}" required>
                    @error('adresse')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="quartier" class="form-label fw-bold">Quartier</label>
                    <input type="text" class="form-control @error('quartier') is-invalid @enderror"
                           id="quartier" name="quartier" value="{{ old('quartier', $signalement->quartier) }}">
                    @error('quartier')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Coordonnées du signaleur -->
                <div class="col-12 mt-4">
                    <h5 class="text-primary border-bottom pb-2">
                        <i class="bi bi-person me-2"></i>Coordonnées du signaleur
                    </h5>
                </div>

                <div class="col-md-4">
                    <label for="signale_par" class="form-label fw-bold">Nom <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('signale_par') is-invalid @enderror"
                           id="signale_par" name="signale_par" value="{{ old('signale_par', $signalement->signale_par) }}" required>
                    @error('signale_par')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="email_signaleur" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control @error('email_signaleur') is-invalid @enderror"
                           id="email_signaleur" name="email_signaleur" value="{{ old('email_signaleur', $signalement->email_signaleur) }}">
                    @error('email_signaleur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="telephone_signaleur" class="form-label fw-bold">Téléphone</label>
                    <input type="text" class="form-control @error('telephone_signaleur') is-invalid @enderror"
                           id="telephone_signaleur" name="telephone_signaleur" value="{{ old('telephone_signaleur', $signalement->telephone_signaleur) }}">
                    @error('telephone_signaleur')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Commentaire mairie -->
                <div class="col-12 mt-4">
                    <h5 class="text-primary border-bottom pb-2">
                        <i class="bi bi-building me-2"></i>Réponse de la mairie
                    </h5>
                </div>

                <div class="col-12">
                    <label for="commentaire_mairie" class="form-label fw-bold">Commentaire de la mairie</label>
                    <textarea class="form-control @error('commentaire_mairie') is-invalid @enderror"
                              id="commentaire_mairie" name="commentaire_mairie"
                              rows="3" placeholder="Ajouter un commentaire de suivi...">{{ old('commentaire_mairie', $signalement->commentaire_mairie) }}</textarea>
                    @error('commentaire_mairie')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Boutons -->
            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                <a href="{{ route('admin.signalements.show', $signalement) }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Annuler
                </a>
                <button type="submit" class="btn btn-warning btn-lg">
                    <i class="bi bi-check-circle me-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

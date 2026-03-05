@extends('layouts.admin')

@section('title', 'Signalement ' . $signalement->reference)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.signalements.index') }}">Signalements</a></li>
<li class="breadcrumb-item active">{{ $signalement->reference }}</li>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="bi bi-eye me-2"></i>Signalement {{ $signalement->reference }}</h2>
        <p class="text-muted mb-0">Détails complets du signalement</p>
    </div>
    <div>
        <a href="{{ route('admin.signalements.edit', $signalement) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i> Modifier
        </a>
        <a href="{{ route('admin.signalements.index') }}" class="btn btn-outline-secondary ms-2">
            <i class="bi bi-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Colonne principale -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">{{ $signalement->titre }}</span>
                <div>
                    <span class="badge bg-{{ $signalement->priorite_badge }} me-1">
                        <i class="bi bi-flag me-1"></i>{{ ucfirst($signalement->priorite) }}
                    </span>
                    <span class="badge bg-{{ $signalement->statut_badge }}">
                        {{ $signalement->statut_label }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <h6 class="text-primary">Description</h6>
                <p>{{ $signalement->description }}</p>

                @if($signalement->photo)
                    <h6 class="text-primary mt-4">Photo</h6>
                    <img src="{{ asset($signalement->photo) }}" alt="Photo du signalement"
                         class="img-fluid rounded" style="max-height: 400px;">
                @endif

                @if($signalement->commentaire_mairie)
                    <h6 class="text-primary mt-4">Commentaire de la mairie</h6>
                    <div class="alert alert-info">
                        <i class="bi bi-chat-left-text me-2"></i>{{ $signalement->commentaire_mairie }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Changer le statut rapidement -->
        <div class="card">
            <div class="card-header fw-bold">
                <i class="bi bi-arrow-repeat me-2"></i>Changer le statut
            </div>
            <div class="card-body">
                <form action="{{ route('admin.signalements.changerStatut', $signalement) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <select name="statut" class="form-select">
                                <option value="nouveau" {{ $signalement->statut == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                                <option value="en_cours" {{ $signalement->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="resolu" {{ $signalement->statut == 'resolu' ? 'selected' : '' }}>Résolu</option>
                                <option value="rejete" {{ $signalement->statut == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="commentaire_mairie" class="form-control"
                                   placeholder="Commentaire de la mairie (optionnel)"
                                   value="{{ $signalement->commentaire_mairie }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-check2"></i> Valider
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Colonne latérale -->
    <div class="col-md-4">
        <!-- Informations -->
        <div class="card mb-4">
            <div class="card-header fw-bold">
                <i class="bi bi-info-circle me-2"></i>Informations
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <td class="text-muted fw-bold">Référence</td>
                        <td><code>{{ $signalement->reference }}</code></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Catégorie</td>
                        <td><span class="badge bg-secondary">{{ $signalement->categorie->nom }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Priorité</td>
                        <td><span class="badge bg-{{ $signalement->priorite_badge }}">{{ ucfirst($signalement->priorite) }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Statut</td>
                        <td><span class="badge bg-{{ $signalement->statut_badge }}">{{ $signalement->statut_label }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Créé le</td>
                        <td>{{ $signalement->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-bold">Mis à jour</td>
                        <td>{{ $signalement->updated_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                    @if($signalement->date_resolution)
                    <tr>
                        <td class="text-muted fw-bold">Résolu le</td>
                        <td class="text-success fw-bold">{{ $signalement->date_resolution->format('d/m/Y à H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Localisation -->
        <div class="card mb-4">
            <div class="card-header fw-bold">
                <i class="bi bi-geo-alt me-2"></i>Localisation
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Adresse :</strong> {{ $signalement->adresse }}</p>
                @if($signalement->quartier)
                    <p class="mb-0"><strong>Quartier :</strong> {{ $signalement->quartier }}</p>
                @endif
            </div>
        </div>

        <!-- Signaleur -->
        <div class="card mb-4">
            <div class="card-header fw-bold">
                <i class="bi bi-person me-2"></i>Signalé par
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Nom :</strong> {{ $signalement->signale_par }}</p>
                @if($signalement->email_signaleur)
                    <p class="mb-1"><strong>Email :</strong> {{ $signalement->email_signaleur }}</p>
                @endif
                @if($signalement->telephone_signaleur)
                    <p class="mb-0"><strong>Tél :</strong> {{ $signalement->telephone_signaleur }}</p>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="card border-danger">
            <div class="card-header fw-bold text-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>Zone dangereuse
            </div>
            <div class="card-body">
                <form action="{{ route('admin.signalements.destroy', $signalement) }}" method="POST"
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce signalement ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-1"></i> Supprimer ce signalement
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

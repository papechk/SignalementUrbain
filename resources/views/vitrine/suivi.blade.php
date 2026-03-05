@extends('layouts.vitrine')

@section('title', 'Suivre mon signalement')

@section('content')
<section style="padding: 3rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="text-center mb-5">
                    <div style="font-size:3rem;color:var(--primary);margin-bottom:1rem;">
                        <i class="bi bi-search"></i>
                    </div>
                    <h2 class="section-title">Suivre mon signalement</h2>
                    <p class="section-subtitle mb-0">
                        Entrez la référence de votre signalement (ex: SIG-XXXXXXXX)
                        pour consulter son état d'avancement.
                    </p>
                </div>

                <!-- Formulaire de recherche -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
                    <div class="card-body p-4">
                        <form action="{{ route('vitrine.suivi') }}" method="GET">
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-hash text-primary"></i>
                                </span>
                                <input type="text" name="reference" class="form-control border-start-0"
                                       placeholder="Entrez votre référence SIG-..."
                                       value="{{ request('reference') }}" required
                                       style="font-family:monospace;letter-spacing:0.05em;">
                                <button type="submit" class="btn btn-primary-custom px-4">
                                    <i class="bi bi-search me-1"></i> Rechercher
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Résultat -->
                @if(request('reference'))
                    @if(isset($signalement) && $signalement)
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <code class="text-primary fs-5">{{ $signalement->reference }}</code>
                                    <h5 class="fw-bold mt-2 mb-1" style="color:var(--secondary);">{{ $signalement->titre }}</h5>
                                    <span class="sig-meta">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $signalement->adresse }}
                                        @if($signalement->quartier) — {{ $signalement->quartier }} @endif
                                    </span>
                                </div>
                                <span class="badge badge-{{ $signalement->statut }} fs-6 px-3 py-2 rounded-pill">
                                    {{ $signalement->statut_label }}
                                </span>
                            </div>

                            <hr>

                            <!-- Timeline -->
                            <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Suivi du traitement</h6>

                            <div class="position-relative ps-4" style="border-left:2px solid #e2e8f0;">
                                <!-- Créé -->
                                <div class="mb-4 position-relative" style="margin-left:-1.15rem;">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                                             style="width:32px;height:32px;min-width:32px;">
                                            <i class="bi bi-plus text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">Signalement enregistré</div>
                                            <div class="text-muted small">{{ $signalement->created_at->format('d/m/Y à H:i') }}</div>
                                            <div class="small mt-1">Catégorie : {{ $signalement->categorie->nom }} — Priorité : {{ ucfirst($signalement->priorite) }}</div>
                                        </div>
                                    </div>
                                </div>

                                @if(in_array($signalement->statut, ['en_cours', 'resolu']))
                                <div class="mb-4 position-relative" style="margin-left:-1.15rem;">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3"
                                             style="width:32px;height:32px;min-width:32px;">
                                            <i class="bi bi-gear text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">En cours de traitement</div>
                                            <div class="text-muted small">Pris en charge par les services municipaux</div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($signalement->statut === 'resolu')
                                <div class="mb-4 position-relative" style="margin-left:-1.15rem;">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-3"
                                             style="width:32px;height:32px;min-width:32px;">
                                            <i class="bi bi-check-lg text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-success">Problème résolu</div>
                                            <div class="text-muted small">
                                                {{ $signalement->date_resolution ? $signalement->date_resolution->format('d/m/Y à H:i') : 'Date non précisée' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if($signalement->statut === 'rejete')
                                <div class="mb-4 position-relative" style="margin-left:-1.15rem;">
                                    <div class="d-flex align-items-start">
                                        <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center me-3"
                                             style="width:32px;height:32px;min-width:32px;">
                                            <i class="bi bi-x-lg text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-danger">Signalement rejeté</div>
                                            <div class="text-muted small">Non pris en charge</div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($signalement->commentaire_mairie)
                            <hr>
                            <h6 class="fw-bold mb-2"><i class="bi bi-chat-left-text me-2 text-primary"></i>Réponse de la mairie</h6>
                            <div class="p-3 rounded-3" style="background:#eff6ff;border-left:4px solid var(--primary);">
                                {{ $signalement->commentaire_mairie }}
                            </div>
                            @endif

                            <div class="text-center mt-4">
                                <a href="{{ route('vitrine.signalement.detail', $signalement) }}" class="btn btn-outline-custom">
                                    <i class="bi bi-eye me-1"></i> Voir le détail complet
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-body p-5 text-center">
                            <div style="font-size:3rem;color:#e2e8f0;margin-bottom:1rem;">
                                <i class="bi bi-exclamation-circle"></i>
                            </div>
                            <h5 class="fw-bold" style="color:var(--secondary);">Signalement introuvable</h5>
                            <p class="text-muted mb-0">
                                Aucun signalement ne correspond à la référence
                                <code>{{ request('reference') }}</code>.<br>
                                Vérifiez la référence et réessayez.
                            </p>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

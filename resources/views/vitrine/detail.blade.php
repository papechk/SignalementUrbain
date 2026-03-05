@extends('layouts.vitrine')

@section('title', $signalement->titre)

@push('styles')
@if($signalement->latitude && $signalement->longitude)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>#detailMap { height: 200px; border-radius: 10px; margin-top: .75rem; }</style>
@endif
@endpush

@section('content')
<section style="padding: 3rem 0;">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('vitrine.signalements') }}" class="text-decoration-none text-muted">
                <i class="bi bi-arrow-left me-1"></i> Retour aux signalements
            </a>
        </div>

        <div class="row g-4">
            <!-- Contenu principal -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius:14px;">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge badge-{{ $signalement->statut }} rounded-pill px-3">
                                {{ $signalement->statut_label }}
                            </span>
                            <span class="badge badge-{{ $signalement->priorite }} rounded-pill px-3">
                                <i class="bi bi-flag me-1"></i>{{ ucfirst($signalement->priorite) }}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">
                                <i class="bi bi-tag me-1"></i>{{ $signalement->categorie->nom }}
                            </span>
                        </div>

                        <h3 class="fw-bold mb-3" style="color:var(--secondary);">{{ $signalement->titre }}</h3>

                        <div class="mb-4">
                            <h6 class="fw-bold text-muted text-uppercase small">Description</h6>
                            <p class="mb-0" style="line-height:1.7;">{{ $signalement->description }}</p>
                        </div>

                        @if($signalement->photo)
                        <div class="mb-4">
                            <h6 class="fw-bold text-muted text-uppercase small">Photo</h6>
                            <img src="{{ asset($signalement->photo) }}" alt="Photo du signalement"
                                 class="img-fluid rounded-3" style="max-height:400px;">
                        </div>
                        @endif

                        @if($signalement->commentaire_mairie)
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted text-uppercase small">Réponse de la mairie</h6>
                            <div class="p-3 rounded-3" style="background:#eff6ff;border-left:4px solid var(--primary);">
                                <i class="bi bi-building me-2 text-primary"></i>{{ $signalement->commentaire_mairie }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Informations -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Informations</h6>
                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td class="text-muted small fw-bold" style="width:40%;">Référence</td>
                                <td><code class="text-primary">{{ $signalement->reference }}</code></td>
                            </tr>
                            <tr>
                                <td class="text-muted small fw-bold">Date</td>
                                <td>{{ $signalement->created_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                            @if($signalement->date_resolution)
                            <tr>
                                <td class="text-muted small fw-bold">Résolu le</td>
                                <td class="text-success fw-bold">{{ $signalement->date_resolution->format('d/m/Y') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-muted small fw-bold">Signalé par</td>
                                <td>{{ $signalement->signale_par }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Localisation -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius:14px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2 text-primary"></i>Localisation</h6>
                        <p class="mb-1"><strong>{{ $signalement->adresse }}</strong></p>
                        @if($signalement->quartier)
                            <p class="text-muted small mb-0">Quartier : {{ $signalement->quartier }}</p>
                        @endif
                        @if($signalement->latitude && $signalement->longitude)
                            <div id="detailMap"></div>
                        @endif
                    </div>
                </div>

                <!-- Suivi -->
                <div class="card border-0 shadow-sm" style="border-radius:14px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-primary"></i>Historique</h6>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                                     style="width:28px;height:28px;min-width:28px;">
                                    <i class="bi bi-plus text-white" style="font-size:0.75rem;"></i>
                                </div>
                                <div>
                                    <div class="small fw-bold">Signalement créé</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $signalement->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>

                            @if($signalement->statut !== 'nouveau')
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3"
                                     style="width:28px;height:28px;min-width:28px;">
                                    <i class="bi bi-gear text-white" style="font-size:0.75rem;"></i>
                                </div>
                                <div>
                                    <div class="small fw-bold">Pris en charge</div>
                                    <div class="text-muted" style="font-size:0.75rem;">Par la mairie</div>
                                </div>
                            </div>
                            @endif

                            @if($signalement->statut === 'resolu')
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-3"
                                     style="width:28px;height:28px;min-width:28px;">
                                    <i class="bi bi-check text-white" style="font-size:0.75rem;"></i>
                                </div>
                                <div>
                                    <div class="small fw-bold text-success">Résolu</div>
                                    <div class="text-muted" style="font-size:0.75rem;">
                                        {{ $signalement->date_resolution ? $signalement->date_resolution->format('d/m/Y H:i') : '' }}
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($signalement->statut === 'rejete')
                            <div class="d-flex align-items-start">
                                <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center me-3"
                                     style="width:28px;height:28px;min-width:28px;">
                                    <i class="bi bi-x text-white" style="font-size:0.75rem;"></i>
                                </div>
                                <div>
                                    <div class="small fw-bold text-danger">Rejeté</div>
                                    <div class="text-muted" style="font-size:0.75rem;">Non pris en charge</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@if($signalement->latitude && $signalement->longitude)
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('detailMap').setView([{{ $signalement->latitude }}, {{ $signalement->longitude }}], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap', maxZoom: 19
    }).addTo(map);
    L.marker([{{ $signalement->latitude }}, {{ $signalement->longitude }}]).addTo(map)
     .bindPopup('<strong>{{ addslashes($signalement->titre) }}</strong>').openPopup();
});
</script>
@endpush
@endif

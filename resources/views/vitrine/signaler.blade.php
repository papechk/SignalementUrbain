@extends('layouts.vitrine')

@section('title', 'Signaler un problème')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #mapPicker .leaflet-container { border-radius: 12px; }
</style>
@endpush

@section('content')
<section style="padding: 3rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="text-center mb-4">
                    <h2 class="section-title">Signaler un problème</h2>
                    <p class="section-subtitle mb-0">Aidez-nous à améliorer votre cadre de vie</p>
                </div>

                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('vitrine.signaler.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Étape 1 : Le problème -->
                            <div class="mb-4 pb-3 border-bottom">
                                <h5 class="fw-bold" style="color:var(--primary);">
                                    <span class="badge bg-primary rounded-circle me-2" style="width:28px;height:28px;font-size:0.85rem;">1</span>
                                    Le problème
                                </h5>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label for="titre" class="form-label fw-bold">
                                        Titre du signalement <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control form-control-lg @error('titre') is-invalid @enderror"
                                           id="titre" name="titre" value="{{ old('titre') }}"
                                           placeholder="Ex: Nid-de-poule avenue de la République" required>
                                    @error('titre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="categorie_id" class="form-label fw-bold">
                                        Catégorie <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-select-lg @error('categorie_id') is-invalid @enderror"
                                            id="categorie_id" name="categorie_id" required>
                                        <option value="">-- Choisir --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('categorie_id', request('categorie')) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categorie_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label fw-bold">
                                        Description détaillée <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description" rows="4"
                                              placeholder="Décrivez le problème le plus précisément possible..." required>{{ old('description') }}</textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="priorite" class="form-label fw-bold">
                                        Niveau d'urgence <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('priorite') is-invalid @enderror"
                                            id="priorite" name="priorite" required>
                                        <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>Faible — Peut attendre</option>
                                        <option value="moyenne" {{ old('priorite', 'moyenne') == 'moyenne' ? 'selected' : '' }}>Moyenne — Normal</option>
                                        <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute — Prioritaire</option>
                                        <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente — Danger immédiat</option>
                                    </select>
                                    @error('priorite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-8">
                                    <label for="photo" class="form-label fw-bold">Photo (optionnel)</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                           id="photo" name="photo" accept="image/*">
                                    <div class="form-text">JPEG, PNG ou GIF — Max 2 Mo</div>
                                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Étape 2 : Localisation -->
                            <div class="mb-4 pb-3 border-bottom">
                                <h5 class="fw-bold" style="color:var(--primary);">
                                    <span class="badge bg-primary rounded-circle me-2" style="width:28px;height:28px;font-size:0.85rem;">2</span>
                                    Localisation
                                </h5>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label for="adresse" class="form-label fw-bold">
                                        Adresse exacte <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-geo-alt text-primary"></i></span>
                                        <input type="text" class="form-control @error('adresse') is-invalid @enderror"
                                               id="adresse" name="adresse" value="{{ old('adresse') }}"
                                               placeholder="Ex: 12 Rue de la Paix" required>
                                    </div>
                                    @error('adresse') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="quartier" class="form-label fw-bold">Quartier</label>
                                    <input type="text" class="form-control @error('quartier') is-invalid @enderror"
                                           id="quartier" name="quartier" value="{{ old('quartier') }}"
                                           placeholder="Ex: Centre-ville">
                                    @error('quartier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-pin-map text-primary me-1"></i> Position sur la carte
                                        <small class="text-muted fw-normal">(cliquez pour placer le marqueur)</small>
                                    </label>
                                    <div id="mapPicker" style="height:300px;border-radius:12px;border:2px solid #dee2e6;"></div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <input type="text" class="form-control form-control-sm bg-light" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude" readonly>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control form-control-sm bg-light" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude" readonly>
                                        </div>
                                    </div>
                                    <button type="button" id="btnGeolocate" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="bi bi-crosshair me-1"></i> Utiliser ma position actuelle
                                    </button>
                                </div>
                            </div>

                            <!-- Étape 3 : Vos coordonnées -->
                            <div class="mb-4 pb-3 border-bottom">
                                <h5 class="fw-bold" style="color:var(--primary);">
                                    <span class="badge bg-primary rounded-circle me-2" style="width:28px;height:28px;font-size:0.85rem;">3</span>
                                    Vos coordonnées
                                </h5>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="signale_par" class="form-label fw-bold">
                                        Nom complet <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-person text-primary"></i></span>
                                        <input type="text" class="form-control @error('signale_par') is-invalid @enderror"
                                               id="signale_par" name="signale_par" value="{{ old('signale_par') }}"
                                               placeholder="Votre nom" required>
                                    </div>
                                    @error('signale_par') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="email_signaleur" class="form-label fw-bold">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-envelope text-primary"></i></span>
                                        <input type="email" class="form-control @error('email_signaleur') is-invalid @enderror"
                                               id="email_signaleur" name="email_signaleur" value="{{ old('email_signaleur') }}"
                                               placeholder="votre@email.com">
                                    </div>
                                    @error('email_signaleur') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="telephone_signaleur" class="form-label fw-bold">Téléphone</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="bi bi-telephone text-primary"></i></span>
                                        <input type="text" class="form-control @error('telephone_signaleur') is-invalid @enderror"
                                               id="telephone_signaleur" name="telephone_signaleur" value="{{ old('telephone_signaleur') }}"
                                               placeholder="06 12 34 56 78">
                                    </div>
                                    @error('telephone_signaleur') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Info RGPD -->
                            <div class="alert alert-light border small mb-4">
                                <i class="bi bi-shield-check me-2 text-primary"></i>
                                Vos données personnelles sont traitées uniquement dans le cadre du suivi de votre signalement,
                                conformément au RGPD. Elles ne seront jamais transmises à des tiers.
                            </div>

                            <!-- Submit -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary-custom btn-lg px-5">
                                    <i class="bi bi-send me-2"></i>Envoyer mon signalement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const defaultLat = {{ old('latitude', 14.6937) }};
    const defaultLng = {{ old('longitude', -17.4441) }};
    const hasOldCoords = {{ old('latitude') ? 'true' : 'false' }};

    const map = L.map('mapPicker').setView([defaultLat, defaultLng], hasOldCoords ? 16 : 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19
    }).addTo(map);

    let marker = null;

    function placeMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                const pos = e.target.getLatLng();
                updateCoords(pos.lat, pos.lng);
            });
        }
        updateCoords(lat, lng);
    }

    function updateCoords(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(8);
        document.getElementById('longitude').value = lng.toFixed(8);
    }

    if (hasOldCoords) {
        placeMarker(defaultLat, defaultLng);
    }

    map.on('click', function (e) {
        placeMarker(e.latlng.lat, e.latlng.lng);
    });

    document.getElementById('btnGeolocate').addEventListener('click', function () {
        if (!navigator.geolocation) {
            alert('La géolocalisation n\'est pas supportée par votre navigateur.');
            return;
        }
        navigator.geolocation.getCurrentPosition(function (pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            map.setView([lat, lng], 16);
            placeMarker(lat, lng);
        }, function () {
            alert('Impossible de récupérer votre position.');
        });
    });
});
</script>
@endpush

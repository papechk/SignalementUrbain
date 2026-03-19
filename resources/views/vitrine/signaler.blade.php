@extends('layouts.vitrine')

@section('title', 'Signaler un problème')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@section('content')
<section class="py-14">
    <div class="mx-auto w-full max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h2 class="font-display text-3xl font-extrabold text-slate-900">Signaler un problème</h2>
            <p class="mt-2 text-slate-600">Aidez-nous à améliorer le cadre de vie à Dakar</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 md:p-8 shadow-sm">
            <form action="{{ route('vitrine.signaler.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Étape 1 — Le problème --}}
                <div>
                    <div class="mb-5 flex items-center gap-3 border-b border-slate-200 pb-3">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-brand-500 text-xs font-bold text-white">1</span>
                        <h3 class="font-display text-lg font-bold text-brand-600">Le problème</h3>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="sm:col-span-2">
                            <label for="titre" class="mb-1 block text-sm font-semibold text-slate-700">Titre <span class="text-rose-500">*</span></label>
                            <input type="text" id="titre" name="titre" value="{{ old('titre') }}" required
                                   class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500 @error('titre') border-rose-400 @enderror"
                                   placeholder="Ex : Nid-de-poule avenue Bourguiba">
                            @error('titre') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="categorie_id" class="mb-1 block text-sm font-semibold text-slate-700">Catégorie <span class="text-rose-500">*</span></label>
                            <select id="categorie_id" name="categorie_id" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500 @error('categorie_id') border-rose-400 @enderror">
                                <option value="">-- Choisir --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categorie_id', request('categorie'))==$cat->id?'selected':'' }}>{{ $cat->nom }}</option>
                                @endforeach
                            </select>
                            @error('categorie_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-3">
                            <label for="description" class="mb-1 block text-sm font-semibold text-slate-700">Description détaillée <span class="text-rose-500">*</span></label>
                            <textarea id="description" name="description" rows="4" required
                                      class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500 @error('description') border-rose-400 @enderror"
                                      placeholder="Décrivez le problème le plus précisément possible…">{{ old('description') }}</textarea>
                            @error('description') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="priorite" class="mb-1 block text-sm font-semibold text-slate-700">Urgence <span class="text-rose-500">*</span></label>
                            <select id="priorite" name="priorite" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                                <option value="faible" {{ old('priorite')=='faible'?'selected':'' }}>Faible</option>
                                <option value="moyenne" {{ old('priorite','moyenne')=='moyenne'?'selected':'' }}>Moyenne</option>
                                <option value="haute" {{ old('priorite')=='haute'?'selected':'' }}>Haute</option>
                                <option value="urgente" {{ old('priorite')=='urgente'?'selected':'' }}>Urgente</option>
                            </select>
                        </div>
                        <div class="sm:col-span-2">
                            <label for="photo" class="mb-1 block text-sm font-semibold text-slate-700">Photo (optionnel)</label>
                            <input type="file" id="photo" name="photo" accept="image/*"
                                   class="w-full rounded-xl border border-slate-300 px-4 py-2 text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-brand-600 @error('photo') border-rose-400 @enderror">
                            <p class="mt-1 text-xs text-slate-400">JPEG, PNG ou GIF — Max 2 Mo</p>
                            @error('photo') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Étape 2 — Localisation --}}
                <div>
                    <div class="mb-5 flex items-center gap-3 border-b border-slate-200 pb-3">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-brand-500 text-xs font-bold text-white">2</span>
                        <h3 class="font-display text-lg font-bold text-brand-600">Localisation</h3>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="sm:col-span-2">
                            <label for="adresse" class="mb-1 block text-sm font-semibold text-slate-700">Adresse exacte <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" required
                                       class="w-full rounded-xl border border-slate-300 py-2.5 pl-9 pr-4 text-sm focus:border-brand-500 focus:ring-brand-500 @error('adresse') border-rose-400 @enderror"
                                       placeholder="Ex : Avenue Cheikh Anta Diop, Dakar">
                            </div>
                            @error('adresse') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="quartier" class="mb-1 block text-sm font-semibold text-slate-700">Quartier</label>
                            <input type="text" id="quartier" name="quartier" value="{{ old('quartier') }}"
                                   class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500"
                                   placeholder="Ex : Plateau, Médina…">
                        </div>
                        <div class="sm:col-span-3">
                            <label class="mb-1 block text-sm font-semibold text-slate-700">
                                <i class="bi bi-pin-map mr-1 text-brand-500"></i> Position sur la carte
                                <span class="ml-1 text-xs font-normal text-slate-400">(cliquez pour placer le marqueur)</span>
                            </label>
                            <div id="mapPicker" class="rounded-xl border-2 border-slate-300" style="height:300px;"></div>
                            <div class="mt-2 grid grid-cols-2 gap-2">
                                <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude" readonly
                                       class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs text-slate-500">
                                <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude" readonly
                                       class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs text-slate-500">
                            </div>
                            <button type="button" id="btnGeolocate"
                                    class="mt-2 inline-flex items-center gap-1 rounded-lg border border-brand-500 px-3 py-1.5 text-xs font-semibold text-brand-500 transition hover:bg-brand-50">
                                <i class="bi bi-crosshair"></i> Utiliser ma position actuelle
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Étape 3 — Vos coordonnées (pré-remplies depuis l'utilisateur connecté) --}}
                <div>
                    <div class="mb-5 flex items-center gap-3 border-b border-slate-200 pb-3">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-brand-500 text-xs font-bold text-white">3</span>
                        <h3 class="font-display text-lg font-bold text-brand-600">Vos coordonnées</h3>
                    </div>

                    <div class="rounded-xl bg-slate-50 border border-slate-200 p-4">
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-700">Nom complet</label>
                                <p class="text-sm text-slate-900 font-medium">{{ auth()->user()->name }}</p>
                                <input type="hidden" name="signale_par" value="{{ auth()->user()->name }}">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-semibold text-slate-700">Email</label>
                                <p class="text-sm text-slate-900 font-medium">{{ auth()->user()->email }}</p>
                                <input type="hidden" name="email_signaleur" value="{{ auth()->user()->email }}">
                            </div>
                            <div>
                                <label for="telephone_signaleur" class="mb-1 block text-sm font-semibold text-slate-700">Téléphone</label>
                                <input type="text" id="telephone_signaleur" name="telephone_signaleur" value="{{ old('telephone_signaleur') }}"
                                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500"
                                       placeholder="+221 77 123 45 67">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Info RGPD --}}
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-500">
                    <i class="bi bi-shield-check mr-1 text-brand-500"></i>
                    Vos données personnelles sont traitées uniquement dans le cadre du suivi de votre signalement,
                    conformément à la loi sénégalaise sur la protection des données personnelles. Elles ne seront jamais transmises à des tiers.
                </div>

                {{-- Submit --}}
                <div class="text-center">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-8 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600">
                        <i class="bi bi-send"></i> Envoyer mon signalement
                    </button>
                </div>
            </form>
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

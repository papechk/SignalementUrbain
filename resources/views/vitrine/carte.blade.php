@extends('layouts.vitrine')

@section('title', 'Carte des signalements')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map { height: 70vh; min-height: 400px; border-radius: 1rem; z-index: 1; }
    .leaflet-popup-content { font-family: 'Public Sans', sans-serif; }
    .leaflet-popup-content h3 { font-size: .95rem; font-weight: 700; margin: 0 0 .35rem; }
    .leaflet-popup-content p  { font-size: .8rem; margin: 0 0 .25rem; color: #475569; }
    .popup-badge { display: inline-block; font-size: .7rem; font-weight: 600; padding: 2px 8px; border-radius: 9999px; }
    .legend { background: white; padding: .75rem 1rem; border-radius: .75rem; box-shadow: 0 2px 8px rgba(0,0,0,.15); line-height: 1.8; font-size: .8rem; }
    .legend i { width: 14px; height: 14px; display: inline-block; border-radius: 50%; margin-right: 6px; vertical-align: middle; }
</style>
@endpush

@section('content')
<section class="py-10">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- En-tête --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="font-display text-3xl font-extrabold text-slate-900">Carte des signalements</h1>
                <p class="mt-1 text-slate-500">Visualisez en temps réel les incidents signalés dans la ville</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <select id="filtreStatut" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                    <option value="">Tous les statuts</option>
                    <option value="nouveau">Nouveau</option>
                    <option value="en_cours">En cours</option>
                    <option value="resolu">Résolu</option>
                    <option value="rejete">Rejeté</option>
                </select>
                <select id="filtreCategorie" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-brand-500 focus:ring-brand-500">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                    @endforeach
                </select>
                <button id="btnLocaliser" class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-3 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                    <i class="bi bi-crosshair"></i> Me localiser
                </button>
            </div>
        </div>

        {{-- Carte --}}
        <div id="map"></div>

        {{-- Stats rapides --}}
        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-center">
                <div class="text-2xl font-extrabold text-blue-700">{{ $stats['nouveau'] }}</div>
                <div class="text-sm text-blue-600">Nouveaux</div>
            </div>
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-center">
                <div class="text-2xl font-extrabold text-amber-700">{{ $stats['en_cours'] }}</div>
                <div class="text-sm text-amber-600">En cours</div>
            </div>
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-center">
                <div class="text-2xl font-extrabold text-emerald-700">{{ $stats['resolu'] }}</div>
                <div class="text-sm text-emerald-600">Résolus</div>
            </div>
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-center">
                <div class="text-2xl font-extrabold text-rose-700">{{ $stats['rejete'] }}</div>
                <div class="text-sm text-rose-600">Rejetés</div>
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
    // Centre par défaut : Dakar
    const map = L.map('map').setView([14.6937, -17.4441], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 19
    }).addTo(map);

    // Légende
    const legend = L.control({ position: 'bottomright' });
    legend.onAdd = function () {
        const div = L.DomUtil.create('div', 'legend');
        div.innerHTML =
            '<strong>Statuts</strong><br>' +
            '<i style="background:#3b82f6"></i> Nouveau<br>' +
            '<i style="background:#f59e0b"></i> En cours<br>' +
            '<i style="background:#10b981"></i> Résolu<br>' +
            '<i style="background:#ef4444"></i> Rejeté';
        return div;
    };
    legend.addTo(map);

    const statutColors = {
        nouveau:  '#3b82f6',
        en_cours: '#f59e0b',
        resolu:   '#10b981',
        rejete:   '#ef4444'
    };

    const statutLabels = {
        nouveau:  'Nouveau',
        en_cours: 'En cours',
        resolu:   'Résolu',
        rejete:   'Rejeté'
    };

    let markers = L.layerGroup().addTo(map);
    let allSignalements = @json($signalements);

    function createIcon(color) {
        return L.divIcon({
            className: '',
            html: '<div style="width:28px;height:28px;background:' + color + ';border:3px solid white;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,.3);"></div>',
            iconSize: [28, 28],
            iconAnchor: [14, 14],
            popupAnchor: [0, -16]
        });
    }

    function renderMarkers(data) {
        markers.clearLayers();
        const bounds = [];

        data.forEach(function (s) {
            if (!s.latitude || !s.longitude) return;

            const color = statutColors[s.statut] || '#6b7280';
            const label = statutLabels[s.statut] || s.statut;
            const categorie = s.categorie ? s.categorie.nom : '—';
            const detailUrl = '/signalement/' + s.id;

            const popup =
                '<h3>' + escapeHtml(s.titre) + '</h3>' +
                '<p><i class="bi bi-folder me-1"></i>' + escapeHtml(categorie) + '</p>' +
                '<p><i class="bi bi-geo-alt me-1"></i>' + escapeHtml(s.adresse || '') + '</p>' +
                '<p><span class="popup-badge" style="background:' + color + '20;color:' + color + '">' + label + '</span></p>' +
                '<a href="' + detailUrl + '" style="color:#1d6fe8;font-size:.8rem;font-weight:600;">Voir détails →</a>';

            const marker = L.marker([s.latitude, s.longitude], { icon: createIcon(color) })
                .bindPopup(popup);
            markers.addLayer(marker);
            bounds.push([s.latitude, s.longitude]);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [40, 40], maxZoom: 15 });
        }
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    function applyFilters() {
        const statut = document.getElementById('filtreStatut').value;
        const categorie = document.getElementById('filtreCategorie').value;

        let filtered = allSignalements;
        if (statut) {
            filtered = filtered.filter(function (s) { return s.statut === statut; });
        }
        if (categorie) {
            filtered = filtered.filter(function (s) { return String(s.categorie_id) === categorie; });
        }
        renderMarkers(filtered);
    }

    document.getElementById('filtreStatut').addEventListener('change', applyFilters);
    document.getElementById('filtreCategorie').addEventListener('change', applyFilters);

    // Géolocalisation
    document.getElementById('btnLocaliser').addEventListener('click', function () {
        if (!navigator.geolocation) {
            alert('La géolocalisation n\'est pas supportée par votre navigateur.');
            return;
        }
        navigator.geolocation.getCurrentPosition(function (pos) {
            map.setView([pos.coords.latitude, pos.coords.longitude], 15);
            L.marker([pos.coords.latitude, pos.coords.longitude], {
                icon: L.divIcon({
                    className: '',
                    html: '<div style="width:18px;height:18px;background:#1d6fe8;border:3px solid white;border-radius:50%;box-shadow:0 0 0 6px rgba(29,111,232,.25);"></div>',
                    iconSize: [18, 18],
                    iconAnchor: [9, 9]
                })
            }).addTo(map).bindPopup('Vous êtes ici').openPopup();
        }, function () {
            alert('Impossible de récupérer votre position.');
        });
    });

    // Rendu initial
    renderMarkers(allSignalements);
});
</script>
@endpush

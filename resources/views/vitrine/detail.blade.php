@extends('layouts.vitrine')

@section('title', $signalement->titre)

@push('styles')
@if($signalement->latitude && $signalement->longitude)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endif
@endpush

@section('content')
<section class="py-14">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">

        <a href="{{ route('vitrine.signalements') }}" class="mb-6 inline-flex items-center gap-1 text-sm text-slate-500 hover:text-brand-500 transition">
            <i class="bi bi-arrow-left"></i> Retour aux signalements
        </a>

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Contenu principal --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    {{-- Badges --}}
                    <div class="mb-4 flex flex-wrap gap-2">
                        @php
                            $statutColors = ['nouveau'=>'bg-blue-100 text-blue-700','en_cours'=>'bg-amber-100 text-amber-700','resolu'=>'bg-emerald-100 text-emerald-700','rejete'=>'bg-rose-100 text-rose-700'];
                            $prioColors   = ['faible'=>'bg-slate-100 text-slate-600','moyenne'=>'bg-amber-100 text-amber-700','haute'=>'bg-orange-100 text-orange-700','urgente'=>'bg-rose-100 text-rose-700'];
                        @endphp
                        <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $statutColors[$signalement->statut] ?? '' }}">
                            {{ ucfirst(str_replace('_',' ',$signalement->statut)) }}
                        </span>
                        <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $prioColors[$signalement->priorite] ?? '' }}">
                            <i class="bi bi-flag mr-1"></i>{{ ucfirst($signalement->priorite) }}
                        </span>
                        <span class="inline-block rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                            <i class="bi bi-tag mr-1"></i>{{ $signalement->categorie->nom }}
                        </span>
                    </div>

                    <h2 class="mb-4 font-display text-2xl font-extrabold text-slate-900">{{ $signalement->titre }}</h2>

                    {{-- Description --}}
                    <div class="mb-5">
                        <h4 class="mb-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Description</h4>
                        <p class="text-sm leading-relaxed text-slate-700">{{ $signalement->description }}</p>
                    </div>

                    {{-- Photo --}}
                    @if($signalement->photo)
                    <div class="mb-5">
                        <h4 class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Photo</h4>
                        <img src="{{ asset($signalement->photo) }}" alt="Photo du signalement"
                             class="max-h-96 w-full rounded-xl object-cover">
                    </div>
                    @endif

                    {{-- Réponse mairie --}}
                    @if($signalement->commentaire_mairie)
                    <div>
                        <h4 class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Réponse de la mairie</h4>
                        <div class="rounded-xl border-l-4 border-brand-500 bg-brand-50 px-4 py-3 text-sm text-slate-700">
                            <i class="bi bi-building mr-2 text-brand-500"></i>{{ $signalement->commentaire_mairie }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Informations --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h4 class="mb-4 text-sm font-bold text-slate-900"><i class="bi bi-info-circle mr-2 text-brand-500"></i>Informations</h4>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="font-semibold text-slate-500">Référence</dt>
                            <dd class="font-mono text-brand-600">{{ $signalement->reference }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-semibold text-slate-500">Date</dt>
                            <dd>{{ $signalement->created_at->format('d/m/Y à H:i') }}</dd>
                        </div>
                        @if($signalement->date_resolution)
                        <div class="flex justify-between">
                            <dt class="font-semibold text-slate-500">Résolu le</dt>
                            <dd class="font-bold text-emerald-600">{{ $signalement->date_resolution->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <dt class="font-semibold text-slate-500">Signalé par</dt>
                            <dd>{{ $signalement->signale_par }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Localisation --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h4 class="mb-3 text-sm font-bold text-slate-900"><i class="bi bi-geo-alt mr-2 text-brand-500"></i>Localisation</h4>
                    <p class="text-sm font-semibold text-slate-800">{{ $signalement->adresse }}</p>
                    @if($signalement->quartier)
                        <p class="text-xs text-slate-500">Quartier : {{ $signalement->quartier }}</p>
                    @endif
                    @if($signalement->latitude && $signalement->longitude)
                        <div id="detailMap" class="mt-3 rounded-xl" style="height:200px;"></div>
                    @endif
                </div>

                {{-- Historique --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h4 class="mb-4 text-sm font-bold text-slate-900"><i class="bi bi-clock-history mr-2 text-brand-500"></i>Historique</h4>
                    <div class="relative space-y-4 border-l-2 border-slate-200 pl-5">
                        {{-- Créé --}}
                        <div class="relative">
                            <span class="absolute -left-[1.65rem] top-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-brand-500 text-[10px] text-white"><i class="bi bi-plus"></i></span>
                            <p class="text-sm font-bold text-slate-800">Signalement créé</p>
                            <p class="text-xs text-slate-400">{{ $signalement->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        @if($signalement->statut !== 'nouveau')
                        <div class="relative">
                            <span class="absolute -left-[1.65rem] top-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-amber-400 text-[10px] text-white"><i class="bi bi-gear"></i></span>
                            <p class="text-sm font-bold text-slate-800">Pris en charge</p>
                            <p class="text-xs text-slate-400">Par la mairie</p>
                        </div>
                        @endif

                        @if($signalement->statut === 'resolu')
                        <div class="relative">
                            <span class="absolute -left-[1.65rem] top-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-[10px] text-white"><i class="bi bi-check"></i></span>
                            <p class="text-sm font-bold text-emerald-600">Résolu</p>
                            <p class="text-xs text-slate-400">{{ $signalement->date_resolution ? $signalement->date_resolution->format('d/m/Y H:i') : '' }}</p>
                        </div>
                        @endif

                        @if($signalement->statut === 'rejete')
                        <div class="relative">
                            <span class="absolute -left-[1.65rem] top-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[10px] text-white"><i class="bi bi-x"></i></span>
                            <p class="text-sm font-bold text-rose-600">Rejeté</p>
                            <p class="text-xs text-slate-400">Non pris en charge</p>
                        </div>
                        @endif
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

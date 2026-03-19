@extends('layouts.vitrine')

@section('title', 'Suivre mon signalement')

@section('content')
<section class="py-14">
    <div class="mx-auto w-full max-w-2xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <div class="mb-3 text-5xl text-brand-500"><i class="bi bi-search"></i></div>
            <h2 class="font-display text-3xl font-extrabold text-slate-900">Suivre mon signalement</h2>
            <p class="mt-2 text-slate-600">
                Entrez la référence de votre signalement (ex : SIG-XXXXXXXX)
                pour consulter son état d'avancement.
            </p>
        </div>

        {{-- Formulaire de recherche --}}
        <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <form action="{{ route('vitrine.suivi') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400"><i class="bi bi-hash"></i></span>
                    <input type="text" name="reference" value="{{ request('reference') }}" required
                           class="w-full rounded-xl border border-slate-300 py-3 pl-9 pr-4 font-mono text-sm tracking-wider focus:border-brand-500 focus:ring-brand-500"
                           placeholder="SIG-...">
                </div>
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600">
                    <i class="bi bi-search"></i> Rechercher
                </button>
            </form>
        </div>

        {{-- Résultat --}}
        @if(request('reference'))
            @if(isset($signalement) && $signalement)
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <span class="font-mono text-lg font-bold text-brand-600">{{ $signalement->reference }}</span>
                        <h3 class="mt-1 font-display text-xl font-bold text-slate-900">{{ $signalement->titre }}</h3>
                        <p class="text-xs text-slate-400">
                            <i class="bi bi-geo-alt mr-1"></i>{{ $signalement->adresse }}
                            @if($signalement->quartier) — {{ $signalement->quartier }} @endif
                        </p>
                    </div>
                    @php
                        $statutColors = ['nouveau'=>'bg-blue-100 text-blue-700','en_cours'=>'bg-amber-100 text-amber-700','resolu'=>'bg-emerald-100 text-emerald-700','rejete'=>'bg-rose-100 text-rose-700'];
                    @endphp
                    <span class="inline-block rounded-full px-4 py-1.5 text-sm font-semibold {{ $statutColors[$signalement->statut] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ ucfirst(str_replace('_',' ',$signalement->statut)) }}
                    </span>
                </div>

                <hr class="my-4 border-slate-200">

                {{-- Timeline --}}
                <h4 class="mb-4 text-sm font-bold text-slate-900"><i class="bi bi-clock-history mr-2 text-brand-500"></i>Suivi du traitement</h4>

                <div class="relative space-y-5 border-l-2 border-slate-200 pl-6">
                    {{-- Créé --}}
                    <div class="relative">
                        <span class="absolute -left-[1.65rem] top-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-brand-500 text-[10px] text-white"><i class="bi bi-plus"></i></span>
                        <p class="text-sm font-bold text-slate-800">Signalement enregistré</p>
                        <p class="text-xs text-slate-400">{{ $signalement->created_at->format('d/m/Y à H:i') }}</p>
                        <p class="mt-0.5 text-xs text-slate-500">Catégorie : {{ $signalement->categorie->nom }} — Priorité : {{ ucfirst($signalement->priorite) }}</p>
                    </div>

                    @if(in_array($signalement->statut, ['en_cours', 'resolu']))
                    <div class="relative">
                        <span class="absolute -left-[1.65rem] top-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-amber-400 text-[10px] text-white"><i class="bi bi-gear"></i></span>
                        <p class="text-sm font-bold text-slate-800">En cours de traitement</p>
                        <p class="text-xs text-slate-400">Pris en charge par les services municipaux</p>
                    </div>
                    @endif

                    @if($signalement->statut === 'resolu')
                    <div class="relative">
                        <span class="absolute -left-[1.65rem] top-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-[10px] text-white"><i class="bi bi-check-lg"></i></span>
                        <p class="text-sm font-bold text-emerald-600">Problème résolu</p>
                        <p class="text-xs text-slate-400">
                            {{ $signalement->date_resolution ? $signalement->date_resolution->format('d/m/Y à H:i') : 'Date non précisée' }}
                        </p>
                    </div>
                    @endif

                    @if($signalement->statut === 'rejete')
                    <div class="relative">
                        <span class="absolute -left-[1.65rem] top-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[10px] text-white"><i class="bi bi-x-lg"></i></span>
                        <p class="text-sm font-bold text-rose-600">Signalement rejeté</p>
                        <p class="text-xs text-slate-400">Non pris en charge</p>
                    </div>
                    @endif
                </div>

                @if($signalement->commentaire_mairie)
                <hr class="my-4 border-slate-200">
                <h4 class="mb-2 text-sm font-bold text-slate-900"><i class="bi bi-chat-left-text mr-2 text-brand-500"></i>Réponse de la mairie</h4>
                <div class="rounded-xl border-l-4 border-brand-500 bg-brand-50 px-4 py-3 text-sm text-slate-700">
                    {{ $signalement->commentaire_mairie }}
                </div>
                @endif

                <div class="mt-6 text-center">
                    <a href="{{ route('vitrine.signalement.detail', $signalement) }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-brand-500 px-5 py-2.5 text-sm font-semibold text-brand-500 transition hover:bg-brand-50">
                        <i class="bi bi-eye"></i> Voir le détail complet
                    </a>
                </div>
            </div>
            @else
            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">
                <div class="mb-3 text-5xl text-slate-300"><i class="bi bi-exclamation-circle"></i></div>
                <h3 class="font-display text-lg font-bold text-slate-900">Signalement introuvable</h3>
                <p class="mt-1 text-sm text-slate-500">
                    Aucun signalement ne correspond à la référence
                    <span class="font-mono font-semibold text-brand-600">{{ request('reference') }}</span>.<br>
                    Vérifiez la référence et réessayez.
                </p>
            </div>
            @endif
        @endif
    </div>
</section>
@endsection

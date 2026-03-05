@extends('layouts.vitrine')

@section('title', 'Accueil')

@section('content')
<section class="relative overflow-hidden bg-slate-950 pb-20 pt-16 text-white">
    <div class="absolute -left-24 top-12 h-72 w-72 rounded-full bg-brand-500/20 blur-3xl"></div>
    <div class="absolute -right-16 bottom-0 h-72 w-72 rounded-full bg-cyan-400/10 blur-3xl"></div>

    <div class="relative mx-auto grid w-full max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-wider text-brand-100">
                <i class="bi bi-megaphone"></i>
                Plateforme citoyenne
            </span>

            <h1 class="mt-5 font-display text-4xl font-extrabold leading-tight sm:text-5xl">
                Signalez les problemes de votre commune
            </h1>

            <p class="mt-5 max-w-xl text-base leading-7 text-slate-300 sm:text-lg">
                Nids de poule, eclairage, proprete ou nuisances: la mairie suit chaque signalement en temps reel.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('vitrine.signaler') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white shadow-soft transition hover:bg-brand-600">
                    <i class="bi bi-send"></i>
                    Signaler maintenant
                </a>
                <a href="{{ route('vitrine.suivi') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i class="bi bi-search"></i>
                    Suivre mon signalement
                </a>
            </div>

            <dl class="mt-8 grid grid-cols-3 gap-3">
                <div class="rounded-xl border border-white/15 bg-white/10 p-3">
                    <dt class="text-xs uppercase tracking-wider text-slate-300">Total</dt>
                    <dd class="mt-1 text-2xl font-extrabold text-white">{{ $stats['total'] }}</dd>
                </div>
                <div class="rounded-xl border border-white/15 bg-white/10 p-3">
                    <dt class="text-xs uppercase tracking-wider text-slate-300">Resolus</dt>
                    <dd class="mt-1 text-2xl font-extrabold text-white">{{ $stats['resolu'] }}</dd>
                </div>
                <div class="rounded-xl border border-white/15 bg-white/10 p-3">
                    <dt class="text-xs uppercase tracking-wider text-slate-300">Taux</dt>
                    <dd class="mt-1 text-2xl font-extrabold text-white">{{ $tauxResolution }}%</dd>
                </div>
            </dl>
        </div>

        <div class="relative">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
                <div class="grid gap-4">
                    <div class="rounded-2xl bg-slate-900/70 p-4">
                        <p class="text-sm text-slate-300">Signalement urgent</p>
                        <p class="mt-1 text-sm font-semibold">Eclairage public en panne, rue des Lilas</p>
                        <p class="mt-2 text-xs text-brand-200">Pris en charge en 2h</p>
                    </div>
                    <div class="rounded-2xl bg-slate-900/70 p-4">
                        <p class="text-sm text-slate-300">Signalement resolu</p>
                        <p class="mt-1 text-sm font-semibold">Nid de poule boulevard Victor Hugo</p>
                        <p class="mt-2 text-xs text-emerald-300">Intervention terminee</p>
                    </div>
                    <div class="rounded-2xl bg-slate-900/70 p-4">
                        <p class="text-sm text-slate-300">Signalement en cours</p>
                        <p class="mt-1 text-sm font-semibold">Depot sauvage place du Marche</p>
                        <p class="mt-2 text-xs text-amber-300">Equipe municipale notifiee</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="mb-8 text-center">
        <h2 class="font-display text-3xl font-extrabold text-slate-900">Comment ca marche ?</h2>
        <p class="mt-2 text-slate-600">Trois etapes simples pour agir dans votre quartier.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-700 font-bold">1</span>
            <h3 class="mt-4 font-display text-xl font-bold text-slate-900">Signalez</h3>
            <p class="mt-2 text-sm leading-6 text-slate-600">Decrivez le probleme, l'adresse et ajoutez une photo si necessaire.</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-700 font-bold">2</span>
            <h3 class="mt-4 font-display text-xl font-bold text-slate-900">Traitement</h3>
            <p class="mt-2 text-sm leading-6 text-slate-600">La mairie qualifie la demande et lance l'intervention adaptee.</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-700 font-bold">3</span>
            <h3 class="mt-4 font-display text-xl font-bold text-slate-900">Resolution</h3>
            <p class="mt-2 text-sm leading-6 text-slate-600">Le statut est mis a jour et vous suivez l'avancement en ligne.</p>
        </article>
    </div>
</section>

<section class="bg-white py-14">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h2 class="font-display text-3xl font-extrabold text-slate-900">Categories frequentes</h2>
            <p class="mt-2 text-slate-600">Choisissez la categorie adaptee a votre incident.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($categories as $cat)
                <a href="{{ route('vitrine.signaler', ['categorie' => $cat->id]) }}"
                   class="group rounded-2xl border border-slate-200 bg-slate-50 p-5 transition hover:-translate-y-1 hover:border-brand-300 hover:bg-brand-50/50 hover:shadow-sm">
                    <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white text-brand-600 shadow-sm">
                        <i class="bi bi-{{ $cat->icone ?? 'tag' }} text-lg"></i>
                    </div>
                    <h3 class="mt-4 font-semibold text-slate-900">{{ $cat->nom }}</h3>
                    <p class="mt-1 text-xs text-slate-500">{{ $cat->signalements_count }} signalement{{ $cat->signalements_count > 1 ? 's' : '' }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h2 class="font-display text-3xl font-extrabold text-slate-900">Derniers signalements</h2>
            <p class="mt-2 text-slate-600">Incidents signales recemment par les citoyens.</p>
        </div>
        <a href="{{ route('vitrine.signalements') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-100">
            Voir tout
            <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse($derniers as $sig)
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                <div class="mb-3 flex items-start justify-between gap-2">
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold badge-{{ $sig->statut }}">{{ $sig->statut_label }}</span>
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold badge-{{ $sig->priorite }}">{{ ucfirst($sig->priorite) }}</span>
                </div>
                <a href="{{ route('vitrine.signalement.detail', $sig) }}" class="font-display text-lg font-bold leading-snug text-slate-900 hover:text-brand-700">
                    {{ $sig->titre }}
                </a>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ Str::limit($sig->description, 105) }}</p>
                <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                    <span><i class="bi bi-geo-alt mr-1"></i>{{ Str::limit($sig->adresse, 24) }}</span>
                    <span><i class="bi bi-calendar mr-1"></i>{{ $sig->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="mt-2 text-xs text-slate-500">
                    <i class="bi bi-tag mr-1"></i>{{ $sig->categorie->nom }}
                </div>
            </article>
        @empty
            <div class="md:col-span-2 xl:col-span-3">
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-100 p-10 text-center text-slate-500">
                    <i class="bi bi-inbox text-3xl"></i>
                    <p class="mt-2 text-sm">Aucun signalement pour le moment.</p>
                </div>
            </div>
        @endforelse
    </div>
</section>

<section class="pb-16">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-brand-700 via-brand-600 to-cyan-600 p-8 text-white shadow-soft sm:p-10">
            <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <h2 class="font-display text-3xl font-extrabold">Vous avez constate un probleme ?</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-white/90 sm:text-base">
                        Lancez un signalement en moins de deux minutes et recevez un numero de suivi.
                    </p>
                </div>
                <a href="{{ route('vitrine.signaler') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-bold text-brand-700 transition hover:bg-slate-100">
                    <i class="bi bi-megaphone"></i>
                    Faire un signalement
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

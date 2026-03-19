@extends('layouts.vitrine')

@section('title', 'Tous les signalements')

@section('content')
<section class="py-14">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <h2 class="font-display text-3xl font-extrabold text-slate-900">Signalements en cours</h2>
            <p class="mt-2 text-slate-600">Consultez tous les signalements de la commune de Dakar</p>
        </div>

        {{-- Filtres --}}
        <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <form action="{{ route('vitrine.signalements') }}" method="GET" class="grid items-end gap-3 sm:grid-cols-2 md:grid-cols-5">
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-slate-500">Recherche</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400"><i class="bi bi-search"></i></span>
                        <input type="text" name="recherche" value="{{ request('recherche') }}" placeholder="Mot-clé…"
                               class="w-full rounded-xl border border-slate-300 py-2.5 pl-9 pr-4 text-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-slate-500">Statut</label>
                    <select name="statut" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="">Tous</option>
                        <option value="nouveau" {{ request('statut')=='nouveau'?'selected':'' }}>Nouveau</option>
                        <option value="en_cours" {{ request('statut')=='en_cours'?'selected':'' }}>En cours</option>
                        <option value="resolu" {{ request('statut')=='resolu'?'selected':'' }}>Résolu</option>
                        <option value="rejete" {{ request('statut')=='rejete'?'selected':'' }}>Rejeté</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-slate-500">Priorité</label>
                    <select name="priorite" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="">Toutes</option>
                        <option value="faible" {{ request('priorite')=='faible'?'selected':'' }}>Faible</option>
                        <option value="moyenne" {{ request('priorite')=='moyenne'?'selected':'' }}>Moyenne</option>
                        <option value="haute" {{ request('priorite')=='haute'?'selected':'' }}>Haute</option>
                        <option value="urgente" {{ request('priorite')=='urgente'?'selected':'' }}>Urgente</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wider text-slate-500">Catégorie</label>
                    <select name="categorie_id" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                        <option value="">Toutes</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('categorie_id')==$cat->id?'selected':'' }}>{{ $cat->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600">
                        <i class="bi bi-funnel"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>

        {{-- Résultats --}}
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($signalements as $sig)
            <a href="{{ route('vitrine.signalement.detail', $sig) }}"
               class="group flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md hover:-translate-y-0.5">
                @if($sig->photo)
                <div class="h-40 overflow-hidden rounded-t-2xl">
                    <img src="{{ asset($sig->photo) }}" alt="" class="h-full w-full object-cover transition group-hover:scale-105">
                </div>
                @endif
                <div class="flex flex-1 flex-col p-4">
                    <div class="mb-2 flex items-center justify-between gap-2">
                        @php
                            $statutColors = ['nouveau'=>'bg-blue-100 text-blue-700','en_cours'=>'bg-amber-100 text-amber-700','resolu'=>'bg-emerald-100 text-emerald-700','rejete'=>'bg-rose-100 text-rose-700'];
                            $prioColors   = ['faible'=>'bg-slate-100 text-slate-600','moyenne'=>'bg-amber-100 text-amber-700','haute'=>'bg-orange-100 text-orange-700','urgente'=>'bg-rose-100 text-rose-700'];
                        @endphp
                        <span class="inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statutColors[$sig->statut] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ ucfirst(str_replace('_',' ',$sig->statut)) }}
                        </span>
                        <span class="inline-block rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $prioColors[$sig->priorite] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ ucfirst($sig->priorite) }}
                        </span>
                    </div>
                    <h3 class="mb-1 font-display text-base font-bold text-slate-900 group-hover:text-brand-600 transition">{{ $sig->titre }}</h3>
                    <p class="mb-3 flex-1 text-sm text-slate-500">{{ Str::limit($sig->description, 120) }}</p>
                    <div class="flex items-center justify-between text-xs text-slate-400">
                        <span><i class="bi bi-geo-alt mr-1"></i>{{ Str::limit($sig->adresse, 30) }}</span>
                        <span><i class="bi bi-calendar mr-1"></i>{{ $sig->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="mt-2 flex items-center justify-between text-xs">
                        <span class="text-slate-400"><i class="bi bi-tag mr-1"></i>{{ $sig->categorie->nom }}</span>
                        <span class="font-semibold text-brand-500 group-hover:underline">Détails <i class="bi bi-arrow-right"></i></span>
                    </div>
                </div>
            </a>
            @empty
            <div class="col-span-full py-16 text-center text-slate-400">
                <i class="bi bi-inbox text-4xl"></i>
                <p class="mt-2">Aucun signalement ne correspond à vos critères</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($signalements->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $signalements->links() }}
        </div>
        @endif
    </div>
</section>
@endsection

@extends('layouts.admin-tw')

@section('title', 'Tableau de bord')

@section('content')
{{-- Header --}}
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <h1 class="font-display text-2xl font-extrabold text-slate-900">
            <i class="bi bi-speedometer2 mr-2 text-brand-500"></i>Tableau de bord
        </h1>
        <p class="mt-1 text-sm text-slate-500">Vue globale des signalements urbains</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.signalements.index') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-brand-600 transition">
            <i class="bi bi-list-ul"></i> Tous les signalements
        </a>
        <a href="{{ route('vitrine.carte') }}" target="_blank"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
            <i class="bi bi-map"></i> Carte
        </a>
    </div>
</div>

{{-- Row 1 : Signalements cards --}}
<div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
    <div class="group rounded-2xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
            <i class="bi bi-clipboard-data text-xl"></i>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Total signalements</p>
        <p class="mt-1 text-2xl font-extrabold text-slate-900">{{ $stats['total'] }}</p>
    </div>
    <div class="group rounded-2xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-sky-100 text-sky-600">
            <i class="bi bi-bell text-xl"></i>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Nouveaux</p>
        <p class="mt-1 text-2xl font-extrabold text-sky-600">{{ $stats['nouveau'] }}</p>
    </div>
    <div class="group rounded-2xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
            <i class="bi bi-hourglass-split text-xl"></i>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">En cours</p>
        <p class="mt-1 text-2xl font-extrabold text-amber-600">{{ $stats['en_cours'] }}</p>
    </div>
    <div class="group rounded-2xl border border-slate-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
            <i class="bi bi-check-circle text-xl"></i>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Résolus</p>
        <p class="mt-1 text-2xl font-extrabold text-emerald-600">{{ $stats['resolu'] }}</p>
    </div>
</div>

{{-- Row 2 : Rejetés + Utilisateurs + Signalements ce mois --}}
<div class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-rose-100 text-rose-600">
            <i class="bi bi-x-octagon text-xl"></i>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Rejetés</p>
        <p class="mt-1 text-2xl font-extrabold text-rose-600">{{ $stats['rejete'] }}</p>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
            <i class="bi bi-people text-xl"></i>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Utilisateurs</p>
        <p class="mt-1 text-2xl font-extrabold text-slate-900">{{ $nbUtilisateurs }}</p>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-violet-100 text-violet-600">
            <i class="bi bi-calendar-event text-xl"></i>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Ce mois</p>
        <p class="mt-1 text-2xl font-extrabold text-slate-900">{{ $signalementsMois }}</p>
    </div>
    <div class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-3 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-teal-100 text-teal-600">
            <i class="bi bi-geo-alt text-xl"></i>
        </div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Quartiers touchés</p>
        <p class="mt-1 text-2xl font-extrabold text-slate-900">{{ $nbQuartiers }}</p>
    </div>
</div>

{{-- Row 3 : Taux + Priorité + Catégorie --}}
<div class="mb-6 grid gap-4 lg:grid-cols-3">
    {{-- Taux de résolution --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center">
        <h3 class="mb-4 text-sm font-semibold text-slate-500"><i class="bi bi-graph-up mr-1"></i> Taux de résolution</h3>
        <p class="text-5xl font-extrabold {{ $tauxResolution >= 70 ? 'text-emerald-500' : ($tauxResolution >= 40 ? 'text-amber-500' : 'text-rose-500') }}">
            {{ $tauxResolution }}%
        </p>
        <p class="mt-2 text-sm text-slate-400">des signalements résolus</p>
        <div class="mx-auto mt-4 h-2.5 w-full max-w-xs overflow-hidden rounded-full bg-slate-100">
            <div class="h-full rounded-full bg-emerald-500 transition-all" style="width:{{ $tauxResolution }}%"></div>
        </div>
    </div>

    {{-- Par priorité --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6">
        <h3 class="mb-4 text-sm font-semibold text-slate-500"><i class="bi bi-flag mr-1"></i> Par priorité</h3>
        <div class="space-y-3">
            @php $prioriteColors = ['faible'=>'sky','moyenne'=>'blue','haute'=>'amber','urgente'=>'rose']; @endphp
            @foreach($parPriorite as $p => $count)
            <div class="flex items-center justify-between">
                <span class="inline-flex items-center gap-2 text-sm">
                    <span class="h-2.5 w-2.5 rounded-full bg-{{ $prioriteColors[$p] ?? 'slate' }}-500"></span>
                    {{ ucfirst($p) }}
                </span>
                <span class="text-sm font-bold text-slate-700">{{ $count }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Par catégorie --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6">
        <h3 class="mb-4 text-sm font-semibold text-slate-500"><i class="bi bi-tags mr-1"></i> Par catégorie</h3>
        <div class="space-y-2.5">
            @forelse($parCategorie as $cat)
            <div class="flex items-center justify-between">
                <span class="text-sm text-slate-600">{{ $cat->nom }}</span>
                <span class="rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-bold text-slate-600">{{ $cat->signalements_count }}</span>
            </div>
            @empty
            <p class="text-sm text-slate-400">Aucune donnée</p>
            @endforelse
        </div>
    </div>
</div>



{{-- Signalements urgents --}}
@if($urgents->count() > 0)
<div class="mb-6 overflow-hidden rounded-2xl border border-rose-200 bg-white">
    <div class="border-b border-rose-100 bg-rose-50 px-6 py-4">
        <h3 class="text-sm font-semibold text-rose-700">
            <i class="bi bi-exclamation-octagon mr-2"></i>Signalements urgents non résolus ({{ $urgents->count() }})
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-100 bg-slate-50/60">
                <tr>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Réf</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Titre</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Catégorie</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Adresse</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Date</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($urgents as $sig)
                <tr class="hover:bg-rose-50/40">
                    <td class="whitespace-nowrap px-6 py-3 font-mono text-xs text-brand-600">{{ $sig->reference }}</td>
                    <td class="px-6 py-3">{{ Str::limit($sig->titre, 30) }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $sig->categorie->nom }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ Str::limit($sig->adresse, 25) }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $sig->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.signalements.show', $sig) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-2.5 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Derniers signalements --}}
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white">
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
        <h3 class="text-sm font-semibold text-slate-700"><i class="bi bi-clock-history mr-2 text-brand-500"></i>Derniers signalements</h3>
        <a href="{{ route('admin.signalements.index') }}" class="text-xs font-semibold text-brand-500 hover:underline">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-slate-100 bg-slate-50/60">
                <tr>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Réf</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Titre</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Catégorie</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Priorité</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Statut</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Signalé par</th>
                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wide text-slate-400">Date</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($derniers as $sig)
                @php
                    $statutColors = ['nouveau'=>'blue','en_cours'=>'amber','resolu'=>'emerald','rejete'=>'rose'];
                    $prioColors   = ['faible'=>'sky','moyenne'=>'blue','haute'=>'amber','urgente'=>'rose'];
                    $sc = $statutColors[$sig->statut] ?? 'slate';
                    $pc = $prioColors[$sig->priorite] ?? 'slate';
                @endphp
                <tr class="hover:bg-slate-50/50">
                    <td class="whitespace-nowrap px-6 py-3 font-mono text-xs text-brand-600">{{ $sig->reference }}</td>
                    <td class="px-6 py-3">{{ Str::limit($sig->titre, 30) }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $sig->categorie->nom }}</td>
                    <td class="px-6 py-3"><span class="rounded-full bg-{{ $pc }}-100 px-2.5 py-0.5 text-xs font-semibold text-{{ $pc }}-700">{{ ucfirst($sig->priorite) }}</span></td>
                    <td class="px-6 py-3"><span class="rounded-full bg-{{ $sc }}-100 px-2.5 py-0.5 text-xs font-semibold text-{{ $sc }}-700">{{ $sig->statut_label }}</span></td>
                    <td class="px-6 py-3">{{ $sig->signale_par }}</td>
                    <td class="px-6 py-3 text-slate-500">{{ $sig->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-3">
                        <a href="{{ route('admin.signalements.show', $sig) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-300 px-2.5 py-1 text-xs font-medium text-slate-600 hover:bg-slate-50">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="py-8 text-center text-sm text-slate-400">Aucun signalement pour le moment</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

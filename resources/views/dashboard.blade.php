@extends('layouts.tailadmin')
@section('title', 'Espace membre')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold dark:text-white font-display">Bienvenue, {{ Auth::user()->name }}</h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Voici votre espace portfolio pour gerer votre profil et suivre vos projets.</p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-8">
    <div class="xl:col-span-2 rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] p-6">
        <h3 class="text-lg font-semibold dark:text-white font-display mb-4">Apercu rapide</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-xl border border-gray-100 dark:border-white/[0.06] p-4">
                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Statut</p>
                <p class="mt-2 text-lg font-semibold dark:text-white">Actif</p>
            </div>
            <div class="rounded-xl border border-gray-100 dark:border-white/[0.06] p-4">
                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Profil</p>
                <p class="mt-2 text-lg font-semibold dark:text-white">Completable</p>
            </div>
            <div class="rounded-xl border border-gray-100 dark:border-white/[0.06] p-4">
                <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Objectif</p>
                <p class="mt-2 text-lg font-semibold dark:text-white">Nouveaux projets</p>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] p-6">
        <h3 class="text-lg font-semibold dark:text-white font-display mb-4">Actions rapides</h3>
        <div class="space-y-3">
            <a href="{{ route('profile.edit') }}" class="block rounded-xl border border-gray-200 dark:border-white/[0.08] px-4 py-3 text-sm font-medium dark:text-white hover:border-[#BEFF00]/40 transition">Modifier mon profil</a>
            <a href="{{ url('/') }}" class="block rounded-xl border border-gray-200 dark:border-white/[0.08] px-4 py-3 text-sm font-medium dark:text-white hover:border-[#BEFF00]/40 transition">Voir la vitrine</a>
            <a href="mailto:hello@portfolio.dev" class="block rounded-xl border border-gray-200 dark:border-white/[0.08] px-4 py-3 text-sm font-medium dark:text-white hover:border-[#BEFF00]/40 transition">Contacter</a>
        </div>
    </div>
</div>
@endsection

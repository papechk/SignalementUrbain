@extends('layouts.vitrine')

@section('title', 'Signalement confirmé')

@section('content')
<section class="py-20">
    <div class="mx-auto w-full max-w-lg px-4 text-center">
        <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="mb-4 text-6xl text-emerald-500">
                <i class="bi bi-check-circle"></i>
            </div>
            <h2 class="font-display text-2xl font-extrabold text-slate-900">Signalement envoyé !</h2>
            <p class="mt-2 text-sm text-slate-500">
                Votre signalement a bien été enregistré. Les services de la mairie de Dakar vont l'examiner dans les plus brefs délais.
            </p>

            <div class="my-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4">
                <p class="mb-1 text-xs text-slate-500">Votre numéro de référence</p>
                <p class="font-mono text-2xl font-bold tracking-wider text-brand-600">{{ $signalement->reference }}</p>
                <p class="mt-1 text-xs text-slate-500">Conservez ce numéro pour suivre votre signalement</p>
            </div>

            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('vitrine.suivi', ['reference' => $signalement->reference]) }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600">
                    <i class="bi bi-search"></i> Suivre mon signalement
                </a>
                <a href="{{ route('accueil') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    <i class="bi bi-house"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

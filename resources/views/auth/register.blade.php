@extends('layouts.vitrine')

@section('title', 'Créer un compte')

@section('content')
<section class="py-12">
    <div class="mx-auto w-full max-w-md px-4">
        <div class="mb-6 text-center">
            <div class="mx-auto mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-500/10">
                <i class="bi bi-person-plus text-2xl text-brand-500"></i>
            </div>
            <h1 class="font-display text-2xl font-extrabold text-slate-900">Créer un compte</h1>
            <p class="mt-1 text-sm text-slate-500">Rejoignez la plateforme citoyenne</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nom --}}
                <div class="mb-4">
                    <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nom complet</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="bi bi-person"></i></span>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 @error('name') border-rose-400 @enderror"
                               placeholder="Votre nom">
                    </div>
                    @error('name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Adresse email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="bi bi-envelope"></i></span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                               class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 @error('email') border-rose-400 @enderror"
                               placeholder="votre@email.com">
                    </div>
                    @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                {{-- Mot de passe --}}
                <div class="mb-4">
                    <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Mot de passe</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="bi bi-lock"></i></span>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 @error('password') border-rose-400 @enderror"
                               placeholder="••••••••">
                    </div>
                    @error('password') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                {{-- Confirmation --}}
                <div class="mb-5">
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-slate-700">Confirmer le mot de passe</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="bi bi-lock-fill"></i></span>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
                               placeholder="••••••••">
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full rounded-xl bg-brand-500 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600 focus:ring-2 focus:ring-brand-500/30">
                    <i class="bi bi-person-plus mr-2"></i>Créer mon compte
                </button>
            </form>

            <p class="mt-5 text-center text-sm text-slate-500">
                Déjà inscrit ?
                <a href="{{ route('login') }}" class="font-semibold text-brand-500 hover:underline">Se connecter</a>
            </p>
        </div>
    </div>
</section>
@endsection

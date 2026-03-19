@extends('layouts.vitrine')

@section('title', 'Connexion')

@section('content')
<section class="py-12">
    <div class="mx-auto w-full max-w-md px-4">
        <div class="mb-6 text-center">
            <div class="mx-auto mb-4 inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-500/10">
                <i class="bi bi-shield-lock text-2xl text-brand-500"></i>
            </div>
            <h1 class="font-display text-2xl font-extrabold text-slate-900">Connexion</h1>
            <p class="mt-1 text-sm text-slate-500">Accédez à votre espace d'administration</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @if(session('status'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Adresse email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="bi bi-envelope"></i></span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 @error('email') border-rose-400 @enderror"
                               placeholder="admin@mairie.fr">
                    </div>
                    @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Mot de passe</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400"><i class="bi bi-lock"></i></span>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 @error('password') border-rose-400 @enderror"
                               placeholder="••••••••">
                    </div>
                    @error('password') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                </div>

                {{-- Remember --}}
                <div class="mb-5 flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember"
                               class="h-4 w-4 rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                        Se souvenir de moi
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-medium text-brand-500 hover:underline">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full rounded-xl bg-brand-500 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600 focus:ring-2 focus:ring-brand-500/30">
                    <i class="bi bi-box-arrow-in-right mr-2"></i>Se connecter
                </button>
            </form>

            <p class="mt-5 text-center text-sm text-slate-500">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-semibold text-brand-500 hover:underline">Créer un compte</a>
            </p>
        </div>
    </div>
</section>
@endsection

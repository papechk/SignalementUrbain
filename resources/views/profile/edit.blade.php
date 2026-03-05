@extends('layouts.tailadmin')
@section('title', 'Mon profil')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold dark:text-white font-display">Mon profil</h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gerez vos informations personnelles et parametres de securite.</p>
</div>

<div class="space-y-6 max-w-3xl">
    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] p-6 sm:p-8">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] p-6 sm:p-8">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] p-6 sm:p-8">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection

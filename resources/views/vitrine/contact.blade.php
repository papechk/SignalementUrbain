@extends('layouts.vitrine')

@section('title', 'Contact')

@section('content')
<section class="py-14">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <h2 class="font-display text-3xl font-extrabold text-slate-900">Contactez la Mairie</h2>
            <p class="mt-2 text-slate-600">Vous avez une question ? N'hésitez pas à nous contacter.</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-5">
            {{-- Coordonnées --}}
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm h-full">
                    <h3 class="font-display text-lg font-bold text-slate-900 mb-6">
                        <i class="bi bi-building mr-2 text-brand-500"></i>Informations
                    </h3>

                    <div class="space-y-5">
                        <div class="flex gap-4">
                            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-600">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Adresse</p>
                                <p class="text-sm text-slate-500">Place de l'Indépendance<br>Dakar, Sénégal</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-600">
                                <i class="bi bi-telephone"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Téléphone</p>
                                <p class="text-sm text-slate-500">+221 33 849 45 67</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-600">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Email</p>
                                <p class="text-sm text-slate-500">contact@mairie-dakar.sn</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-600">
                                <i class="bi bi-clock"></i>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900">Horaires d'ouverture</p>
                                <p class="text-sm text-slate-500">
                                    Lun – Ven : 8h00 – 17h00<br>
                                    Sam : 9h00 – 12h00<br>
                                    Dim : Fermé
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="lg:col-span-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-slate-900 mb-6">
                        <i class="bi bi-envelope mr-2 text-brand-500"></i>Envoyez-nous un message
                    </h3>
                    <form action="{{ route('vitrine.contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="nom" class="mb-1 block text-sm font-semibold text-slate-700">Nom complet <span class="text-rose-500">*</span></label>
                                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required
                                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500"
                                       placeholder="Votre nom">
                            </div>
                            <div>
                                <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">Email <span class="text-rose-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                       class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500"
                                       placeholder="votre@email.com">
                            </div>
                        </div>
                        <div>
                            <label for="sujet" class="mb-1 block text-sm font-semibold text-slate-700">Sujet <span class="text-rose-500">*</span></label>
                            <select id="sujet" name="sujet" required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500">
                                <option value="Question sur un signalement">Question sur un signalement</option>
                                <option value="Signalement non traité">Signalement non traité</option>
                                <option value="Suggestion d'amélioration">Suggestion d'amélioration</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div>
                            <label for="message" class="mb-1 block text-sm font-semibold text-slate-700">Message <span class="text-rose-500">*</span></label>
                            <textarea id="message" name="message" rows="5" required
                                      class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:ring-brand-500"
                                      placeholder="Votre message...">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600">
                            <i class="bi bi-send"></i> Envoyer le message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

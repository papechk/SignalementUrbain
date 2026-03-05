@extends('layouts.vitrine')

@section('title', 'Tous les signalements')

@section('content')
<section style="padding: 3rem 0;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title">Signalements en cours</h2>
            <p class="section-subtitle mb-0">Consultez tous les signalements de la commune</p>
        </div>

        <!-- Filtres -->
        <div class="card mb-4 border-0 shadow-sm" style="border-radius:14px;">
            <div class="card-body">
                <form action="{{ route('vitrine.signalements') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Recherche</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="recherche" class="form-control" placeholder="Mot-clé..."
                                   value="{{ request('recherche') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted">Statut</label>
                        <select name="statut" class="form-select">
                            <option value="">Tous</option>
                            <option value="nouveau" {{ request('statut') == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                            <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="resolu" {{ request('statut') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                            <option value="rejete" {{ request('statut') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-muted">Priorité</label>
                        <select name="priorite" class="form-select">
                            <option value="">Toutes</option>
                            <option value="faible" {{ request('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                            <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                            <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                            <option value="urgente" {{ request('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Catégorie</label>
                        <select name="categorie_id" class="form-select">
                            <option value="">Toutes</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('categorie_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Résultats -->
        <div class="row g-4">
            @forelse($signalements as $sig)
            <div class="col-md-6 col-lg-4">
                <div class="sig-card h-100">
                    @if($sig->photo)
                    <div class="mb-3" style="border-radius:10px;overflow:hidden;height:160px;">
                        <img src="{{ asset($sig->photo) }}" alt="" class="w-100 h-100" style="object-fit:cover;">
                    </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge badge-{{ $sig->statut }} rounded-pill">{{ $sig->statut_label }}</span>
                        <span class="badge badge-{{ $sig->priorite }} rounded-pill">{{ ucfirst($sig->priorite) }}</span>
                    </div>
                    <a href="{{ route('vitrine.signalement.detail', $sig) }}" class="sig-title d-block mb-2">
                        {{ $sig->titre }}
                    </a>
                    <p class="text-muted small mb-3">{{ Str::limit($sig->description, 120) }}</p>
                    <div class="d-flex justify-content-between align-items-center sig-meta">
                        <span><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($sig->adresse, 30) }}</span>
                        <span><i class="bi bi-calendar me-1"></i>{{ $sig->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span class="sig-meta"><i class="bi bi-tag me-1"></i>{{ $sig->categorie->nom }}</span>
                        <a href="{{ route('vitrine.signalement.detail', $sig) }}" class="btn btn-sm btn-outline-custom py-1 px-2"
                           style="font-size:0.75rem;">
                            Détails <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                Aucun signalement ne correspond à vos critères
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($signalements->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $signalements->links() }}
        </div>
        @endif
    </div>
</section>
@endsection

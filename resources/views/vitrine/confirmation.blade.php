@extends('layouts.vitrine')

@section('title', 'Signalement confirmé')

@section('content')
<section style="padding: 5rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body p-5">
                        <div class="mb-4" style="font-size:4rem;color:#22c55e;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h3 class="fw-bold mb-3" style="color:var(--secondary);">Signalement envoyé !</h3>
                        <p class="text-muted mb-4">
                            Votre signalement a bien été enregistré. Les services de la mairie vont l'examiner dans les plus brefs délais.
                        </p>

                        <div class="p-3 rounded-3 mb-4" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                            <div class="small text-muted mb-1">Votre numéro de référence</div>
                            <div class="fs-4 fw-bold font-monospace" style="color:var(--primary);letter-spacing:0.05em;">
                                {{ $signalement->reference }}
                            </div>
                            <div class="small text-muted mt-1">Conservez ce numéro pour suivre votre signalement</div>
                        </div>

                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="{{ route('vitrine.suivi', ['reference' => $signalement->reference]) }}" class="btn btn-primary-custom">
                                <i class="bi bi-search me-1"></i> Suivre mon signalement
                            </a>
                            <a href="{{ route('accueil') }}" class="btn btn-outline-custom">
                                <i class="bi bi-house me-1"></i> Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

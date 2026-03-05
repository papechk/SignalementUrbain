@extends('layouts.vitrine')

@section('title', 'Contact')

@section('content')
<section style="padding: 3rem 0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Contactez la Mairie</h2>
            <p class="section-subtitle mb-0">Vous avez une question ? N'hésitez pas à nous contacter</p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Coordonnées -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4" style="color:var(--secondary);">
                            <i class="bi bi-building me-2 text-primary"></i>Informations
                        </h5>

                        <div class="d-flex mb-4">
                            <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                 style="width:45px;height:45px;min-width:45px;">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Adresse</div>
                                <div class="text-muted small">Place de la Mairie<br>75001 Paris</div>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                 style="width:45px;height:45px;min-width:45px;">
                                <i class="bi bi-telephone text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Téléphone</div>
                                <div class="text-muted small">01 23 45 67 89</div>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                 style="width:45px;height:45px;min-width:45px;">
                                <i class="bi bi-envelope text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Email</div>
                                <div class="text-muted small">contact@mairie.fr</div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="rounded-3 bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                 style="width:45px;height:45px;min-width:45px;">
                                <i class="bi bi-clock text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">Horaires d'ouverture</div>
                                <div class="text-muted small">
                                    Lun - Ven : 8h30 - 17h00<br>
                                    Sam : 9h00 - 12h00<br>
                                    Dim : Fermé
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire de contact -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius:16px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4" style="color:var(--secondary);">
                            <i class="bi bi-envelope me-2 text-primary"></i>Envoyez-nous un message
                        </h5>
                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nom complet <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Votre nom" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" placeholder="votre@email.com" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Sujet <span class="text-danger">*</span></label>
                                    <select class="form-select">
                                        <option>Question sur un signalement</option>
                                        <option>Signalement non traité</option>
                                        <option>Suggestion d'amélioration</option>
                                        <option>Autre</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="5" placeholder="Votre message..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom w-100">
                                        <i class="bi bi-send me-2"></i>Envoyer le message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

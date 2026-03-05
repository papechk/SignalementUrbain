<section id="projets" class="section-shell section-dark">
    <div class="portfolio-wrap projects-layout">
        <div class="projects-sticky scroll-reveal">
            <span class="section-kicker section-kicker-light">03 Projets</span>
            <h2 class="section-title section-title-light">Sélection de réalisations</h2>
            <p class="projects-intro">
                Une sélection de projets portfolio, brand et produit où design, code et motion avancent ensemble.
            </p>
        </div>

        <div class="projects-stack">
            @foreach([
                ['name' => 'Atelier Nova', 'type' => 'Identité + site vitrine', 'desc' => 'Direction artistique complète, storytelling visuel et page de conversion optimisée.', 'img' => 'https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?auto=format&fit=crop&w=1600&q=80'],
                ['name' => 'Pulse Analytics', 'type' => 'Plateforme SaaS', 'desc' => 'Refonte UX d’un tableau de bord data-first avec interactions animées en temps réel.', 'img' => 'https://images.unsplash.com/photo-1551281044-8b8d7f6f7f09?auto=format&fit=crop&w=1600&q=80'],
                ['name' => 'Maison Sable', 'type' => 'Portfolio premium', 'desc' => 'Expérience immersive orientée image, typographie forte et navigation fluide.', 'img' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80'],
                ['name' => 'Kora Studio', 'type' => 'Landing produit', 'desc' => 'Site de lancement avec narration verticale, CTA progressifs et performance mobile.', 'img' => 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1600&q=80'],
            ] as $project)
                <article class="project-card editorial-card scroll-reveal">
                    <div class="project-bg" style="background-image: url('{{ $project['img'] }}');"></div>
                    <div class="project-content">
                        <span class="project-index">0{{ $loop->iteration }}</span>
                        <p class="project-type">{{ $project['type'] }}</p>
                        <h3>{{ $project['name'] }}</h3>
                        <p>{{ $project['desc'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="services" class="section-shell section-cream">
    <div class="portfolio-wrap">
        <div class="scroll-reveal">
            <span class="section-kicker">04 Services</span>
            <h2 class="section-title">Ce que je construis pour vos marques</h2>
        </div>

        <div class="services-list">
            @foreach([
                ['title' => 'Direction artistique digitale', 'desc' => 'Systèmes visuels, ton éditorial, maquettes haute fidélité et cohérence de marque.'],
                ['title' => 'Développement Laravel & front-end', 'desc' => 'Intégration soignée, architecture claire et performance réelle sur desktop comme mobile.'],
                ['title' => 'Motion & interaction design', 'desc' => 'Animations GSAP utiles, transitions de sections et micro-interactions orientées conversion.'],
            ] as $item)
                <article class="service-row scroll-reveal">
                    <span class="service-number">0{{ $loop->iteration }}</span>
                    <div class="service-body">
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['desc'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

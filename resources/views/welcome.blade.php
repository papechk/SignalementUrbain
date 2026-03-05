<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Portfolio professionnel: direction artistique, développement Laravel et expériences digitales.">
    <title>{{ config('app.name', 'MonPortfolio') }} - Portfolio</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="portfolio-page cursor-none antialiased overflow-x-hidden">

<div id="cursor-dot" class="cursor-dot"></div>
<div id="cursor-ring" class="cursor-ring"></div>
<div id="cursor-label" class="cursor-label"></div>

<div x-data="{ scrolled: false, menuOpen: false }"
     x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 40 })"
     @keydown.escape.window="menuOpen = false">
    <nav class="portfolio-nav fixed top-0 left-0 right-0 z-50"
         :class="scrolled ? 'is-scrolled' : ''">
        <div class="portfolio-wrap h-[78px] flex items-center justify-between gap-4">
            <a href="#hero" class="brand-block">
                <span class="brand-mark">MP</span>
                <span class="brand-name">{{ config('app.name', 'MonPortfolio') }}</span>
            </a>

            <div class="hidden md:flex items-center gap-6 text-sm">
                @foreach([['À propos','apropos'],['Projets','projets'],['Services','services'],['Contact','contact']] as [$label,$id])
                    <a href="#{{ $id }}" class="nav-link">{{ $label }}</a>
                @endforeach
            </div>

            <div class="hidden md:flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="button-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="button-ghost">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="button-primary">Inscription</a>
                        @endif
                    @endauth
                @endif
            </div>

            <button @click="menuOpen = !menuOpen" class="md:hidden text-[var(--ink)] p-2">
                <svg x-show="!menuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="menuOpen" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </nav>

    <div x-show="menuOpen" x-cloak class="md:hidden fixed inset-0 z-40 bg-[var(--bg)] pt-[78px]">
        <div class="px-8 py-10 flex flex-col gap-6">
            @foreach([['À propos','apropos'],['Projets','projets'],['Services','services'],['Contact','contact']] as [$label,$id])
                <a href="#{{ $id }}" @click="menuOpen = false" class="text-[2rem] leading-none font-title text-[var(--ink)]">{{ $label }}</a>
            @endforeach

            <div class="pt-6 border-t border-black/10 flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="button-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="button-ghost">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="button-primary">Inscription</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</div>

<section id="hero" class="hero-section">
    <div class="hero-ambient"></div>
    <div class="portfolio-wrap hero-grid">
        <div class="hero-copy">
            <span class="scroll-reveal section-kicker">01 Intro</span>
            <h1 class="scroll-reveal hero-title">
                Designer et développeur web
                <span>pour des marques ambitieuses.</span>
            </h1>
            <p class="scroll-reveal hero-text">
                Je conçois des expériences digitales élégantes, rapides et mémorables.
                Basé à Dakar, j’accompagne startups et entreprises sur toute la chaîne produit.
            </p>
            <div class="scroll-reveal hero-actions">
                <a href="#projets" class="button-primary">Voir mes projets</a>
                <a href="#contact" class="button-ghost">Parler d’un projet</a>
            </div>
        </div>

        <aside class="scroll-reveal-right hero-panel">
            <p class="hero-panel-title">Focus 2026</p>
            <ul class="hero-panel-list">
                <li><span>Stack</span><strong>Laravel, Blade, Tailwind, GSAP</strong></li>
                <li><span>Mission</span><strong>Portfolio, sites premium, interfaces SaaS</strong></li>
                <li><span>Disponibilité</span><strong>Nouvelles collaborations ouvertes</strong></li>
            </ul>
        </aside>
    </div>
    <div class="hero-marquee scroll-reveal">
        <span>Direction artistique</span>
        <span>Développement Laravel</span>
        <span>Motion design</span>
        <span>Performance web</span>
    </div>
</section>

@include('partials.vitrine.apropos')
@include('partials.vitrine.content')
@include('partials.vitrine.contact')

<footer class="portfolio-footer">
    <div class="portfolio-wrap footer-inner">
        <p>© {{ date('Y') }} {{ config('app.name', 'MonPortfolio') }}. Tous droits réservés.</p>
        <div class="footer-links">
            <a href="#hero">Haut de page</a>
            <a href="#projets">Projets</a>
            <a href="#contact">Contact</a>
        </div>
    </div>
</footer>

</body>
</html>

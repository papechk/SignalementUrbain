<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Signalement Urbain') - Mairie</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f7ff',
                            100: '#dcecff',
                            500: '#1d6fe8',
                            600: '#165fcb',
                            700: '#144ea5',
                            900: '#0d2f63'
                        }
                    },
                    fontFamily: {
                        sans: ['Public Sans', 'ui-sans-serif', 'system-ui'],
                        display: ['Manrope', 'ui-sans-serif', 'system-ui']
                    },
                    boxShadow: {
                        soft: '0 16px 40px -20px rgba(15, 23, 42, 0.3)'
                    }
                }
            }
        }
    </script>

    <!-- Compat temporaire pour les pages non migrees -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Public Sans', sans-serif; }

        /* Classes legacy utilisees sur les vues encore en Bootstrap */
        .section-title {
            font-family: 'Manrope', sans-serif;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: .35rem;
            font-size: 1.75rem;
        }

        .section-subtitle {
            color: #64748b;
            font-size: 1rem;
            margin-bottom: 1.75rem;
        }

        .btn-primary-custom {
            background: #1d6fe8;
            border: none;
            border-radius: .75rem;
            padding: .7rem 1.4rem;
            color: #fff;
            font-weight: 600;
        }

        .btn-primary-custom:hover { background: #165fcb; color: #fff; }

        .btn-outline-custom {
            border: 2px solid #1d6fe8;
            border-radius: .75rem;
            padding: .65rem 1.3rem;
            color: #1d6fe8;
            font-weight: 600;
            background: transparent;
        }

        .btn-outline-custom:hover { background: #1d6fe8; color: #fff; }

        .badge-nouveau  { background: #dbeafe; color: #1d4ed8; }
        .badge-en_cours { background: #fef3c7; color: #b45309; }
        .badge-resolu   { background: #d1fae5; color: #065f46; }
        .badge-rejete   { background: #fee2e2; color: #991b1b; }
        .badge-faible   { background: #e0f2fe; color: #0369a1; }
        .badge-moyenne  { background: #dbeafe; color: #1d4ed8; }
        .badge-haute    { background: #fef3c7; color: #b45309; }
        .badge-urgente  { background: #fee2e2; color: #991b1b; }
    </style>

    @stack('styles')
</head>
<body class="min-h-full bg-slate-50 text-slate-800">
    <header class="sticky top-0 z-40 border-b border-slate-800/40 bg-slate-950/95 backdrop-blur">
        <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('accueil') }}" class="inline-flex items-center gap-2 text-white">
                <span class="grid h-9 w-9 place-content-center rounded-lg bg-brand-500/20 text-brand-100">
                    <i class="bi bi-building text-lg"></i>
                </span>
                <span class="font-display text-lg font-extrabold tracking-tight">Signalement Urbain</span>
            </a>

            <nav class="hidden items-center gap-2 md:flex">
                <a href="{{ route('accueil') }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('accueil') ? 'bg-white text-slate-900' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                    Accueil
                </a>
                <a href="{{ route('vitrine.signalements') }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('vitrine.signalements') ? 'bg-white text-slate-900' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                    Signalements
                </a>
                <a href="{{ route('vitrine.suivi') }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('vitrine.suivi') ? 'bg-white text-slate-900' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                    Suivi
                </a>
                <a href="{{ route('vitrine.contact') }}"
                   class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('vitrine.contact') ? 'bg-white text-slate-900' : 'text-slate-200 hover:bg-white/10 hover:text-white' }}">
                    Contact
                </a>
            </nav>

            <div class="hidden md:block">
                <a href="{{ route('vitrine.signaler') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-semibold text-white shadow-soft transition hover:bg-brand-600">
                    <i class="bi bi-megaphone"></i>
                    Signaler
                </a>
            </div>

            <button id="mobileMenuBtn"
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-700 text-slate-100 hover:bg-slate-800 md:hidden"
                    aria-expanded="false"
                    aria-controls="mobileMenu">
                <i class="bi bi-list text-xl"></i>
            </button>
        </div>

        <div id="mobileMenu" class="hidden border-t border-slate-800 bg-slate-950 md:hidden">
            <div class="space-y-1 px-4 py-3">
                <a href="{{ route('accueil') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('accueil') ? 'bg-white text-slate-900' : 'text-slate-200 hover:bg-white/10' }}">Accueil</a>
                <a href="{{ route('vitrine.signalements') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('vitrine.signalements') ? 'bg-white text-slate-900' : 'text-slate-200 hover:bg-white/10' }}">Signalements</a>
                <a href="{{ route('vitrine.suivi') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('vitrine.suivi') ? 'bg-white text-slate-900' : 'text-slate-200 hover:bg-white/10' }}">Suivi</a>
                <a href="{{ route('vitrine.contact') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('vitrine.contact') ? 'bg-white text-slate-900' : 'text-slate-200 hover:bg-white/10' }}">Contact</a>
                <a href="{{ route('vitrine.signaler') }}" class="mt-2 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                    <i class="bi bi-megaphone"></i>
                    Signaler un probleme
                </a>
            </div>
        </div>
    </header>

    <div class="mx-auto w-full max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                <i class="bi bi-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                <i class="bi bi-x-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                <div class="mb-1 font-semibold"><i class="bi bi-exclamation-triangle mr-2"></i>Erreurs:</div>
                <ul class="ml-5 list-disc space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="mt-16 border-t border-slate-200 bg-white">
        <div class="mx-auto grid w-full max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-4 lg:px-8">
            <div class="lg:col-span-2">
                <h3 class="font-display text-xl font-extrabold text-slate-900">Signalement Urbain</h3>
                <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600">
                    Plateforme citoyenne pour signaler rapidement les incidents urbains et suivre leur traitement.
                </p>
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Navigation</h4>
                <ul class="mt-3 space-y-2 text-sm text-slate-700">
                    <li><a class="hover:text-brand-600" href="{{ route('accueil') }}">Accueil</a></li>
                    <li><a class="hover:text-brand-600" href="{{ route('vitrine.signalements') }}">Signalements</a></li>
                    <li><a class="hover:text-brand-600" href="{{ route('vitrine.suivi') }}">Suivi</a></li>
                    <li><a class="hover:text-brand-600" href="{{ route('vitrine.contact') }}">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Administration</h4>
                <p class="mt-3 text-sm text-slate-600">Acces reserve aux services municipaux.</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="mt-3 inline-flex items-center gap-2 rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:border-slate-400 hover:bg-slate-100">
                    <i class="bi bi-shield-lock"></i>
                    Ouvrir admin
                </a>
            </div>
        </div>
        <div class="border-t border-slate-200 py-4 text-center text-xs text-slate-500">
            &copy; 2026 Mairie - Signalement Urbain
        </div>
    </footer>

    <script>
        (function () {
            const btn = document.getElementById('mobileMenuBtn');
            const menu = document.getElementById('mobileMenu');
            if (!btn || !menu) return;
            btn.addEventListener('click', function () {
                const isHidden = menu.classList.contains('hidden');
                menu.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', String(isHidden));
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>

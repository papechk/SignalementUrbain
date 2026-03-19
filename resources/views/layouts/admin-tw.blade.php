<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - Mairie</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&family=Public+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#f0f7ff', 100:'#dcecff', 500:'#1d6fe8', 600:'#165fcb', 700:'#144ea5', 900:'#0d2f63' },
                        sidebar: { DEFAULT:'#0f172a', light:'#1e293b' }
                    },
                    fontFamily: {
                        sans: ['Public Sans','ui-sans-serif','system-ui'],
                        display: ['Manrope','ui-sans-serif','system-ui']
                    }
                }
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        [x-cloak]{display:none!important}
        body{font-family:'Public Sans',sans-serif}
    </style>
    @stack('styles')
</head>
<body class="h-full bg-slate-50" x-data="{ sidebarOpen: false }">

    {{-- Overlay mobile --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen=false"
         class="fixed inset-0 z-30 bg-black/40 lg:hidden" x-transition.opacity></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col bg-sidebar transition-transform duration-200 lg:translate-x-0">

        {{-- Brand --}}
        <div class="flex h-16 items-center gap-3 border-b border-white/10 px-5">
            <span class="grid h-9 w-9 place-content-center rounded-lg bg-brand-500/20 text-brand-100">
                <i class="bi bi-building text-lg"></i>
            </span>
            <div>
                <span class="font-display text-base font-extrabold tracking-tight text-white">Mairie Admin</span>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            <p class="mb-1 px-3 text-[0.65rem] font-bold uppercase tracking-widest text-slate-500">Navigation</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-brand-500/15 text-brand-100' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-speedometer2 text-base"></i> Tableau de bord
            </a>

            <p class="mb-1 mt-5 px-3 text-[0.65rem] font-bold uppercase tracking-widest text-slate-500">Gestion</p>

            <a href="{{ route('admin.signalements.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
               {{ request()->routeIs('admin.signalements.*') ? 'bg-brand-500/15 text-brand-100' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-exclamation-triangle text-base"></i> Signalements
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition
               {{ request()->routeIs('admin.categories.*') ? 'bg-brand-500/15 text-brand-100' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                <i class="bi bi-tags text-base"></i> Catégories
            </a>

            <p class="mb-1 mt-5 px-3 text-[0.65rem] font-bold uppercase tracking-widest text-slate-500">Site public</p>
            <a href="{{ route('accueil') }}" target="_blank"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                <i class="bi bi-globe text-base"></i> Voir le site
            </a>
            <a href="{{ route('vitrine.carte') }}" target="_blank"
               class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-300 hover:bg-white/5 hover:text-white transition">
                <i class="bi bi-map text-base"></i> Carte
            </a>
        </nav>

        {{-- Footer --}}
        <div class="border-t border-white/10 px-5 py-3">
            <div class="flex items-center gap-3">
                <div class="grid h-8 w-8 place-content-center rounded-full bg-brand-500 text-xs font-bold text-white">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="truncate text-xs text-slate-400">{{ Auth::user()->email ?? '' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-rose-400 transition" title="Déconnexion">
                        <i class="bi bi-box-arrow-right text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ===== TOP BAR ===== --}}
    <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-slate-200 bg-white px-4 lg:pl-72">
        <button @click="sidebarOpen=!sidebarOpen" class="rounded-lg border border-slate-300 p-2 text-slate-500 hover:bg-slate-100 lg:hidden">
            <i class="bi bi-list text-xl"></i>
        </button>

        <nav class="hidden text-sm text-slate-500 sm:block">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-600">Admin</a>
            <span class="mx-1.5">/</span>
            <span class="font-medium text-slate-800">@yield('title', 'Dashboard')</span>
        </nav>

        <div class="ml-auto flex items-center gap-3">
            <a href="{{ route('accueil') }}" target="_blank"
               class="hidden items-center gap-2 rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-100 sm:inline-flex">
                <i class="bi bi-globe"></i> Site public
            </a>
        </div>
    </header>

    {{-- ===== MAIN ===== --}}
    <main class="lg:pl-64">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                    <i class="bi bi-check-circle text-lg"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                    <i class="bi bi-x-circle text-lg"></i>{{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                    <p class="mb-1 font-semibold"><i class="bi bi-exclamation-triangle mr-2"></i>Erreurs :</p>
                    <ul class="ml-5 list-disc space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js" defer></script>
    @stack('scripts')
</body>
</html>

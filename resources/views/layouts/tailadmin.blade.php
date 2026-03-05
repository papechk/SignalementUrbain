<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Espace membre') | {{ config('app.name', 'MonPortfolio') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --brand: #BEFF00;
            --brand-hover: #a8e000;
            --dark: #0C0C0C;
        }
        body { font-family: 'Outfit', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
        .btn-primary { background-color: var(--brand); color: var(--dark); }
        .btn-primary:hover { background-color: var(--brand-hover); }
    </style>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="bg-gray-50 dark:bg-[#0C0C0C] text-gray-900 dark:text-gray-100"
      x-data="{ darkMode: document.documentElement.classList.contains('dark'), menuOpen: false }"
      x-init="$watch('darkMode', v => { document.documentElement.classList.toggle('dark', v); localStorage.setItem('theme', v ? 'dark' : 'light') })">

    <div class="min-h-screen flex">
        <aside class="hidden md:flex w-64 shrink-0 border-r border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#111111] flex-col">
            <div class="px-6 py-6 border-b border-gray-200 dark:border-white/[0.08]">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#BEFF00]">
                        <svg class="h-5 w-5 text-[#0C0C0C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20M2 12h20"/></svg>
                    </span>
                    <span class="text-xl font-bold dark:text-white">MonPortfolio</span>
                </a>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-[#BEFF00] text-[#0C0C0C]' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/[0.06]' }}">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('profile.edit') ? 'bg-[#BEFF00] text-[#0C0C0C]' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/[0.06]' }}">Profil</a>
            </nav>

            <div class="mt-auto p-4 border-t border-gray-200 dark:border-white/[0.08]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-xl px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/[0.06] transition text-left">Deconnexion</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 min-w-0">
            <header class="sticky top-0 z-20 bg-white/95 dark:bg-[#0C0C0C]/95 backdrop-blur border-b border-gray-200 dark:border-white/[0.08]">
                <div class="h-16 px-4 md:px-6 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <button @click="menuOpen = !menuOpen" class="md:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 dark:border-white/[0.08] text-gray-600 dark:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <h1 class="text-base md:text-lg font-semibold dark:text-white">@yield('title', 'Espace membre')</h1>
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="darkMode = !darkMode" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 dark:border-white/[0.08] text-gray-600 dark:text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                        </button>
                        <a href="{{ url('/') }}" class="inline-flex rounded-lg px-3 py-2 text-sm font-medium border border-gray-200 dark:border-white/[0.08] text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/[0.06]">Vitrine</a>
                    </div>
                </div>
            </header>

            <div x-show="menuOpen" x-cloak class="md:hidden fixed inset-0 z-30 bg-black/30" @click="menuOpen = false"></div>
            <aside x-show="menuOpen" x-cloak class="md:hidden fixed left-0 top-0 bottom-0 z-40 w-64 bg-white dark:bg-[#111111] border-r border-gray-200 dark:border-white/[0.08] p-4">
                <div class="mb-4 flex items-center justify-between">
                    <span class="font-semibold dark:text-white">Menu</span>
                    <button @click="menuOpen = false" class="h-8 w-8 inline-flex items-center justify-center rounded-lg border border-gray-200 dark:border-white/[0.08] text-gray-600 dark:text-gray-300">x</button>
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/[0.06]">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/[0.06]">Profil</a>
                </nav>
            </aside>

            <main class="mx-auto w-full max-w-screen-xl p-4 md:p-6 xl:p-8">
                @if(session('success'))
                    <div class="mb-4 rounded-xl bg-green-50 dark:bg-green-500/10 border border-green-200 dark:border-green-500/20 px-4 py-3 text-sm text-green-700 dark:text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 px-4 py-3 text-sm text-red-700 dark:text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>

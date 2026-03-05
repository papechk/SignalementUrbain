<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MonPortfolio') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-display { font-family: 'Outfit', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            const system = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            if ((saved || system) === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>
</head>
<body class="min-h-full antialiased bg-gray-50 dark:bg-[#0C0C0C]"
      x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches) }">

    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-10">
        <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light'); document.documentElement.classList.toggle('dark', darkMode)"
                class="fixed top-5 right-5 z-50 flex items-center justify-center w-10 h-10 rounded-xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] text-gray-500 dark:text-gray-400 shadow-sm hover:bg-gray-100 dark:hover:bg-white/[0.06] transition">
            <svg x-show="darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>
        </button>

        <a href="/" class="mb-8 flex items-center gap-3">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl" style="background-color: #BEFF00;">
                <svg class="h-6 w-6 text-[#0C0C0C]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20M2 12h20"/>
                </svg>
            </span>
            <span class="text-2xl font-bold text-gray-900 dark:text-white font-display tracking-tight">MonPortfolio</span>
        </a>

        <div class="w-full max-w-md rounded-2xl border border-gray-200 dark:border-white/[0.08] bg-white dark:bg-[#161616] p-8 shadow-xl shadow-black/5 dark:shadow-black/30">
            {{ $slot }}
        </div>

        <p class="mt-6 text-xs text-gray-400 dark:text-gray-600">
            &copy; {{ date('Y') }} MonPortfolio. Tous droits reserves.
        </p>
    </div>
</body>
</html>

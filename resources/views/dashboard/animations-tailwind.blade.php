<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Animations Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Sora', 'sans-serif'],
                    },
                    keyframes: {
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideInLeft: {
                            '0%': { opacity: '0', transform: 'translateX(-28px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        },
                        zoomIn: {
                            '0%': { opacity: '0', transform: 'scale(0.85)' },
                            '100%': { opacity: '1', transform: 'scale(1)' },
                        },
                        flipIn: {
                            '0%': { opacity: '0', transform: 'perspective(500px) rotateX(-18deg)' },
                            '100%': { opacity: '1', transform: 'perspective(500px) rotateX(0deg)' },
                        },
                        pulseSoft: {
                            '0%, 100%': { transform: 'scale(1)', opacity: '1' },
                            '50%': { transform: 'scale(1.05)', opacity: '.85' },
                        },
                        bounceSoft: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-8px)' },
                        },
                        wiggle: {
                            '0%, 100%': { transform: 'rotate(-2deg)' },
                            '50%': { transform: 'rotate(2deg)' },
                        },
                        floatY: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        progressGrow: {
                            '0%': { width: '0%' },
                            '100%': { width: 'var(--to, 70%)' },
                        },
                    },
                    animation: {
                        fadeUp: 'fadeUp .65s ease-out both',
                        slideInLeft: 'slideInLeft .65s ease-out both',
                        zoomIn: 'zoomIn .5s ease-out both',
                        flipIn: 'flipIn .7s cubic-bezier(.2,.7,.2,1) both',
                        pulseSoft: 'pulseSoft 1.6s ease-in-out infinite',
                        bounceSoft: 'bounceSoft 1.1s ease-in-out infinite',
                        wiggle: 'wiggle .8s ease-in-out infinite',
                        floatY: 'floatY 2.6s ease-in-out infinite',
                        progressGrow: 'progressGrow 1.1s ease-out both',
                    },
                },
            },
        };
    </script>
    <style>
        :root {
            --bg-a: #fff7ed;
            --bg-b: #ecfeff;
            --ink: #0f172a;
            --panel: rgba(255, 255, 255, 0.72);
            --line: rgba(15, 23, 42, 0.10);
        }

        body {
            font-family: "Sora", sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 15% 20%, rgba(249, 115, 22, 0.18), transparent 45%),
                radial-gradient(circle at 85% 8%, rgba(20, 184, 166, 0.16), transparent 42%),
                linear-gradient(140deg, var(--bg-a), var(--bg-b));
        }

        .glass {
            background: var(--panel);
            border: 1px solid var(--line);
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(8px);
        }

        .grid-bg {
            background-image:
                linear-gradient(rgba(15, 23, 42, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 23, 42, 0.04) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .paused * {
            animation-play-state: paused !important;
            transition-duration: 0ms !important;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="grid-bg min-h-screen">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <header class="glass rounded-3xl p-6 md:p-8 animate-fadeUp">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-700">Tailwind Motion Lab</p>
                        <h1 class="mt-2 text-3xl font-extrabold md:text-4xl">Dashboard des animations</h1>
                        <p class="mt-2 max-w-2xl text-sm text-slate-700 md:text-base">
                            Cette page centralise les animations d entree, d attention et de micro-interactions.
                            Tu peux les tester en direct et les mettre en pause.
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button id="replayBtn" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-800 transition hover:-translate-y-0.5 hover:bg-slate-100">
                            Rejouer
                        </button>
                        <button id="toggleBtn" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-700">
                            Pause animations
                        </button>
                    </div>
                </div>
            </header>

            <section class="mt-8">
                <h2 class="mb-4 text-xl font-bold">Animations d entree</h2>
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="glass rounded-2xl p-5">
                        <p class="text-sm font-semibold text-slate-800">Fade Up</p>
                        <div data-replay class="mt-4 flex h-24 items-center justify-center rounded-xl bg-orange-100 animate-fadeUp">
                            <span class="rounded-lg bg-orange-500 px-3 py-1 text-sm font-bold text-white">animate-fadeUp</span>
                        </div>
                    </article>
                    <article class="glass rounded-2xl p-5">
                        <p class="text-sm font-semibold text-slate-800">Slide In Left</p>
                        <div data-replay class="mt-4 flex h-24 items-center justify-center rounded-xl bg-cyan-100 animate-slideInLeft">
                            <span class="rounded-lg bg-cyan-600 px-3 py-1 text-sm font-bold text-white">animate-slideInLeft</span>
                        </div>
                    </article>
                    <article class="glass rounded-2xl p-5">
                        <p class="text-sm font-semibold text-slate-800">Zoom In</p>
                        <div data-replay class="mt-4 flex h-24 items-center justify-center rounded-xl bg-emerald-100 animate-zoomIn">
                            <span class="rounded-lg bg-emerald-600 px-3 py-1 text-sm font-bold text-white">animate-zoomIn</span>
                        </div>
                    </article>
                    <article class="glass rounded-2xl p-5">
                        <p class="text-sm font-semibold text-slate-800">Flip In</p>
                        <div data-replay class="mt-4 flex h-24 items-center justify-center rounded-xl bg-amber-100 animate-flipIn">
                            <span class="rounded-lg bg-amber-600 px-3 py-1 text-sm font-bold text-white">animate-flipIn</span>
                        </div>
                    </article>
                </div>
            </section>

            <section class="mt-8">
                <h2 class="mb-4 text-xl font-bold">Animations d attention</h2>
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="glass rounded-2xl p-5">
                        <p class="text-sm font-semibold text-slate-800">Pulse Soft</p>
                        <div class="mt-4 flex h-24 items-center justify-center rounded-xl bg-rose-100">
                            <span class="rounded-lg bg-rose-500 px-3 py-1 text-sm font-bold text-white animate-pulseSoft">animate-pulseSoft</span>
                        </div>
                    </article>
                    <article class="glass rounded-2xl p-5">
                        <p class="text-sm font-semibold text-slate-800">Bounce Soft</p>
                        <div class="mt-4 flex h-24 items-center justify-center rounded-xl bg-lime-100">
                            <span class="rounded-lg bg-lime-600 px-3 py-1 text-sm font-bold text-white animate-bounceSoft">animate-bounceSoft</span>
                        </div>
                    </article>
                    <article class="glass rounded-2xl p-5">
                        <p class="text-sm font-semibold text-slate-800">Wiggle</p>
                        <div class="mt-4 flex h-24 items-center justify-center rounded-xl bg-sky-100">
                            <span class="rounded-lg bg-sky-600 px-3 py-1 text-sm font-bold text-white animate-wiggle">animate-wiggle</span>
                        </div>
                    </article>
                    <article class="glass rounded-2xl p-5">
                        <p class="text-sm font-semibold text-slate-800">Float Y</p>
                        <div class="mt-4 flex h-24 items-center justify-center rounded-xl bg-orange-100">
                            <span class="rounded-lg bg-orange-500 px-3 py-1 text-sm font-bold text-white animate-floatY">animate-floatY</span>
                        </div>
                    </article>
                </div>
            </section>

            <section class="mt-8 grid gap-4 lg:grid-cols-2">
                <article class="glass rounded-2xl p-6">
                    <h2 class="text-xl font-bold">Stagger de cartes</h2>
                    <p class="mt-1 text-sm text-slate-700">Exemple d apparition echelle par echelle pour listes et dashboards.</p>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        @for($i = 1; $i <= 6; $i++)
                            <div data-replay class="rounded-xl border border-slate-200 bg-white p-4 opacity-0 animate-fadeUp"
                                 style="animation-delay: {{ $i * 90 }}ms; animation-fill-mode: forwards;">
                                <p class="text-sm font-semibold text-slate-800">Bloc {{ $i }}</p>
                                <p class="mt-1 text-xs text-slate-500">Delay {{ $i * 90 }}ms</p>
                            </div>
                        @endfor
                    </div>
                </article>
                <article class="glass rounded-2xl p-6">
                    <h2 class="text-xl font-bold">Barres animees</h2>
                    <p class="mt-1 text-sm text-slate-700">Simulation de progression pour KPI et chargement.</p>
                    <div class="mt-5 space-y-4">
                        <div>
                            <div class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Traitement tickets</div>
                            <div class="h-3 overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-teal-500 animate-progressGrow" style="--to: 76%; width: 76%;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Resolution hebdo</div>
                            <div class="h-3 overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-orange-500 animate-progressGrow" style="--to: 62%; width: 62%; animation-delay: 120ms;"></div>
                            </div>
                        </div>
                        <div>
                            <div class="mb-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Qualite de service</div>
                            <div class="h-3 overflow-hidden rounded-full bg-slate-200">
                                <div class="h-full rounded-full bg-sky-600 animate-progressGrow" style="--to: 88%; width: 88%; animation-delay: 220ms;"></div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>

            <section class="mt-8 glass rounded-2xl p-6">
                <h2 class="text-xl font-bold">Micro-interactions UI</h2>
                <p class="mt-1 text-sm text-slate-700">Hover, focus et transitions pour les composants actionnables.</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <button class="rounded-xl bg-teal-600 px-5 py-2.5 text-sm font-semibold text-white transition duration-300 hover:-translate-y-1 hover:scale-[1.03] hover:bg-teal-500 focus:outline-none focus:ring-2 focus:ring-teal-300">
                        Bouton principal
                    </button>
                    <button class="rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-800 transition duration-300 hover:-translate-y-1 hover:border-slate-400 hover:shadow-md">
                        Bouton secondaire
                    </button>
                    <button class="group rounded-xl bg-orange-500 px-5 py-2.5 text-sm font-semibold text-white transition duration-300 hover:bg-orange-400">
                        <span class="inline-block transition group-hover:translate-x-1">Action avec icone -></span>
                    </button>
                </div>
            </section>
        </div>
    </div>

    <script>
        const root = document.body;
        const toggleBtn = document.getElementById('toggleBtn');
        const replayBtn = document.getElementById('replayBtn');

        toggleBtn.addEventListener('click', () => {
            root.classList.toggle('paused');
            toggleBtn.textContent = root.classList.contains('paused')
                ? 'Relancer animations'
                : 'Pause animations';
        });

        replayBtn.addEventListener('click', () => {
            document.querySelectorAll('[data-replay]').forEach((node) => {
                const baseClasses = node.className;
                node.className = baseClasses.replace(/animate-[^\s]+/g, '').trim();
                // Reflow to restart animation
                void node.offsetWidth;
                const firstAnim = (baseClasses.match(/animate-[^\s]+/) || [])[0];
                if (firstAnim) node.classList.add(firstAnim);
            });
        });
    </script>
</body>
</html>

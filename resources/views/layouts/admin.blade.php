<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') - Mairie</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #2563eb;
            --sidebar-bg: #1e293b;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            z-index: 1050;
            overflow-y: auto;
            transition: transform 0.3s;
        }

        .sidebar .brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .brand h4 {
            margin: 0;
            font-weight: 700;
            color: #60a5fa;
        }

        .sidebar .brand small {
            color: #94a3b8;
            font-size: 0.75rem;
        }

        .sidebar .nav-section {
            padding: 0.75rem 1.5rem 0.25rem;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #64748b;
            font-weight: 700;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.6rem 1.5rem;
            border-radius: 0;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(96, 165, 250, 0.15);
            color: #60a5fa;
        }

        .sidebar .nav-link i {
            width: 22px;
            margin-right: 10px;
            text-align: center;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* ===== TOP BAR ===== */
        .topbar {
            margin-left: var(--sidebar-width);
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .topbar .btn-sidebar-toggle {
            display: none;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem 2rem;
            min-height: calc(100vh - 60px);
        }

        /* ===== CARDS ===== */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }

        /* ===== TABLE ===== */
        .table th {
            font-weight: 600;
            color: #475569;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* ===== PAGE HEADER ===== */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h2 {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.5rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .topbar {
                margin-left: 0;
            }
            .topbar .btn-sidebar-toggle {
                display: inline-flex;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.4);
                z-index: 1045;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay d-none" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- ===== SIDEBAR ===== -->
    <nav class="sidebar" id="sidebar">
        <div class="brand">
            <h4><i class="bi bi-building"></i> Mairie</h4>
            <small>Panneau d'administration</small>
        </div>

        <ul class="nav flex-column mt-2">
            <li class="nav-section">Navigation</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
            </li>

            <li class="nav-section mt-3">Gestion</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.signalements.*') && !request()->routeIs('admin.signalements.create') ? 'active' : '' }}"
                   href="{{ route('admin.signalements.index') }}">
                    <i class="bi bi-exclamation-triangle"></i> Signalements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.signalements.create') ? 'active' : '' }}"
                   href="{{ route('admin.signalements.create') }}">
                    <i class="bi bi-plus-circle"></i> Nouveau signalement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                   href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags"></i> Catégories
                </a>
            </li>

            <li class="nav-section mt-3">Site public</li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('accueil') }}" target="_blank">
                    <i class="bi bi-globe"></i> Voir le site
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center text-white-50 small">
                <i class="bi bi-shield-lock me-2"></i>
                <span>Admin v1.0 — 2026</span>
            </div>
        </div>
    </nav>

    <!-- ===== TOP BAR ===== -->
    <header class="topbar">
        <div class="d-flex align-items-center">
            <button class="btn btn-sm btn-outline-secondary btn-sidebar-toggle me-3" onclick="toggleSidebar()">
                <i class="bi bi-list fs-5"></i>
            </button>
            <nav aria-label="breadcrumb" class="mb-0">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Admin</a></li>
                    @yield('breadcrumb')
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('accueil') }}" class="btn btn-sm btn-outline-primary" target="_blank">
                <i class="bi bi-globe me-1"></i> Site public
            </a>
            <div class="d-flex align-items-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="width:34px;height:34px;font-size:0.85rem;font-weight:600;">
                    A
                </div>
            </div>
        </div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="main-content">
        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Erreurs de validation :</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('d-none');
        }
    </script>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Signalement Urbain') - Mairie</title>

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

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar .brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .brand h4 {
            margin: 0;
            font-weight: 700;
            color: #60a5fa;
        }

        .sidebar .brand small {
            color: #94a3b8;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 0.75rem 1.5rem;
            border-radius: 0;
            transition: all 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(96, 165, 250, 0.15);
            color: #60a5fa;
        }

        .sidebar .nav-link i {
            width: 24px;
            margin-right: 10px;
        }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            min-height: 100vh;
        }

        /* Cards */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
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
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }

        /* Badge statut */
        .badge-statut {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }

        /* Table */
        .table th {
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Breadcrumb */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h2 {
            font-weight: 700;
            color: #1e293b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="brand">
            <h4><i class="bi bi-building"></i> Mairie</h4>
            <small>Signalement Urbain</small>
        </div>
        <ul class="nav flex-column mt-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('signalements.*') ? 'active' : '' }}"
                   href="{{ route('signalements.index') }}">
                    <i class="bi bi-exclamation-triangle"></i> Signalements
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('signalements.create') ? 'active' : '' }}"
                   href="{{ route('signalements.create') }}">
                    <i class="bi bi-plus-circle"></i> Nouveau signalement
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}"
                   href="{{ route('categories.index') }}">
                    <i class="bi bi-tags"></i> Catégories
                </a>
            </li>
        </ul>

        <div class="mt-auto p-3" style="position: absolute; bottom: 0; width: 100%;">
            <div class="d-flex align-items-center text-white-50 small">
                <i class="bi bi-info-circle me-2"></i>
                <span>v1.0 - Mairie 2026</span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
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
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

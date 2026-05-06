<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Sejenak Studio')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #137887;
            --ink-deep: #0d6472;
            --paper: #fffaf0;
            --paper-soft: #fff0c7;
            --white: #ffffff;
            --accent: #f7a900;
            --accent-soft: #ffc841;
            --muted: #5d7d82;
            --line: rgba(19, 120, 135, .16);
            --line-strong: rgba(19, 120, 135, .32);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-pill: 999px;
            --serif: "Playfair Display", serif;
            --sans: "Manrope", sans-serif;
        }

        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at 96% 4%, rgba(247,169,0,.18) 0 13%, transparent 13.5%),
                linear-gradient(135deg, #fffaf0 0%, #f4fbfb 100%);
            color: var(--ink-deep);
            font-family: var(--sans);
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;
            width: 270px;
            height: 100vh;
            overflow-y: auto;
            padding: 24px 18px;
            background:
                radial-gradient(circle at 12% 90%, rgba(247,169,0,.95) 0 14%, transparent 14.5%),
                var(--ink);
            color: var(--white);
        }

        .sidebar-brand {
            display: block;
            margin: 0 6px 24px;
            color: var(--white);
            font-family: var(--serif);
            font-size: 28px;
            font-style: italic;
            line-height: 1;
            text-decoration: none;
        }

        .sidebar-brand span {
            display: block;
            color: var(--accent-soft);
            font-family: var(--sans);
            font-size: 11px;
            font-style: normal;
            font-weight: 700;
            letter-spacing: .18em;
            margin-top: 6px;
            text-transform: uppercase;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 44px;
            margin-bottom: 6px;
            padding: 11px 13px;
            border-radius: var(--radius-md);
            color: rgba(255,255,255,.76);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s ease, color .2s ease, transform .2s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,.14);
            color: var(--white);
            transform: translateX(2px);
        }

        .logout-link {
            color: rgba(255,226,226,.9) !important;
        }

        .main-content {
            min-height: 100vh;
            margin-left: 270px;
            padding: clamp(22px, 4vw, 36px);
        }

        h1, h2, h3, h4, h5 {
            color: var(--ink) !important;
            font-family: var(--serif);
            font-weight: 400 !important;
        }

        .card,
        .modal-content,
        .alert {
            border-radius: var(--radius-lg) !important;
            border: 1px solid var(--line) !important;
            box-shadow: 0 16px 42px rgba(13,100,114,.08) !important;
        }

        .card {
            background: rgba(255,255,255,.72);
            overflow: hidden;
        }

        .card-footer,
        .modal-header,
        .modal-footer,
        .bg-white,
        .bg-light {
            background-color: rgba(255,255,255,.76) !important;
        }

        .stat-card {
            border-radius: var(--radius-lg) !important;
        }

        .btn {
            border-radius: var(--radius-pill) !important;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .08em;
            padding: 10px 18px;
            text-transform: uppercase;
        }

        .btn-primary,
        .btn-success,
        .btn:not(.btn-outline-primary):not(.btn-outline-secondary):not(.btn-outline-danger):not(.btn-danger):not(.btn-light) {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: var(--ink-deep) !important;
        }

        .btn-primary:hover,
        .btn-success:hover {
            background: var(--accent-soft) !important;
            border-color: var(--accent-soft) !important;
        }

        .btn-outline-primary {
            border-color: var(--line-strong) !important;
            color: var(--ink) !important;
        }

        .btn-outline-primary:hover {
            background: var(--ink) !important;
            color: var(--white) !important;
        }

        .form-control,
        .form-select {
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            color: var(--ink-deep);
            min-height: 44px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--ink);
            box-shadow: 0 0 0 .16rem rgba(19,120,135,.12);
        }

        .form-label {
            color: var(--ink);
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .table {
            color: var(--ink-deep);
            margin-bottom: 0;
        }

        .table thead th {
            background: #eef7f8 !important;
            border-bottom: 0;
            color: var(--muted) !important;
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .table td,
        .table th {
            border-color: var(--line);
            vertical-align: middle;
        }

        .badge {
            border-radius: var(--radius-pill) !important;
            padding: 7px 10px;
        }

        .bg-primary,
        .badge[style*="#00A99D"],
        .badge[style*="#007A75"] {
            background-color: var(--ink) !important;
        }

        .text-primary,
        .text-success {
            color: var(--ink) !important;
        }

        .text-warning {
            color: var(--accent) !important;
        }

        .table-responsive {
            border-radius: var(--radius-md);
        }

        .admin-page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: sticky;
                top: 0;
                width: 100%;
                height: auto;
                max-height: none;
                padding: 14px 12px;
            }

            .sidebar-brand {
                margin: 0 8px 12px;
                font-size: 24px;
            }

            .sidebar nav {
                display: flex !important;
                flex-direction: row !important;
                gap: 8px;
                overflow-x: auto;
                padding-bottom: 4px;
            }

            .sidebar .nav-link {
                flex: 0 0 auto;
                white-space: nowrap;
                margin-bottom: 0;
            }

            .sidebar hr,
            .sidebar form {
                flex: 0 0 auto;
                margin: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 18px 14px 28px;
            }
        }

        @media (max-width: 575.98px) {
            .admin-page-head,
            .d-flex.justify-content-between.align-items-center.mb-4 {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 12px;
            }

            .admin-page-head .btn,
            .d-flex.justify-content-between.align-items-center.mb-4 .btn,
            .d-flex.justify-content-between.align-items-center.mb-4 button {
                width: 100%;
            }

            .card.p-4,
            .card-body.p-4 {
                padding: 16px !important;
            }

            .table {
                min-width: 720px;
                font-size: 13px;
            }

            h3 {
                font-size: 28px;
            }

            .btn {
                min-height: 40px;
                padding: 9px 14px;
            }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">Sejenak <span>Admin</span></a>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a>
            <a class="nav-link {{ request()->routeIs('admin.reservations*') ? 'active' : '' }}" href="{{ route('admin.reservations') }}"><i class="fas fa-calendar-check"></i> Reservasi</a>
            <a class="nav-link {{ request()->routeIs('admin.packages*') ? 'active' : '' }}" href="{{ route('admin.packages') }}"><i class="fas fa-boxes"></i> Paket Layanan</a>
            <a class="nav-link {{ request()->routeIs('admin.galleries*') ? 'active' : '' }}" href="{{ route('admin.galleries') }}"><i class="fas fa-images"></i> Galeri Foto</a>
            <a class="nav-link {{ request()->routeIs('admin.faqs*') ? 'active' : '' }}" href="{{ route('admin.faqs') }}"><i class="fas fa-question-circle"></i> FAQ & Bot</a>
            <hr class="border-light opacity-50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link logout-link bg-transparent border-0 text-start w-100"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </nav>
    </aside>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

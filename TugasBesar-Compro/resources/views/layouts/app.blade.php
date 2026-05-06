<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejenak Studio - Self Photo Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400;1,500&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --line: rgba(19, 120, 135, .18);
            --line-strong: rgba(19, 120, 135, .34);
            --photo: #e7d6b5;
            --photo-dark: #137887;
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --radius-pill: 999px;
            --serif: "Playfair Display", serif;
            --sans: "Manrope", sans-serif;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; overflow-x: hidden; }
        body {
            background: var(--paper);
            color: var(--ink);
            font-family: var(--sans);
            font-weight: 300;
            overflow-x: hidden;
        }
        ::-webkit-scrollbar { width: 2px; }
        ::-webkit-scrollbar-thumb { background: var(--accent); }

        a { color: inherit; }
        main { min-height: 70vh; }
        .container {
            width: min(100% - 32px, 1140px);
            max-width: 1140px;
        }

        .navbar {
            background: rgba(255, 250, 240, .96);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(16px);
            padding: 18px 0;
            box-shadow: none;
            transition: padding .32s ease, background .32s ease, box-shadow .32s ease;
        }
        .navbar.navbar-scrolled {
            background: rgba(255, 250, 240, .98);
            padding: 11px 0;
            box-shadow: 0 10px 32px rgba(13, 100, 114, .12);
        }
        .navbar-brand {
            color: var(--ink) !important;
            font-family: var(--serif);
            font-size: 23px;
            font-style: italic;
            font-weight: 400;
            letter-spacing: .04em;
            text-transform: none;
            transition: font-size .32s ease;
        }
        .navbar.navbar-scrolled .navbar-brand { font-size: 21px; }
        .navbar-brand span { color: var(--ink) !important; }
        .navbar-toggler {
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            padding: 8px 10px;
        }
        .nav-link {
            color: var(--muted) !important;
            font-size: 12px;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 500;
            padding-left: 18px !important;
            padding-right: 18px !important;
            position: relative;
            transition: color .24s ease;
        }
        .nav-link::after {
            position: absolute;
            left: 18px;
            right: 18px;
            bottom: 2px;
            height: 1px;
            background: var(--accent);
            content: "";
            opacity: 0;
            transform: scaleX(.35);
            transform-origin: center;
            transition: opacity .24s ease, transform .24s ease;
        }
        .nav-link:hover,
        .nav-link.active,
        .nav-link.is-current { color: var(--ink) !important; }
        .nav-link:hover::after,
        .nav-link.active::after,
        .nav-link.is-current::after {
            opacity: 1;
            transform: scaleX(1);
        }

        .btn,
        .form-control,
        .form-select,
        .card,
        .alert,
        .badge { border-radius: var(--radius-md) !important; }
        .btn {
            border-width: 1px;
            border-radius: var(--radius-pill) !important;
            font-family: var(--sans);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            padding: 13px 28px;
            transition: background .24s ease, border-color .24s ease, color .24s ease, transform .24s ease;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-sm { padding: 9px 18px; font-size: 10px; }
        .btn-lg { padding: 16px 36px; font-size: 12px; }
        .btn-primary,
        .btn-dark {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: var(--ink-deep) !important;
        }
        .btn-primary:hover,
        .btn-dark:hover {
            background: var(--accent-soft) !important;
            border-color: var(--accent-soft) !important;
            color: var(--ink-deep) !important;
        }
        .btn-outline-primary,
        .btn-outline-dark {
            background: transparent !important;
            border-color: var(--line-strong) !important;
            color: var(--ink) !important;
        }
        .btn-outline-primary:hover,
        .btn-outline-dark:hover {
            background: var(--ink) !important;
            border-color: var(--ink) !important;
            color: var(--white) !important;
        }
        .btn-success {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: var(--ink-deep) !important;
        }
        .text-primary,
        .text-success { color: var(--ink) !important; }
        .text-warning { color: var(--accent) !important; }
        .bg-primary,
        .bg-light { background: var(--ink) !important; }
        .text-muted { color: var(--muted) !important; }

        h1, h2, h3, h4, h5 {
            color: var(--ink);
            font-family: var(--serif);
            font-weight: 400 !important;
            letter-spacing: 0;
        }
        p { line-height: 1.85; }

        .section-pad { padding: clamp(56px, 8vw, 90px) 0; }
        .section-border { border-top: 1px solid var(--line); }
        .eyebrow {
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: .22em;
            margin-bottom: 18px;
            text-transform: uppercase;
        }
        .page-header {
            background:
                radial-gradient(circle at 18% 100%, rgba(247, 169, 0, .95) 0 18%, transparent 18.5%),
                radial-gradient(circle at 88% 18%, rgba(247, 169, 0, .8) 0 12%, transparent 12.5%),
                var(--ink);
            border-bottom: 1px solid var(--line);
            border-radius: 0 0 34px 34px;
            padding: clamp(62px, 8vw, 82px) 0 clamp(46px, 7vw, 62px);
            text-align: center;
        }
        .page-header .eyebrow { color: rgba(255, 255, 255, .74); }
        .page-header h1 { color: var(--white); }
        .page-header h1 {
            font-size: clamp(46px, 7vw, 88px);
            line-height: .96;
            margin-bottom: 18px;
        }
        .page-header p {
            color: rgba(255, 255, 255, .82);
            margin: 0 auto;
            max-width: 620px;
        }
        .card {
            background: rgba(255, 255, 255, .46);
            border: 1px solid var(--line) !important;
            box-shadow: none !important;
            transition: transform .28s ease, border-color .28s ease, background .28s ease;
            overflow: hidden;
        }
        .card.p-4,
        .card.p-md-5 {
            padding: clamp(20px, 4vw, 48px) !important;
        }
        .card:hover {
            border-color: var(--line-strong) !important;
            background: rgba(255, 255, 255, .62);
            transform: translateY(-3px);
        }
        iframe,
        img {
            max-width: 100%;
        }
        iframe {
            min-height: 320px;
        }
        .form-control,
        .form-select {
            background-color: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--radius-sm) !important;
            color: var(--ink);
            padding: 13px 14px;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--ink);
            box-shadow: 0 0 0 .16rem rgba(19, 120, 135, .12);
        }
        .form-label {
            color: var(--ink);
            font-size: 11px;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .accordion {
            --bs-accordion-bg: transparent;
            --bs-accordion-border-color: var(--line);
            --bs-accordion-border-radius: var(--radius-md);
            --bs-accordion-inner-border-radius: var(--radius-md);
            --bs-accordion-btn-focus-box-shadow: 0 0 0 .16rem rgba(19, 120, 135, .12);
            --bs-accordion-active-bg: transparent;
            --bs-accordion-active-color: var(--ink);
        }
        .accordion-item {
            background: transparent;
            border-color: var(--line) !important;
            border-left: 0;
            border-right: 0;
        }
        .accordion-button {
            background: transparent;
            color: var(--ink);
            font-family: var(--serif);
            font-size: 24px;
            font-weight: 400 !important;
            padding: 22px 0;
            box-shadow: none !important;
        }
        .accordion-button:not(.collapsed) { background: transparent; }
        .accordion-button::after { filter: grayscale(1); }
        .accordion-body {
            color: var(--muted);
            line-height: 1.85;
            padding: 0 0 24px;
        }

        footer {
            background: var(--ink);
            color: var(--white);
            padding: 58px 0 34px;
        }
        footer h5 {
            color: var(--white);
            font-family: var(--sans);
            font-size: 12px;
            font-weight: 600 !important;
            letter-spacing: .16em;
            text-transform: uppercase;
        }
        footer p,
        footer a,
        footer .text-muted {
            color: rgba(255, 255, 255, .72) !important;
        }
        footer a:hover { color: var(--accent-soft) !important; }

        #chatbot-bubble {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            background: var(--accent);
            border: 1px solid var(--line-strong);
            border-radius: var(--radius-pill);
            color: var(--ink-deep);
            text-decoration: none;
            transition: transform .2s, background .2s;
        }
        #chatbot-bubble:hover {
            background: var(--accent-soft);
            color: var(--ink-deep);
            transform: translateY(-3px);
        }
        #chatbot-bubble .chat-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            background: var(--ink);
            border: 1px solid var(--white);
            border-radius: var(--radius-pill);
            color: var(--white);
            font-size: 10px;
            font-weight: 700;
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .72s ease, transform .72s ease;
            transition-delay: var(--reveal-delay, 0ms);
            will-change: opacity, transform;
        }
        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }
        .reveal-fade {
            opacity: 0;
            transition: opacity .85s ease;
            transition-delay: var(--reveal-delay, 0ms);
        }
        .reveal-fade.is-visible { opacity: 1; }
        .page-header .eyebrow,
        .page-header h1,
        .page-header p {
            animation: pageIntro .72s ease both;
        }
        .page-header h1 { animation-delay: .08s; }
        .page-header p { animation-delay: .16s; }

        @keyframes pageIntro {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
            .reveal-on-scroll,
            .reveal-fade {
                opacity: 1;
                transform: none;
            }
        }

        @media (max-width: 991.98px) {
            :root {
                --radius-lg: 20px;
            }

            .navbar-collapse {
                border-top: 1px solid var(--line);
                margin-top: 16px;
                padding-top: 14px;
            }
            .nav-link { padding: 12px 0 !important; }
            .nav-link::after { left: 0; right: 0; bottom: 6px; }
            .navbar .btn { width: 100%; margin-top: 10px; }
            .page-header {
                border-radius: 0 0 24px 24px;
            }
            .page-header h1 {
                font-size: clamp(42px, 10vw, 68px);
            }
            footer {
                padding: 46px 0 28px;
            }
        }

        @media (max-width: 575.98px) {
            :root {
                --radius-sm: 9px;
                --radius-md: 13px;
                --radius-lg: 18px;
            }

            .container {
                width: min(100% - 24px, 1140px);
            }
            .section-pad {
                padding: 44px 0;
            }
            .navbar {
                padding: 12px 0;
            }
            .navbar-brand,
            .navbar.navbar-scrolled .navbar-brand {
                font-size: 20px;
            }
            .btn {
                width: 100%;
                min-height: 44px;
                padding: 12px 18px;
                white-space: normal;
            }
            .btn-sm {
                width: auto;
                min-height: 38px;
            }
            .page-header {
                border-radius: 0 0 20px 20px;
                padding: 42px 0 34px;
                text-align: left;
            }
            .page-header h1 {
                font-size: clamp(34px, 12vw, 48px);
                margin-bottom: 12px;
            }
            .page-header p {
                margin-left: 0;
                font-size: 13px;
                line-height: 1.65;
            }
            h2.display-5,
            .display-5 {
                font-size: clamp(30px, 9vw, 42px);
            }
            .eyebrow {
                font-size: 10px;
                margin-bottom: 12px;
            }
            p {
                line-height: 1.65;
            }
            #chatbot-bubble {
                right: 16px;
                bottom: 16px;
                width: 52px;
                height: 52px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">Sejenak <span>Studio</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'is-current' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('profil') ? 'is-current' : '' }}" href="{{ route('profil') }}">Profil</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('paket') ? 'is-current' : '' }}" href="{{ route('paket') }}">Paket</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('galeri') ? 'is-current' : '' }}" href="{{ route('galeri') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('informasi') ? 'is-current' : '' }}" href="{{ route('informasi') }}">Informasi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('kontak') ? 'is-current' : '' }}" href="{{ route('kontak') }}">Kontak</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('chatbot.index') ? 'is-current' : '' }}" href="{{ route('chatbot.index') }}">Chatbot</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary px-4 {{ request()->routeIs('reservasi.*') ? 'active' : '' }}" href="{{ route('reservasi.index') }}">Reservasi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Sejenak Studio</h5>
                    <p class="small mb-0">Self photo studio di Purwokerto untuk menyimpan momen dengan tenang, rapi, dan personal.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Link Cepat</h5>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('paket') }}" class="text-decoration-none">Paket Layanan</a></li>
                        <li><a href="{{ route('galeri') }}" class="text-decoration-none">Galeri Foto</a></li>
                        <li><a href="{{ route('reservasi.index') }}" class="text-decoration-none">Buat Janji</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Ikuti Kami</h5>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="https://instagram.com/sejenakselfphoto" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 border-secondary">
            <p class="small mb-0">&copy; 2024 Sejenak Studio Purwokerto. All rights reserved.</p>
        </div>
    </footer>

    <a href="{{ route('chatbot.index') }}" id="chatbot-bubble" title="Tanya Sejenak Bot">
        <i class="fas fa-comments"></i>
        <span class="chat-badge">!</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            const navCollapse = document.getElementById('navbarNav');
            const revealTargets = document.querySelectorAll([
                'main > section',
                '.section-heading',
                '.card',
                '.package-card',
                '.price-card',
                '.gallery-item',
                '.quote-box',
                '.background-tile',
                '.border-top',
                'footer .col-md-4'
            ].join(','));

            function setNavbarState() {
                navbar.classList.toggle('navbar-scrolled', window.scrollY > 24);
            }

            setNavbarState();
            window.addEventListener('scroll', setNavbarState, { passive: true });

            document.querySelectorAll('a[href^="#"]').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    const target = document.querySelector(link.getAttribute('href'));
                    if (!target) return;

                    event.preventDefault();
                    const offset = navbar.offsetHeight + 18;
                    const top = target.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top: top, behavior: 'smooth' });
                });
            });

            document.querySelectorAll('.navbar-nav .nav-link, .navbar-nav .btn').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (!navCollapse || !navCollapse.classList.contains('show')) return;
                    bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
                });
            });

            revealTargets.forEach(function(element, index) {
                element.classList.add('reveal-on-scroll');
                element.style.setProperty('--reveal-delay', Math.min(index % 6, 5) * 55 + 'ms');
            });

            if (!('IntersectionObserver' in window)) {
                revealTargets.forEach(function(element) {
                    element.classList.add('is-visible');
                });
                return;
            }

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            }, {
                threshold: .12,
                rootMargin: '0px 0px -70px 0px'
            });

            revealTargets.forEach(function(element) {
                observer.observe(element);
            });
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejenak Studio - Self Photo Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;1,400;1,500&family=Manrope:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
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

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        body {
            background: var(--paper);
            color: var(--ink);
            font-family: var(--sans);
            font-weight: 300;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            width: 2px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
        }

        a {
            color: inherit;
        }

        main {
            min-height: 70vh;
        }

        .container {
            width: min(100% - 32px, 1140px);
            max-width: 1140px;
        }

        /* === NAVBAR === */
        .navbar {
            background: rgba(255, 250, 240, .97);
            border-bottom: none;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: 0;
            box-shadow: none;
            transition: box-shadow .36s ease;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
        }

        /* Garis bawah navbar — tipis, halus, tidak mengganggu */
        .navbar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--line);
            opacity: 1;
        }

        .navbar.navbar-scrolled::after { opacity: 0; } /* hilang saat ada shadow */

        .navbar.navbar-scrolled {
            box-shadow: 0 4px 28px rgba(19, 120, 135, .12);
        }

        /* Kompensasi tinggi navbar */
        body { padding-top: 72px; }

        /* Navbar-inner: container di dalam navbar */
        .navbar-inner {
            display: flex;
            align-items: center;
            width: 100%;
            height: 68px;
            transition: height .3s ease;
        }

        .navbar.navbar-scrolled .navbar-inner { height: 60px; }

        /* Desktop: collapse berperilaku seperti flex row */
        @media (min-width: 992px) {
            .navbar-collapse {
                display: flex !important;
                align-items: center;
                flex: 1;
            }

            /* Nav tengah: ambil sisa ruang, justify ke tengah */
            #nav-center-links {
                flex: 1;
                justify-content: center;
                flex-direction: row;
            }

            /* Nav kanan: dorong ke kanan */
            #nav-right-links {
                flex-direction: row;
                flex-shrink: 0;
            }
        }

        .navbar.reveal-on-scroll,
        .navbar.reveal-fade {
            opacity: 1 !important;
            transform: none !important;
        }

        /* === SCROLL PROGRESS BAR === */
        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            width: 0%;
            background: var(--accent);
            z-index: 2000;
            transition: width .1s linear;
            border-radius: 0 3px 3px 0;
        }

        /* === HAMBURGER ANIMATION === */
        .navbar-toggler {
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            padding: 8px 10px;
            position: relative;
            width: 40px;
            height: 38px;
        }
        .navbar-toggler .ham-bar {
            display: block;
            width: 20px;
            height: 2px;
            background: var(--ink);
            margin: 4px auto;
            transition: transform .3s ease, opacity .3s ease;
            border-radius: 2px;
        }
        .navbar-toggler.is-open .ham-bar:nth-child(1) { transform: translateY(6px) rotate(45deg); }
        .navbar-toggler.is-open .ham-bar:nth-child(2) { opacity: 0; }
        .navbar-toggler.is-open .ham-bar:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }

        /* === MOBILE BACKDROP === */
        #nav-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13, 100, 114, .28);
            backdrop-filter: blur(4px);
            z-index: 1040;
        }
        #nav-backdrop.active { display: block; }

        /* === FLASH TOAST === */
        #toast-container {
            position: fixed;
            top: 72px;
            right: 20px;
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }
        .alert-toast {
            pointer-events: all;
            min-width: 280px;
            max-width: 380px;
            padding: 14px 18px;
            border-radius: var(--radius-md);
            font-family: var(--sans);
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            box-shadow: 0 8px 32px rgba(0,0,0,.14);
            animation: toastIn .35s ease forwards;
        }
        .alert-toast.hide {
            animation: toastOut .35s ease forwards;
        }
        .alert-toast--success { background: #137887; color: #fff; }
        .alert-toast--error   { background: #c0392b; color: #fff; }
        .alert-toast--warning { background: var(--accent); color: #0d6472; }
        .alert-toast--info    { background: #0d6472; color: #fff; }
        .alert-toast .toast-icon { font-size: 16px; flex-shrink: 0; margin-top: 1px; }
        .alert-toast .toast-close { margin-left: auto; cursor: pointer; opacity: .7; flex-shrink: 0; background: none; border: none; color: inherit; font-size: 16px; padding: 0; line-height: 1; }
        .alert-toast .toast-close:hover { opacity: 1; }
        @keyframes toastIn  { from { opacity: 0; transform: translateX(40px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes toastOut { from { opacity: 1; transform: translateX(0); } to { opacity: 0; transform: translateX(40px); } }

        /* === FORM FOCUS GLOW === */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--ink) !important;
            box-shadow: 0 0 0 3px rgba(19, 120, 135, .18) !important;
        }

        /* ── Brand: horizontal, clean, tidak norak ──────── */
        .navbar-brand {
            color: var(--ink) !important;
            text-decoration: none;
            display: flex;
            flex-direction: row;   /* sejajar */
            align-items: baseline;
            gap: 7px;
            flex-shrink: 0;
            line-height: 1;
            transition: opacity .24s ease;
        }

        /* Nama utama: cukup besar, italic, serif */
        .navbar-brand .brand-name {
            font-family: var(--serif);
            font-size: 22px;
            font-style: italic;
            font-weight: 400;
            letter-spacing: -.01em;
            color: var(--ink);
            line-height: 1;
        }

        /* Subtitle: kecil tracked, muted, sejajar di baseline */
        .navbar-brand .brand-sub {
            font-family: var(--sans);
            font-style: normal;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: .28em;
            text-transform: uppercase;
            color: var(--muted);
            padding-bottom: 2px; /* optical align ke baseline */
        }

        .navbar-brand:hover { opacity: .7; }
        .navbar.navbar-scrolled .navbar-brand .brand-name { font-size: 20px; }

        .navbar-toggler {
            border: 1px solid var(--line);
            border-radius: var(--radius-sm);
            padding: 8px 10px;
        }

        .nav-link {
            color: var(--muted) !important;
            font-size: 11px;
            letter-spacing: .1em;
            text-transform: uppercase;
            font-weight: 600;
            padding: 8px 13px !important;
            position: relative;
            transition: color .22s ease;
        }

        /* Garis bawah hangat saat hover/active */
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 13px;
            right: 13px;
            height: 1.5px;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--accent), var(--ink));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .26s ease;
        }

        .nav-link:hover { color: var(--ink) !important; }

        .nav-link.active,
        .nav-link.is-current { color: var(--ink) !important; }

        .nav-link:hover::after,
        .nav-link.active::after,
        .nav-link.is-current::after { transform: scaleX(1); }

        /* Separator dekoratif */
        .nav-sep {
            width: 1px;
            height: 16px;
            background: var(--line-strong);
            opacity: .45;
            margin: 0 8px;
            flex-shrink: 0;
        }

        /* Auth chip */
        .nav-user-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 14px 5px 5px;
            background: rgba(19, 120, 135, .08);
            border: 1px solid var(--line);
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: .03em;
        }

        .nav-user-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--ink);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .nav-logout-btn {
            background: transparent;
            border: 1px solid rgba(192,57,43,.35);
            border-radius: var(--radius-pill);
            color: #c0392b;
            font-family: var(--sans);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 6px 14px;
            cursor: pointer;
            transition: background .2s, border-color .2s;
        }

        .nav-logout-btn:hover {
            background: rgba(192,57,43,.08);
            border-color: rgba(192,57,43,.6);
        }

        .btn,
        .form-control,
        .form-select,
        .card,
        .alert,
        .badge {
            border-radius: var(--radius-md) !important;
        }

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

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-sm {
            padding: 9px 18px;
            font-size: 10px;
        }

        .btn-lg {
            padding: 16px 36px;
            font-size: 12px;
        }

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
        .text-success {
            color: var(--ink) !important;
        }

        .text-warning {
            color: var(--accent) !important;
        }

        .bg-primary,
        .bg-light {
            background: var(--ink) !important;
        }

        .text-muted {
            color: var(--muted) !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            color: var(--ink);
            font-family: var(--serif);
            font-weight: 400 !important;
            letter-spacing: 0;
        }

        p {
            line-height: 1.85;
        }

        .section-pad {
            padding: clamp(56px, 8vw, 90px) 0;
        }

        .section-border {
            border-top: 1px solid var(--line);
        }

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

        .page-header .eyebrow {
            color: rgba(255, 255, 255, .74);
        }

        .page-header h1 {
            color: var(--white);
        }

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

        .accordion-button:not(.collapsed) {
            background: transparent;
        }

        .accordion-button::after {
            filter: grayscale(1);
        }

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

        footer a:hover {
            color: var(--accent-soft) !important;
        }

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

        .reveal-fade.is-visible {
            opacity: 1;
        }

        .page-header .eyebrow,
        .page-header h1,
        .page-header p {
            animation: pageIntro .72s ease both;
        }

        .page-header h1 {
            animation-delay: .08s;
        }

        .page-header p {
            animation-delay: .16s;
        }

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
            html {
                scroll-behavior: auto;
            }

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

        /* === PREMIUM FOOTER === */
        footer {
            background: linear-gradient(160deg, #0d5f6e 0%, #0a4a57 60%, #083d48 100%);
            color: rgba(255, 250, 240, .85);
            padding: 60px 0 32px;
        }
        .footer-brand {
            font-family: var(--serif);
            font-size: 24px;
            color: var(--paper);
            letter-spacing: -.01em;
        }
        .footer-brand span { color: var(--accent); }
        .footer-heading {
            font-family: var(--sans);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 16px;
        }
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li { margin-bottom: 10px; }
        .footer-links a, .footer-links span {
            color: rgba(255, 250, 240, .65);
            text-decoration: none;
            font-size: 13px;
            font-family: var(--sans);
            transition: color .2s;
        }
        .footer-links a:hover { color: var(--accent); }
        .footer-social {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 250, 240, .1);
            color: rgba(255, 250, 240, .8);
            font-size: 15px;
            text-decoration: none;
            transition: background .2s, color .2s, transform .2s;
        }
        .footer-social:hover {
            background: var(--accent);
            color: var(--ink-deep);
            transform: translateY(-3px);
        }

        @media (max-width: 991.98px) {
            :root { --radius-lg: 20px; }
            .navbar-inner {
                padding: 0 16px;
                flex-wrap: wrap;
            }

            /* Mobile collapse: full-width, rapi */
            .navbar-collapse {
                width: 100%;
                flex-basis: 100%;
                border-top: 1px solid var(--line);
                margin-top: 0;
                padding: 8px 0 16px;
                background: rgba(255,250,240,.99);
                border-radius: 0 0 var(--radius-lg) var(--radius-lg);
                box-shadow: 0 12px 32px rgba(19,120,135,.1);
            }

            /* Di mobile: kedua ul stack vertikal */
            .navbar-collapse .navbar-nav {
                width: 100%;
                flex-direction: column;
                position: static !important;
                transform: none !important;
                top: auto !important;
                left: auto !important;
            }

            /* Nav links di mobile */
            .nav-link {
                padding: 11px 16px !important;
                border-radius: var(--radius-sm);
                font-size: 12px;
                border-bottom: 1px solid rgba(19,120,135,.07);
            }

            /* Hapus garis bawah animasi di mobile */
            .nav-link::after { display: none; }

            /* CTA & auth: full width, margin top */
            .navbar-collapse .navbar-nav:last-child {
                margin-top: 8px;
                padding-top: 8px;
                border-top: 1px solid var(--line);
            }
            .navbar .btn { width: 100%; margin-top: 4px; }
            .page-header { border-radius: 0 0 24px 24px; }
            .page-header h1 { font-size: clamp(42px, 10vw, 68px); }
            footer { padding: 40px 0 24px; }
        }


        /* ─── BRAND: font fix di mobile ──────────────────────── */
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

            /* Brand tetap kecil & rapi di mobile */
            .navbar-brand .brand-name { font-size: 18px; }
            .navbar-brand .brand-sub { font-size: 7px; letter-spacing: .2em; }

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
    {{-- Scroll Progress Bar --}}
    <div id="scroll-progress"></div>

    {{-- Mobile Backdrop --}}
    <div id="nav-backdrop"></div>

    <nav class="navbar navbar-expand-lg navbar-light" id="main-navbar">
        <div class="navbar-inner container" style="position:relative;">

            {{-- Brand: kiri, stacked editorial --}}
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="brand-name">sejenak</span>
                <span class="brand-sub">studio</span>
            </a>

            {{-- Hamburger --}}
            <button class="navbar-toggler ms-auto" id="nav-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-label="Toggle navigation" aria-expanded="false">
                <span class="ham-bar"></span>
                <span class="ham-bar"></span>
                <span class="ham-bar"></span>
            </button>

            {{-- Nav: wrapper flex seluruhnya --}}
            <div class="collapse navbar-collapse" id="navbarNav">

                {{-- Link utama: TENGAH di desktop, stack di mobile --}}
                <ul class="navbar-nav" id="nav-center-links">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home')      ? 'is-current' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('profil')    ? 'is-current' : '' }}" href="{{ route('profil') }}">Profil</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('paket')     ? 'is-current' : '' }}" href="{{ route('paket') }}">Paket</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('galeri')    ? 'is-current' : '' }}" href="{{ route('galeri') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('informasi') ? 'is-current' : '' }}" href="{{ route('informasi') }}">Informasi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('chatbot.*') ? 'is-current' : '' }}" href="{{ route('chatbot.index') }}">Chatbot</a></li>
                </ul>

                {{-- Auth + CTA: kanan di desktop, bawah di mobile --}}
                <ul class="navbar-nav align-items-lg-center ms-lg-auto" id="nav-right-links">
                    {{-- CTA --}}
                    <li class="nav-item">
                        <a class="btn btn-primary {{ request()->routeIs('reservasi.*') ? 'active' : '' }}"
                           style="padding:9px 22px;"
                           href="{{ route('reservasi.index') }}">Reservasi</a>
                    </li>

                    @auth
                        <li class="nav-item ms-lg-2">
                            <div class="d-flex align-items-center gap-2">
                                <span class="nav-user-chip">
                                    <span class="nav-user-avatar">{{ strtoupper(substr(Auth::user()->username, 0, 1)) }}</span>
                                    {{ Auth::user()->username }}
                                </span>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="nav-logout-btn">Logout</button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>

        </div>{{-- /.navbar-inner --}}
    </nav>

    {{-- Flash Toast Container --}}
    <div id="toast-container">
        @if(session('success'))
            <div class="alert-toast alert-toast--success" role="alert">
                <span class="toast-icon">✓</span>
                <span>{{ session('success') }}</span>
                <button class="toast-close" onclick="dismissToast(this)" aria-label="Tutup">✕</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-toast alert-toast--error" role="alert">
                <span class="toast-icon">✕</span>
                <span>{{ session('error') }}</span>
                <button class="toast-close" onclick="dismissToast(this)" aria-label="Tutup">✕</button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert-toast alert-toast--warning" role="alert">
                <span class="toast-icon">⚠</span>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                <button class="toast-close" onclick="dismissToast(this)" aria-label="Tutup">✕</button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert-toast alert-toast--info" role="alert">
                <span class="toast-icon">ℹ</span>
                <span>{{ session('info') }}</span>
                <button class="toast-close" onclick="dismissToast(this)" aria-label="Tutup">✕</button>
            </div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row g-4">
                <!-- Brand -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand mb-3">Sejenak <span>Studio</span></div>
                    <p class="small mb-3" style="color:rgba(255,250,240,.7); line-height:1.75;">
                        Self photo studio di Purwokerto — tempat menyimpan momen dengan tenang, rapi, dan personal.
                    </p>
                    <div class="d-flex gap-3 mt-3">
                        <a href="https://instagram.com/sejenakselfphoto" target="_blank" class="footer-social" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="footer-social" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/6285878059861" target="_blank" class="footer-social" title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-heading">Navigasi</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('profil') }}">Profil Studio</a></li>
                        <li><a href="{{ route('paket') }}">Paket Layanan</a></li>
                        <li><a href="{{ route('galeri') }}">Galeri Foto</a></li>
                        <li><a href="{{ route('informasi') }}">Informasi</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="footer-heading">Layanan</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('reservasi.index') }}">Buat Reservasi</a></li>
                        <li><a href="{{ route('chatbot.index') }}">Chatbot FAQ</a></li>
                        <li><a href="{{ route('login') }}">Login Akun</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-heading">Kontak & Lokasi</h6>
                    <ul class="footer-links">
                        <li style="display:flex;gap:10px;align-items:flex-start;">
                            <i class="fas fa-map-marker-alt mt-1" style="color:var(--accent);flex-shrink:0;"></i>
                            <span>Purwokerto, Jawa Tengah, Indonesia</span>
                        </li>
                        <li style="display:flex;gap:10px;align-items:center;">
                            <i class="fab fa-whatsapp" style="color:var(--accent);flex-shrink:0;"></i>
                            <a href="https://wa.me/6285878059861" target="_blank">+62 858-7805-9861</a>
                        </li>
                        <li style="display:flex;gap:10px;align-items:center;">
                            <i class="fab fa-instagram" style="color:var(--accent);flex-shrink:0;"></i>
                            <a href="https://instagram.com/sejenakselfphoto" target="_blank">@sejenakselfphoto</a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr style="border-color:rgba(255,250,240,.15); margin:32px 0 20px;">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <p class="small mb-0" style="color:rgba(255,250,240,.5);">© {{ date('Y') }} Sejenak Studio Purwokerto. All rights reserved.</p>
                <p class="small mb-0" style="color:rgba(255,250,240,.35);">Self Photo Studio · Purwokerto</p>
            </div>
        </div>
    </footer>

    <a href="{{ route('chatbot.index') }}" id="chatbot-bubble" title="Tanya Sejenak Bot">
        <i class="fas fa-comments"></i>
        <span class="chat-badge">!</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // === TOAST DISMISS ===
        function dismissToast(btn) {
            const toast = btn.closest('.alert-toast');
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 380);
        }
        // Auto-dismiss toasts after 5s
        document.querySelectorAll('.alert-toast').forEach(function(t) {
            setTimeout(() => { if (t.isConnected) dismissToast(t.querySelector('.toast-close')); }, 5000);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const navbar  = document.getElementById('main-navbar');
            const toggler = document.getElementById('nav-toggler');
            const navCollapse = document.getElementById('navbarNav');
            const backdrop    = document.getElementById('nav-backdrop');
            const progressBar = document.getElementById('scroll-progress');

            // === SCROLL PROGRESS BAR ===
            function updateProgress() {
                const docH = document.documentElement.scrollHeight - window.innerHeight;
                progressBar.style.width = (docH > 0 ? (window.scrollY / docH) * 100 : 0) + '%';
            }

            // === NAVBAR: scroll-aware shadow only (always visible) ===
            function handleNavbarScroll() {
                const cur = window.scrollY;
                navbar.classList.toggle('navbar-scrolled', cur > 40);
                updateProgress();
            }

            handleNavbarScroll();
            window.addEventListener('scroll', handleNavbarScroll, { passive: true });

            // === HAMBURGER ANIMATION ===
            toggler.addEventListener('click', function() {
                toggler.classList.toggle('is-open');
                const isOpen = toggler.classList.contains('is-open');
                backdrop.classList.toggle('active', isOpen);
            });
            backdrop.addEventListener('click', function() {
                backdrop.classList.remove('active');
                toggler.classList.remove('is-open');
                bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
            });
            navCollapse.addEventListener('hidden.bs.collapse', function() {
                toggler.classList.remove('is-open');
                backdrop.classList.remove('active');
            });

            // === SMOOTH SCROLL ===
            document.querySelectorAll('a[href^="#"]').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    const target = document.querySelector(link.getAttribute('href'));
                    if (!target) return;
                    event.preventDefault();
                    const offset = navbar.offsetHeight + 18;
                    window.scrollTo({ top: target.getBoundingClientRect().top + window.scrollY - offset, behavior: 'smooth' });
                });
            });

            // Close mobile nav on link click
            document.querySelectorAll('.navbar-nav .nav-link, .navbar-nav .btn').forEach(function(link) {
                link.addEventListener('click', function() {
                    if (!navCollapse.classList.contains('show')) return;
                    bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
                });
            });

            // === REVEAL ON SCROLL (staggered) ===
            const revealTargets = document.querySelectorAll([
                'main > section:not([data-hero-gallery])',
                '.section-heading',
                '.package-card',
                '.price-card',
                '.gallery-item',
                '.quote-box',
                '.background-tile',
                'footer .col-md-4'
            ].join(','));

            // Stagger sibling cards within same parent
            const parentMap = new Map();
            revealTargets.forEach(function(el) {
                const p = el.parentElement;
                if (!parentMap.has(p)) parentMap.set(p, []);
                parentMap.get(p).push(el);
            });
            revealTargets.forEach(function(element) {
                const siblings = parentMap.get(element.parentElement) || [];
                const idx = siblings.indexOf(element);
                element.classList.add('reveal-on-scroll');
                element.style.transitionDelay = (Math.min(idx, 5) * 80) + 'ms';
            });

            if (!('IntersectionObserver' in window)) {
                revealTargets.forEach(el => el.classList.add('is-visible'));
                return;
            }

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            }, { threshold: .1, rootMargin: '0px 0px -60px 0px' });

            revealTargets.forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>

@extends('layouts.app')

@section('content')
    @php
        $localGalleryImages = collect(['jpg', 'jpeg', 'png', 'webp'])
            ->flatMap(fn($ext) => glob(public_path("images/galleries/*.{$ext}")) ?: [])
            ->map(fn($path) => basename($path))
            ->reject(fn($file) => strtolower($file) === 'default.png')
            ->values();

        $heroSlides = $galleries
            ->filter(fn($item) => $item->image && file_exists(public_path('images/galleries/' . $item->image)))
            ->map(
                fn($item) => [
                    'url' => url('images/galleries/' . $item->image),
                    'label' => $item->category ?: 'Sejenak',
                    'title' => $item->title ?: 'Gallery Highlight',
                ],
            )
            ->values();

        if ($heroSlides->isEmpty()) {
            $heroSlides = $localGalleryImages
                ->map(
                    fn($image) => [
                        'url' => url('images/galleries/' . $image),
                        'label' => 'Sejenak',
                        'title' => 'Gallery Highlight',
                    ],
                )
                ->values();
        }

        $heroSlides = $heroSlides->take(6)->values();
    @endphp

    <style>
        .home-hero {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, .92fr) minmax(380px, 1.08fr);
            min-height: min(900px, calc(100vh - 76px));
            border-bottom: 1px solid var(--line);
            overflow: hidden;
            background:
                linear-gradient(90deg, rgba(19, 120, 135, .98) 0%, rgba(19, 120, 135, .92) 48%, rgba(247, 169, 0, .24) 100%);
        }

        .hero-bg-rotator {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .hero-bg-rotator::after {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(19, 120, 135, .96) 0%, rgba(19, 120, 135, .86) 42%, rgba(247, 169, 0, .28) 100%),
                linear-gradient(180deg, transparent 58%, var(--paper) 100%);
            content: "";
        }

        .hero-bg-slide {
            position: absolute;
            inset: -24px;
            width: calc(100% + 48px);
            height: calc(100% + 48px);
            object-fit: cover;
            opacity: .42;
            filter: blur(10px) saturate(.72) contrast(.95);
            transform: scale(1.04);
            opacity: 0;
            transition: opacity 1.1s ease, transform 5.2s ease;
        }

        .hero-bg-slide.is-active {
            opacity: .42;
            transform: scale(1);
        }

        .home-hero::after {
            position: absolute;
            inset: auto 0 0 0;
            z-index: 0;
            height: 38%;
            background: linear-gradient(180deg, transparent, var(--paper));
            content: "";
            pointer-events: none;
        }

        .home-hero-copy {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: clamp(52px, 7vw, 104px) clamp(20px, 6vw, 76px);
        }

        .hero-kicker-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 26px;
        }

        .hero-kicker-row::after {
            width: min(180px, 28vw);
            height: 1px;
            background: var(--line-strong);
            content: "";
        }

        .home-hero h1 {
            color: var(--white);
            max-width: 720px;
            font-size: clamp(54px, 8.5vw, 112px);
            line-height: .94;
            margin-bottom: 30px;
        }

        .home-hero .eyebrow {
            color: rgba(255, 255, 255, .76);
        }

        .home-hero .btn-outline-primary {
            background: rgba(255, 255, 255, .12) !important;
            border-color: rgba(255, 255, 255, .72) !important;
            color: var(--white) !important;
            backdrop-filter: blur(10px);
        }

        .home-hero .btn-outline-primary:hover {
            background: var(--white) !important;
            border-color: var(--white) !important;
            color: var(--ink-deep) !important;
        }

        .home-hero h1 em {
            font-style: italic;
        }

        .hero-copy {
            color: rgba(255, 255, 255, .82);
            max-width: 470px;
            font-size: 16px;
            margin-bottom: 40px;
        }

        /* Year pill in eyebrow */
        .hero-year-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--accent);
            color: var(--ink-deep);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .08em;
            padding: 3px 10px;
            border-radius: 999px;
            font-family: var(--sans);
            flex-shrink: 0;
        }

        /* Headline accent word */
        .hero-h1-accent {
            position: relative;
            display: inline-block;
            color: var(--accent);
        }

        .hero-h1-accent::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 4px;
            height: 3px;
            background: var(--accent);
            opacity: .35;
            border-radius: 2px;
        }

        /* Sub-tagline */
        .hero-tagline {
            color: rgba(255, 255, 255, .55);
            font-family: var(--sans);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .22em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        /* CTA row */
        .hero-cta-row {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .btn-hero {
            padding: 14px 28px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .04em;
            border-radius: 999px !important;
        }

        /* Stats row (horizontal inline) */
        .hero-stats-row {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .hero-stat {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-stat-icon {
            color: var(--accent);
            font-size: 16px;
            flex-shrink: 0;
        }

        .hero-stat strong {
            display: block;
            color: rgba(255, 255, 255, .95);
            font-family: var(--sans);
            font-size: 13px;
            font-weight: 700;
            line-height: 1.1;
        }

        .hero-stat span {
            display: block;
            color: rgba(255, 255, 255, .48);
            font-size: 10px;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .hero-stat-divider {
            width: 1px;
            height: 32px;
            background: rgba(255, 255, 255, .2);
            flex-shrink: 0;
        }

        /* === HERO SHOWCASE PANEL (kanan hero) — 2-row collage === */
        .home-hero-showcase {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            gap: clamp(6px, 1vw, 14px);
            min-height: clamp(600px, 72vw, 820px);
            padding: clamp(24px, 3vw, 44px) clamp(8px, 1.5vw, 20px) clamp(20px, 2.5vw, 36px);
        }

        /* Row wrappers */
        .hhs-row {
            display: flex;
            align-items: flex-end;
            justify-content: center;
        }
        .hhs-row--top  { gap: clamp(10px, 1.6vw, 20px); }
        .hhs-row--bottom { gap: clamp(8px, 1.2vw, 16px); }

        /* --- POLAROID SYSTEM (5 cards, 2 rows) --- */
        .hhs-polaroid {
            position: relative;
            flex-shrink: 0;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 20px 56px rgba(0,0,0,.28), 0 4px 12px rgba(0,0,0,.14);
            padding: 8px 8px 40px;
        }

        /* ---- TOP ROW ---- */
        /* Top-A: left of top row */
        .hhs-polaroid--topA {
            width: clamp(190px, 26vw, 310px);
            transform: rotate(-5deg) translateY(-18px);
            z-index: 2;
            animation: floatA 9s ease-in-out infinite;
        }
        @keyframes floatA {
            0%,100% { transform: rotate(-5deg) translateY(-18px); }
            50%      { transform: rotate(-5deg) translateY(-30px); }
        }

        /* Top-B: right of top row */
        .hhs-polaroid--topB {
            width: clamp(182px, 25vw, 298px);
            transform: rotate(4deg) translateY(-10px);
            z-index: 2;
            animation: floatB 7.5s ease-in-out infinite;
        }
        @keyframes floatB {
            0%,100% { transform: rotate(4deg) translateY(-10px); }
            50%      { transform: rotate(4deg) translateY(-22px); }
        }

        /* ---- BOTTOM ROW ---- */
        /* Left polaroid */
        .hhs-polaroid--topleft {
            width: clamp(200px, 27vw, 318px);
            transform: rotate(-6deg) translateY(-28px);
            z-index: 2;
            animation: polaroidFloat2 7s ease-in-out infinite;
        }
        @keyframes polaroidFloat2 {
            0%,100% { transform: rotate(-6deg) translateY(-28px); }
            50%      { transform: rotate(-6deg) translateY(-40px); }
        }

        /* Center / main polaroid — tallest */
        .hhs-polaroid--main {
            width: clamp(225px, 31vw, 360px);
            transform: rotate(-1.5deg) translateY(-56px);
            z-index: 3;
            animation: polaroidFloat 6s ease-in-out infinite;
        }
        @keyframes polaroidFloat {
            0%,100% { transform: rotate(-1.5deg) translateY(-56px); }
            50%      { transform: rotate(-1.5deg) translateY(-70px); }
        }

        /* Right polaroid */
        .hhs-polaroid--btmright {
            width: clamp(195px, 26vw, 308px);
            transform: rotate(5deg) translateY(-16px);
            z-index: 2;
            animation: polaroidFloat3 8s ease-in-out infinite;
        }
        @keyframes polaroidFloat3 {
            0%,100% { transform: rotate(5deg) translateY(-16px); }
            50%      { transform: rotate(5deg) translateY(-28px); }
        }

        .hhs-polaroid-img {
            position: relative;
            width: 100%;
            aspect-ratio: 3/4;
            overflow: hidden;
            border-radius: 4px;
            background: linear-gradient(135deg, #0d5f6e, #137887);
        }

        .hhs-polaroid-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: saturate(.88) contrast(.95);
        }

        .hhs-polaroid-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: rgba(255, 255, 255, .45);
        }

        .hhs-polaroid-label {
            position: absolute;
            bottom: 6px;
            left: 0;
            right: 0;
            text-align: center;
            font-family: var(--sans);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #8a8a8a;
        }

        /* Slide transitions — semua kelas slide foto */
        .hero-main-slide,
        .hero-mini-slide,
        .hero-slide3,
        .hero-slideA,
        .hero-slideB {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity .9s ease, transform 4.8s ease;
            transform: scale(1.025);
            filter: saturate(.88) contrast(.96);
        }

        .hero-main-slide.is-active,
        .hero-mini-slide.is-active,
        .hero-slide3.is-active,
        .hero-slideA.is-active,
        .hero-slideB.is-active {
            opacity: 1;
            transform: scale(1);
        }

        /* Slide dots */
        .hero-slide-dots {
            position: absolute;
            right: 8px;
            bottom: 8px;
            z-index: 2;
            display: flex;
            gap: 5px;
        }

        .hero-slide-dot {
            width: 16px;
            height: 2px;
            border: 0;
            background: rgba(255, 255, 255, .5);
            border-radius: 2px;
            padding: 0;
            cursor: pointer;
            transition: background .24s, width .24s;
        }

        .hero-slide-dot.is-active {
            width: 24px;
            background: #fff;
        }

        /* Floating badge — absolute over showcase */
        .hhs-badge {
            position: absolute;
            top: 5%;
            left: 4%;
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 250, 240, .96);
            border: 1px solid rgba(255, 250, 240, .5);
            border-radius: 999px;
            padding: 8px 14px;
            font-family: var(--sans);
            font-size: 10px;
            font-weight: 700;
            color: var(--ink);
            white-space: nowrap;
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, .15);
            animation: badgeBob 4s ease-in-out infinite;
            z-index: 10;
        }

        @keyframes badgeBob {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .hhs-badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
            flex-shrink: 0;
            animation: dotPulse 2s ease-in-out infinite;
        }

        @keyframes dotPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, .6);
            }

            50% {
                box-shadow: 0 0 0 5px rgba(34, 197, 94, 0);
            }
        }

        /* Background swatches card */
        .hhs-card {
            position: absolute;
            background: rgba(255, 250, 240, .95);
            border: 1px solid rgba(255, 250, 240, .6);
            border-radius: 14px;
            backdrop-filter: blur(14px);
            box-shadow: 0 6px 24px rgba(0, 0, 0, .16);
            z-index: 4;
        }

        .hhs-card--bg {
            bottom: 10%;
            left: 2%;
            padding: 12px 14px;
            animation: cardFloat1 5s ease-in-out infinite;
        }

        @keyframes cardFloat1 {

            0%,
            100% {
                transform: translateY(0) rotate(-1deg);
            }

            50% {
                transform: translateY(-8px) rotate(-1deg);
            }
        }

        .hhs-card-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .hhs-swatches {
            display: flex;
            gap: 5px;
        }

        .hhs-swatch {
            position: relative;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1.5px solid rgba(0, 0, 0, .1);
            cursor: default;
        }

        .hhs-swatch span {
            display: none;
            position: absolute;
            bottom: calc(100% + 4px);
            left: 50%;
            transform: translateX(-50%);
            background: #222;
            color: #fff;
            font-size: 9px;
            padding: 2px 6px;
            border-radius: 4px;
            white-space: nowrap;
        }

        .hhs-swatch:hover span {
            display: block;
        }

        /* Dot grid decoration */
        .hhs-dotgrid {
            position: absolute;
            top: 5%;
            right: 2%;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            z-index: 1;
        }

        .hhs-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: rgba(247, 169, 0, .55);
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .home-hero {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .home-hero-copy {
                border-right: 0;
                border-bottom: 1px solid rgba(255,255,255,.15);
            }

            .home-hero-showcase {
                min-height: 460px;
                gap: clamp(6px, 1.5vw, 12px);
            }

            .hhs-row--top  { gap: clamp(8px, 2vw, 14px); }
            .hhs-row--bottom { gap: clamp(8px, 2vw, 14px); }

            .hhs-polaroid--topA    { width: clamp(120px, 26vw, 190px); }
            .hhs-polaroid--topB    { width: clamp(115px, 25vw, 182px); }
            .hhs-polaroid--main    { width: clamp(140px, 34vw, 220px); }
            .hhs-polaroid--topleft { width: clamp(122px, 28vw, 196px); }
            .hhs-polaroid--btmright{ width: clamp(118px, 26vw, 190px); }

            .hero-stats-row { gap: 14px; }
        }

        @media (max-width: 575.98px) {
            .home-hero-showcase {
                min-height: 340px;
                padding: 24px 4px 18px;
                gap: 5px;
            }

            .hhs-row--top  { gap: 5px; }
            .hhs-row--bottom { gap: 5px; }

            .hhs-polaroid--topA    { width: clamp(88px,  22vw, 140px); }
            .hhs-polaroid--topB    { width: clamp(84px,  21vw, 134px); }
            .hhs-polaroid--main    { width: clamp(106px, 32vw, 180px); }
            .hhs-polaroid--topleft { width: clamp(90px,  24vw, 156px); }
            .hhs-polaroid--btmright{ width: clamp(86px,  22vw, 148px); }

            .hhs-polaroid { padding: 5px 5px 28px; border-radius: 8px; }

            .hhs-badge { font-size: 9px; padding: 6px 10px; }
            .hero-tagline { font-size: 11px; }
            .btn-hero { padding: 12px 22px; font-size: 12px; }
            .hero-stat-divider { display: none; }
            .hero-stats-row { gap: 18px; }
        }

        .section-heading {

            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 36px;
        }

        .section-heading h2 {
            font-size: clamp(38px, 5vw, 66px);
            line-height: 1;
            margin: 0;
        }

        .experience-strip {
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            background: var(--paper-soft);
        }

        .experience-item {
            height: 100%;
            padding: 34px 28px;
            border-right: 1px solid var(--line);
        }

        .experience-item:last-child {
            border-right: 0;
        }

        .experience-item h3 {
            font-size: 26px;
            margin-bottom: 12px;
        }

        .experience-item p {
            color: var(--muted);
            margin: 0;
            font-size: 14px;
        }

        .package-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 100%;
            overflow: hidden;
            background: rgba(255, 255, 255, .42);
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
        }

        .package-body {
            display: flex;
            flex: 1;
            flex-direction: column;
            padding: 26px;
        }

        .package-body .text-muted {
            margin-bottom: 22px;
        }

        .package-features {
            list-style: none;
            padding: 0;
            margin: 0 0 22px 0;
        }

        .package-features li {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .package-features li:last-child {
            margin-bottom: 0;
        }

        .package-price {
            color: var(--ink);
            font-family: var(--serif);
            font-size: 32px;
            margin-top: auto;
        }

        .package-body .btn {
            margin-top: 18px;
            align-self: stretch;
        }

        .gallery-layout {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            grid-auto-rows: auto;
            gap: 14px;
        }

        .gallery-tile {
            position: relative;
            aspect-ratio: 3 / 4;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            background: var(--photo);
        }

        .gallery-tile:first-child {
            grid-column: span 2;
            grid-row: span 2;
        }

        .gallery-tile span {
            position: absolute;
            left: 16px;
            bottom: 14px;
            color: var(--white);
            font-size: 10px;
            letter-spacing: .18em;
            text-transform: uppercase;
            text-shadow: 0 1px 14px rgba(13, 100, 114, .5);
        }

        .quote-box {
            border-top: 1px solid var(--line);
            padding-top: 26px;
        }

        .quote-box p {
            color: var(--muted);
            font-family: var(--serif);
            font-size: 22px;
            font-style: italic;
            line-height: 1.45;
        }

        .home-cta {
            border-top: 1px solid var(--line);
            background: var(--ink);
            color: var(--white);
        }

        .home-cta h2,
        .home-cta .eyebrow {
            color: rgba(255, 255, 255, .72);
        }

        .home-cta p {
            color: rgba(255, 255, 255, .72);
        }

        .home-cta .btn-outline-primary {
            border-color: rgba(255, 255, 255, .48) !important;
            color: var(--white) !important;
        }

        .home-cta .btn-outline-primary:hover {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: var(--ink) !important;
        }

        @media (max-width: 991.98px) {
            .home-hero {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .home-hero-copy {
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }

            .home-hero-media {
                min-height: auto;
                padding: clamp(18px, 5vw, 34px);
            }

            .hero-side,
            .gallery-layout {
                grid-template-columns: 1fr;
            }

            .gallery-tile:first-child {
                grid-row: span 1;
            }

            .section-heading {
                align-items: start;
                flex-direction: column;
            }

            .experience-item {
                border-right: 0;
                border-bottom: 1px solid var(--line);
            }
        }

        @media (max-width: 767.98px) {
            .section-pad {
                padding: 44px 0;
            }

            .hero-meta {
                max-width: 100%;
                margin-top: 34px;
            }

            .home-hero-media {
                grid-template-rows: auto auto;
            }

            .hero-frame {
                aspect-ratio: 4 / 5;
                min-height: 0;
            }

            .hero-side {
                gap: 12px;
            }

            .section-heading h2 {
                font-size: clamp(34px, 11vw, 50px);
            }

            .gallery-layout {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .gallery-tile {
                border-radius: var(--radius-md);
            }

            .gallery-tile:nth-child(n+5) {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .home-hero {
                min-height: auto;
            }

            .hero-meta {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                border-radius: var(--radius-md);
            }

            .home-hero h1 {
                font-size: clamp(38px, 13vw, 56px);
                margin-bottom: 20px;
            }

            .home-hero-copy {
                padding: 34px 18px 28px;
            }

            .hero-kicker-row::after {
                display: none;
            }

            .hero-kicker-row {
                margin-bottom: 16px;
            }

            .hero-copy {
                font-size: 13px;
                line-height: 1.65;
                margin-bottom: 24px;
            }

            .hero-meta {
                margin-top: 26px;
            }

            .hero-meta div {
                padding: 12px 8px;
                text-align: center;
            }

            .hero-meta strong {
                font-size: 18px;
                margin-bottom: 5px;
            }

            .hero-meta span {
                font-size: 9px;
                letter-spacing: .08em;
            }

            .home-hero-media {
                padding: 16px;
                gap: 12px;
            }

            .hero-frame {
                aspect-ratio: 16 / 10;
            }

            .hero-highlight-badge {
                top: 12px;
                left: 12px;
                padding: 7px 10px;
                font-size: 9px;
            }

            .hero-note {
                min-height: auto;
                padding: 16px;
            }

            .hero-note p {
                font-size: 18px;
            }

            .mini-frame {
                min-height: 142px;
            }

            .hero-caption {
                left: 16px;
                right: 16px;
                flex-direction: column;
                gap: 4px;
            }

            .hero-slide-dots {
                right: 16px;
                bottom: 16px;
            }

            .package-body {
                padding: 14px;
            }

            .package-card {
                border-radius: var(--radius-md);
            }

            .package-body .eyebrow {
                margin-bottom: 8px;
            }

            .package-body h3 {
                font-size: 20px;
                margin-bottom: 8px !important;
            }

            .package-body .text-muted {
                display: none;
            }

            .package-features {
                margin-bottom: 16px;
            }

            .package-features li {
                margin-bottom: 8px;
                font-size: 12px;
            }

            .package-price {
                font-size: 24px;
                margin-bottom: 10px !important;
            }

            .package-body .btn {
                min-height: 36px;
                margin-top: 8px;
                padding: 8px 14px;
                font-size: 9px;
            }

            .section-heading {
                gap: 12px;
                margin-bottom: 22px;
            }

            .section-heading h2 {
                font-size: 34px;
            }

            .experience-item {
                padding: 18px;
            }

            .experience-item h3 {
                font-size: 20px;
                margin-bottom: 6px;
            }

            .experience-item p {
                font-size: 12px;
                line-height: 1.55;
            }

            .quote-box {
                padding-top: 16px;
            }

            .quote-box p {
                font-size: 18px;
                margin-bottom: 8px;
            }

            .home-cta h2 {
                font-size: 30px;
            }

            .home-cta p {
                font-size: 13px;
                line-height: 1.65;
            }
        }

        /* === PACKAGE CARD IMPROVEMENTS (HOME) === */
        .package-card {
            position: relative;
            border-radius: var(--radius-lg);
            border: 1.5px solid var(--line);
            background: #fff;
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            height: 100%;
        }

        .package-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(19, 120, 135, .18);
            border-color: var(--ink);
        }

        .package-card--popular {
            border-color: var(--ink);
            border-width: 2px;
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--accent);
            color: #0d6472;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 999px;
            white-space: nowrap;
            font-family: var(--sans);
        }

        .package-features-home {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .package-features-home li {
            padding: 3px 0;
            font-size: 11px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .package-features-home li::before {
            content: "âœ“";
            color: var(--ink);
            font-weight: 700;
            flex-shrink: 0;
        }
    </style>

    <section class="home-hero {{ $heroSlides->isNotEmpty() ? 'has-gallery-bg' : '' }}" data-hero-gallery>
        @if ($heroSlides->isNotEmpty())
            <div class="hero-bg-rotator" aria-hidden="true">
                @foreach ($heroSlides as $slide)
                    <img src="{{ $slide['url'] }}" class="hero-bg-slide {{ $loop->first ? 'is-active' : '' }}"
                        data-hero-bg-slide alt="">
                @endforeach
            </div>
        @endif

        <div class="home-hero-copy">
            <!-- Eyebrow row with decorative pill -->
            <div class="hero-kicker-row">
                <div class="hero-year-pill">2025</div>
                <div class="eyebrow mb-0">Self Photo Studio Purwokerto</div>
            </div>

            <!-- Main headline -->
            <h1>
                Berhenti<br>
                <em>sejenak</em>,<br>
                <span class="hero-h1-accent">simpan</span><br>
                momenmu.
            </h1>

            <!-- Sub-tagline -->
            <p class="hero-tagline">Privat. Tenang. Mudah.</p>

            <p class="hero-copy">Studio foto mandiri dengan suasana yang nyaman, pilihan background rapi, dan reservasi
                online yang simpel dari awal sampai selesai.</p>

            <div class="hero-cta-row">
                <a href="{{ route('reservasi.index') }}" class="btn btn-primary btn-hero">
                    <i class="fas fa-calendar-check me-2"></i>Booking Sekarang
                </a>
                <a href="{{ route('paket') }}" class="btn btn-outline-primary btn-hero">Lihat Paket</a>
            </div>

            <!-- Stats inline -->
            <div class="hero-stats-row">
                <div class="hero-stat">
                    <i class="fas fa-clock hero-stat-icon"></i>
                    <div>
                        <strong>10.00 – 21.00</strong>
                        <span>Setiap Hari</span>
                    </div>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <i class="fas fa-image hero-stat-icon"></i>
                    <div>
                        <strong>4 Background</strong>
                        <span>Pilihan Latar</span>
                    </div>
                </div>
                <div class="hero-stat-divider"></div>
                <div class="hero-stat">
                    <i class="fas fa-user hero-stat-icon"></i>
                    <div>
                        <strong>Self Photo</strong>
                        <span>Private Room</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="home-hero-showcase">


            {{-- ROW ATAS: 2 foto medium --}}
            @if ($heroSlides->isNotEmpty())
            <div class="hhs-row hhs-row--top">

                {{-- Top-A: slide ke-4 (index +3) --}}
                <div class="hhs-polaroid hhs-polaroid--topA">
                    <div class="hhs-polaroid-img">
                        @foreach ($heroSlides as $slide)
                            <img src="{{ $heroSlides->get(($loop->index + 3) % $heroSlides->count())['url'] }}"
                                class="hero-slideA {{ $loop->first ? 'is-active' : '' }}" alt="Sesi foto"
                                style="width:100%;height:100%;object-fit:cover;filter:saturate(.88)">
                        @endforeach
                    </div>
                    <div class="hhs-polaroid-label">Gallery</div>
                </div>

                {{-- Top-B: slide ke-5 (index +4) --}}
                <div class="hhs-polaroid hhs-polaroid--topB">
                    <div class="hhs-polaroid-img">
                        @foreach ($heroSlides as $slide)
                            <img src="{{ $heroSlides->get(($loop->index + 4) % $heroSlides->count())['url'] }}"
                                class="hero-slideB {{ $loop->first ? 'is-active' : '' }}" alt="Sesi foto"
                                style="width:100%;height:100%;object-fit:cover;filter:saturate(.88)">
                        @endforeach
                    </div>
                    <div class="hhs-polaroid-label">Momen</div>
                </div>

            </div>
            @endif

            {{-- ROW BAWAH: 3 foto besar --}}
            <div class="hhs-row hhs-row--bottom">

                {{-- Polaroid kiri (slide +2) --}}
                @if ($heroSlides->count() >= 3)
                <div class="hhs-polaroid hhs-polaroid--topleft">
                    <div class="hhs-polaroid-img">
                        @foreach ($heroSlides as $slide)
                            <img src="{{ $heroSlides->get(($loop->index + 2) % $heroSlides->count())['url'] }}"
                                class="hero-slide3 {{ $loop->first ? 'is-active' : '' }}" alt="Sesi foto"
                                style="width:100%;height:100%;object-fit:cover;filter:saturate(.88)">
                        @endforeach
                    </div>
                    <div class="hhs-polaroid-label">Studio</div>
                </div>
                @endif

                {{-- Polaroid tengah utama (slide 1) --}}
                <div class="hhs-polaroid hhs-polaroid--main">
                    <div class="hhs-polaroid-img">
                        @if ($heroSlides->isNotEmpty())
                            @foreach ($heroSlides as $slide)
                                <img src="{{ $slide['url'] }}" class="hero-main-slide {{ $loop->first ? 'is-active' : '' }}"
                                    data-hero-main-slide alt="{{ $slide['title'] }}">
                            @endforeach
                            @if ($heroSlides->count() > 1)
                                <div class="hero-slide-dots">
                                    @foreach ($heroSlides as $slide)
                                        <button type="button" class="hero-slide-dot {{ $loop->first ? 'is-active' : '' }}"
                                            data-hero-dot="{{ $loop->index }}"></button>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="hhs-polaroid-placeholder">
                                <i class="fas fa-camera fa-3x"></i>
                            </div>
                        @endif
                    </div>
                    <div class="hhs-polaroid-label" data-hero-label>
                        {{ $heroSlides->first()['label'] ?? 'Sejenak Studio' }}
                    </div>
                </div>

                {{-- Polaroid kanan (slide +1) --}}
                @if ($heroSlides->count() >= 2)
                <div class="hhs-polaroid hhs-polaroid--btmright">
                    <div class="hhs-polaroid-img">
                        @foreach ($heroSlides as $slide)
                            <img src="{{ $heroSlides->get(($loop->index + 1) % $heroSlides->count())['url'] }}"
                                class="hero-mini-slide {{ $loop->first ? 'is-active' : '' }}" alt="Sesi foto"
                                style="width:100%;height:100%;object-fit:cover;filter:saturate(.88)">
                        @endforeach
                    </div>
                    <div class="hhs-polaroid-label">Highlight</div>
                </div>
                @endif

            </div>{{-- end hhs-row--bottom --}}

        </div>

    </section>


    @if ($heroSlides->count() > 1)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const hero = document.querySelector('[data-hero-gallery]');
                if (!hero) return;

                const bgSlides = Array.from(hero.querySelectorAll('[data-hero-bg-slide]'));
                const mainSlides = Array.from(hero.querySelectorAll('[data-hero-main-slide]'));
                const miniSlides = Array.from(hero.querySelectorAll('.hero-mini-slide'));
                const slide3s = Array.from(hero.querySelectorAll('.hero-slide3'));
                const slideAs = Array.from(hero.querySelectorAll('.hero-slideA'));
                const slideBs = Array.from(hero.querySelectorAll('.hero-slideB'));
                const dots = Array.from(hero.querySelectorAll('[data-hero-dot]'));
                const label = hero.querySelector('[data-hero-label]');
                const labels = @json($heroSlides->pluck('label')->values());
                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                let current = 0;
                let timer = null;

                function setActive(index) {
                    current = (index + mainSlides.length) % mainSlides.length;
                    [bgSlides, mainSlides, miniSlides, slide3s, slideAs, slideBs, dots].forEach(function(group) {
                        group.forEach(function(item, itemIndex) {
                            item.classList.toggle('is-active', itemIndex === current);
                        });
                    });
                    if (label && labels[current]) {
                        label.textContent = labels[current];
                    }
                }

                function start() {
                    if (reduceMotion || mainSlides.length < 2) return;
                    timer = window.setInterval(function() {
                        setActive(current + 1);
                    }, 4200);
                }

                function restart() {
                    if (timer) window.clearInterval(timer);
                    start();
                }

                dots.forEach(function(dot) {
                    dot.addEventListener('click', function() {
                        setActive(Number(dot.dataset.heroDot));
                        restart();
                    });
                });

                start();
            });
        </script>
    @endif

    {{-- ======== STYLE TAMBAHAN SECTIONS ======== --}}
    <style>
        /* === STEPS SECTION === */
        .steps-section {
            background: var(--ink);
            padding: 64px 0;
            overflow: hidden;
            position: relative;
        }

        .steps-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(-45deg,
                    rgba(255, 255, 255, .015) 0px,
                    rgba(255, 255, 255, .015) 1px,
                    transparent 1px,
                    transparent 28px);
        }

        .step-card {
            position: relative;
            padding: 36px 28px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, .06);
            backdrop-filter: blur(10px);
            transition: background .3s, border-color .3s, transform .3s;
            height: 100%;
        }

        .step-card:hover {
            background: rgba(255, 255, 255, .12);
            border-color: var(--accent);
            transform: translateY(-4px);
        }

        .step-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--accent);
            color: var(--ink-deep);
            font-family: var(--sans);
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .step-icon {
            font-size: 28px;
            margin-bottom: 16px;
            display: block;
        }

        .step-card h3 {
            font-family: var(--serif);
            font-size: 22px;
            font-weight: 400;
            color: #fff;
            margin-bottom: 10px;
        }

        .step-card p {
            color: rgba(255, 255, 255, .65);
            font-size: 13.5px;
            line-height: 1.7;
            margin: 0;
        }

        .step-connector {
            position: absolute;
            top: 50px;
            right: -20px;
            font-size: 20px;
            color: var(--accent);
            z-index: 2;
        }

        /* === WHY SECTION === */
        .why-section {
            padding: 80px 0;
            background: var(--paper);
        }

        .why-card {
            padding: 36px 28px;
            border-radius: var(--radius-lg);
            background: #fff;
            border: 1.5px solid var(--line);
            text-align: center;
            transition: transform .3s, box-shadow .3s, border-color .3s;
            height: 100%;
        }

        .why-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(19, 120, 135, .15);
            border-color: var(--ink);
        }

        .why-icon-wrap {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(19, 120, 135, .12), rgba(247, 169, 0, .18));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
            font-size: 26px;
            color: var(--ink);
        }

        .why-card h4 {
            font-family: var(--serif);
            font-size: 20px;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .why-card p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }

        /* === PACKAGE CARDS (ENHANCED) === */
        .pkg-section {
            padding: 80px 0;
            background: var(--paper-soft);
        }

        .package-card {
            position: relative;
            border-radius: var(--radius-lg);
            border: 1.5px solid var(--line);
            background: #fff;
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
            height: 100%;
            overflow: hidden;
        }

        .package-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(19, 120, 135, .2);
            border-color: var(--ink);
        }

        .package-body {
            display: flex;
            flex-direction: column;
            padding: 28px;
            height: 100%;
        }

        .package-price {
            color: var(--ink);
            font-family: var(--serif);
            font-size: 28px;
            font-weight: 400;
        }

        .package-features-home {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .package-features-home li {
            padding: 5px 0;
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid var(--line);
        }

        .package-features-home li:last-child {
            border-bottom: none;
        }

        .package-features-home li::before {
            content: "âœ“";
            color: var(--ink);
            font-weight: 700;
            flex-shrink: 0;
            width: 16px;
            height: 16px;
            background: rgba(19, 120, 135, .1);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 9px;
        }

        /* === GALLERY (Enhanced) === */
        .gallery-section {
            padding: 80px 0;
            background: var(--paper);
        }

        .gallery-layout {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            grid-auto-rows: auto;
            gap: 14px;
        }

        .gallery-tile {
            position: relative;
            aspect-ratio: 3 / 4;
            overflow: hidden;
            border-radius: var(--radius-lg);
            background: var(--paper-soft);
            cursor: pointer;
        }

        .gallery-tile:first-child {
            grid-column: span 2;
            grid-row: span 2;
            aspect-ratio: auto;
        }

        .gallery-tile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .6s ease, filter .6s ease;
            filter: saturate(.82) contrast(.96);
        }

        .gallery-tile:hover img {
            transform: scale(1.07);
            filter: saturate(1) contrast(1);
        }

        .gallery-tile-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(13, 100, 114, .78));
            opacity: 0;
            transition: opacity .4s;
            display: flex;
            align-items: flex-end;
            padding: 18px;
        }

        .gallery-tile:hover .gallery-tile-overlay {
            opacity: 1;
        }

        .gallery-tile-overlay span {
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .gallery-tile>span {
            position: absolute;
            left: 14px;
            bottom: 12px;
            color: rgba(255, 255, 255, .85);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
            text-shadow: 0 1px 12px rgba(0, 0, 0, .4);
            z-index: 1;
        }

        /* === TESTIMONIALS (Enhanced) === */
        .testi-section {
            padding: 80px 0;
            background: linear-gradient(135deg, rgba(19, 120, 135, .06) 0%, rgba(247, 169, 0, .06) 100%), var(--paper-soft);
        }

        .testi-card {
            background: #fff;
            border: 1.5px solid var(--line);
            border-radius: var(--radius-lg);
            padding: 28px;
            height: 100%;
            transition: transform .3s, box-shadow .3s;
        }

        .testi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 36px rgba(19, 120, 135, .12);
        }

        .testi-stars {
            color: var(--accent);
            font-size: 13px;
            margin-bottom: 14px;
            letter-spacing: 2px;
        }

        .testi-text {
            color: var(--ink);
            font-family: var(--serif);
            font-size: 17px;
            font-style: italic;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .testi-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--ink);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 15px;
            font-family: var(--sans);
            flex-shrink: 0;
        }

        .testi-name {
            font-weight: 700;
            font-size: 14px;
            color: var(--ink);
        }

        .testi-sub {
            font-size: 11px;
            color: var(--muted);
        }

        /* === CTA SECTION (Premium) === */
        .home-cta {
            position: relative;
            padding: 100px 0;
            background: var(--ink);
            overflow: hidden;
        }

        .home-cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 70% 50%, rgba(247, 169, 0, .18), transparent),
                repeating-linear-gradient(-45deg, rgba(255, 255, 255, .02) 0px, rgba(255, 255, 255, .02) 1px, transparent 1px, transparent 24px);
        }

        .home-cta-badge {
            display: inline-block;
            background: var(--accent);
            color: var(--ink-deep);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 999px;
            margin-bottom: 24px;
        }

        .home-cta h2 {
            font-size: clamp(32px, 5vw, 58px);
            color: #fff;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .home-cta p {
            color: rgba(255, 255, 255, .72);
            font-size: 16px;
            line-height: 1.7;
        }

        .home-cta .btn-primary {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: var(--ink-deep) !important;
            padding: 16px 40px;
            font-size: 13px;
        }

        .home-cta .btn-outline-light {
            border-color: rgba(255, 255, 255, .4) !important;
            color: #fff !important;
            padding: 16px 36px;
        }

        .home-cta .btn-outline-light:hover {
            background: rgba(255, 255, 255, .12) !important;
        }

        /* === RESPONSIVE OVERRIDE === */
        @media (max-width: 991.98px) {
            .steps-section {
                padding: 48px 0;
            }

            .step-connector {
                display: none;
            }

            .why-section,
            .pkg-section,
            .gallery-section,
            .testi-section {
                padding: 56px 0;
            }

            .home-cta {
                padding: 72px 0;
            }
        }

        @media (max-width: 767.98px) {
            .gallery-layout {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .gallery-tile:first-child {
                grid-column: span 2;
                grid-row: span 1;
                aspect-ratio: 16/9;
            }

            .gallery-tile:nth-child(n+5) {
                display: none;
            }

            .step-card {
                padding: 24px 20px;
            }
        }

        @media (max-width: 575.98px) {
            .gallery-tile:first-child {
                aspect-ratio: 4/3;
            }

            .home-cta {
                padding: 56px 0;
            }
        }
    </style>

    {{-- ======== SECTION 2: CARA RESERVASI ======== --}}
    <section class="steps-section">
        <div class="container">
            <div class="text-center mb-5" style="position:relative;z-index:1;">
                <div class="eyebrow" style="color:var(--accent);">Alur Reservasi</div>
                <h2 style="color:#fff; font-size:clamp(32px,5vw,52px);">Simpel dari awal<br>sampai selesai.</h2>
            </div>
            <div class="row g-4" style="position:relative;z-index:1;">
                @foreach ([
                    ['icon' => 'fa-calendar-alt',  'num' => '01', 'title' => 'Pilih Jadwal',   'desc' => 'Cek ketersediaan lewat kalender interaktif. Pilih tanggal & jam yang pas tanpa bentrok.'],
                    ['icon' => 'fa-clipboard-list', 'num' => '02', 'title' => 'Isi Formulir',   'desc' => 'Lengkapi nama, paket, background, dan jumlah orang. Hanya butuh 2 menit.'],
                    ['icon' => 'fa-comment-dots',   'num' => '03', 'title' => 'Konfirmasi WA',  'desc' => 'Kamu otomatis diarahkan ke WhatsApp admin untuk konfirmasi reservasi secara langsung.'],
                    ['icon' => 'fa-camera',         'num' => '04', 'title' => 'Datang & Foto',  'desc' => 'Tiba sesuai jadwal, nikmati sesi foto mandiri, dan terima hasil soft file setelah sesi.']
                ] as $i => $step)
                    <div class="col-sm-6 col-lg-3">
                        <div class="step-card">
                            <div class="step-num">{{ $step['num'] }}</div>
                            <div class="step-icon"><i class="fas {{ $step['icon'] }}"></i></div>
                            <h3>{{ $step['title'] }}</h3>
                            <p>{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-5" style="position:relative;z-index:1;">
                <a href="{{ route('reservasi.index') }}" class="btn btn-primary btn-lg px-5">Booking Sekarang</a>
            </div>
        </div>
    </section>

    {{-- ======== SECTION 3: MENGAPA SEJENAK? ======== --}}
    <section class="why-section">
        <div class="container">
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-7">
                    <div class="eyebrow">Keunggulan</div>
                    <h2 class="display-5">Mengapa pilih<br>Sejenak Studio?</h2>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fas fa-palette"></i></div>
                        <h4>Self Photo Room</h4>
                        <p>Ruang foto privat yang bisa kamu nikmati sendiri â€” tanpa fotografer, tanpa tekanan. Bebas
                            berekspresi senyaman mungkin.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fas fa-bolt"></i></div>
                        <h4>4 Pilihan Background</h4>
                        <p>White, Elevator, Red Box, dan Grey. Setiap background memberikan nuansa yang berbeda sesuai mood
                            kamu hari itu.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fas fa-clock"></i></div>
                        <h4>Reservasi Mudah</h4>
                        <p>Booking online 24/7 lewat website. Pilih jadwal, isi form, konfirmasi via WhatsApp. Tidak ada
                            antrian, tidak ada ribet.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fas fa-file-image"></i></div>
                        <h4>Buka Setiap Hari</h4>
                        <p>Tersedia dari pukul 10.00 hingga 21.00 setiap hari. Fleksibel untuk jadwal kamu yang padat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fas fa-users"></i></div>
                        <h4>Soft File Dikirim Langsung</h4>
                        <p>Hasil foto dikirim langsung. Simpan sebagai kenangan digital.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card">
                        <div class="why-icon-wrap">👥</div>
                        <h4>Untuk Semua Momen</h4>
                        <p>Solo, berdua, atau rombongan teman. Setiap paket dirancang untuk pengalaman foto yang berkesan
                            dan personal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======== SECTION 4: PAKET LAYANAN ======== --}}
    <section class="pkg-section">
        <div class="container">
            <div class="section-heading">
                <div>
                    <div class="eyebrow">Pricelist</div>
                    <h2>Paket Layanan</h2>
                </div>
                <a href="{{ route('paket') }}" class="btn btn-outline-primary btn-sm">Semua Paket</a>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ($packages as $package)
                    <div class="col-6 col-lg-3">
                        <article class="package-card">
                            <div class="package-body">
                                <div class="eyebrow">Paket</div>
                                <h3 class="h5 mb-2">{{ $package->name }}</h3>
                                <div class="package-price mb-4">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                                <div class="mt-auto">
                                    <a href="{{ route('paket') }}" class="btn btn-primary btn-sm w-100">Lihat Detail</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======== SECTION 5: GALERI TERBARU ======== --}}
    <section class="gallery-section">
        <div class="container">
            <div class="section-heading">
                <div>
                    <div class="eyebrow">Recent Frames</div>
                    <h2>Galeri Terbaru</h2>
                </div>
                <a href="{{ route('galeri') }}" class="btn btn-outline-primary btn-sm">Lihat Semua</a>
            </div>

            @php
                $galleryImages = $galleries
                    ->filter(fn($g) => $g->image && file_exists(public_path('images/galleries/' . $g->image)))
                    ->values();
            @endphp

            @if ($galleryImages->isNotEmpty())
                <div class="gallery-layout">
                    @foreach ($galleryImages->take(5) as $gallery)
                        <a href="{{ route('galeri') }}" class="gallery-tile">
                            <img src="{{ url('images/galleries/' . $gallery->image) }}" alt="{{ $gallery->category }}">
                            <div class="gallery-tile-overlay">
                                <span>{{ $gallery->category }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @elseif($localGalleryImages->isNotEmpty())
                <div class="gallery-layout">
                    @foreach ($localGalleryImages->take(5) as $image)
                        <a href="{{ route('galeri') }}" class="gallery-tile">
                            <img src="{{ url('images/galleries/' . $image) }}" alt="Galeri Sejenak Studio">
                            <div class="gallery-tile-overlay"><span>Sejenak</span></div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center text-muted border rounded-3 py-5">
                    <i class="fas fa-images fa-3x opacity-25 mb-3 d-block"></i>
                    Belum ada foto galeri.
                </div>
            @endif
        </div>
    </section>

    {{-- ======== SECTION 6: TESTIMONI ======== --}}
    <section class="testi-section">
        <div class="container">
            <div class="row g-5 align-items-center mb-5">
                <div class="col-lg-5">
                    <div class="eyebrow">Testimonials</div>
                    <h2 class="display-5 mb-3">Apa kata mereka<br>setelah sesi?</h2>
                    <p class="text-muted">Lebih dari ratusan pelanggan telah mempercayakan momen mereka kepada Sejenak
                        Studio di Purwokerto.</p>
                    <div class="d-flex gap-4 mt-4">
                        <div>
                            <div style="font-family:var(--serif);font-size:36px;color:var(--ink);line-height:1;">500+</div>
                            <div class="small text-muted">Sesi selesai</div>
                        </div>
                        <div>
                            <div style="font-family:var(--serif);font-size:36px;color:var(--ink);line-height:1;">4.9</div>
                            <div class="small text-muted">Rating rata-rata â­</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-4">
                        @foreach ([['q' => '"Tempatnya nyaman banget, jadi gampang dapet ekspresi yang natural dan santai."', 'name' => 'Budi Santoso', 'sub' => 'Pelanggan Solo'], ['q' => '"Reservasinya simpel, hasilnya rapi dan berkualitas. Cocok untuk foto kelulusan!"', 'name' => 'Siti Aminah', 'sub' => 'Pelanggan Duo'], ['q' => '"Ramai-ramai bareng teman tetap asyik dan tidak kaku. Rekomen banget!"', 'name' => 'Andi Wijaya', 'sub' => 'Pelanggan Grup']] as $idx => $t)
                            <div class="col-md-{{ $idx === 0 ? '12' : '6' }}">
                                <div class="testi-card">
                                    <div class="testi-stars">â˜…â˜…â˜…â˜…â˜…</div>
                                    <p class="testi-text">{{ $t['q'] }}</p>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="testi-avatar">{{ strtoupper(substr($t['name'], 0, 1)) }}</div>
                                        <div>
                                            <div class="testi-name">{{ $t['name'] }}</div>
                                            <div class="testi-sub">{{ $t['sub'] }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======== SECTION 7: CTA PREMIUM ======== --}}
    <section class="home-cta">
        <div class="container" style="position:relative;z-index:1;">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="home-cta-badge">Sejenak Studio· Purwokerto</div>
                    <h2>Siapkan satu waktu kecil untuk momen yang ingin kamu simpan.</h2>
                    <p class="mb-0">Pilih paket, background, tanggal, dan jam. Konfirmasi via WhatsApp, lalu datang dan
                        nikmati sesinya.</p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
                        <a href="{{ route('reservasi.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-calendar-plus me-2"></i>Booking Sekarang
                        </a>
                        <a href="{{ route('paket') }}" class="btn btn-outline-light btn-lg">
                            Lihat Paket
                        </a>
                    </div>
                    <div class="mt-4" style="color:rgba(255,255,255,.45); font-size:12px;">
                        <i class="fas fa-clock me-1"></i> Buka 10.00 - 21.00 WIB &nbsp;&nbsp;
                        <i class="fab fa-whatsapp me-1"></i> Konfirmasi via WhatsApp
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

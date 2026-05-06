@extends('layouts.app')

@section('content')
@php
    $localGalleryImages = collect(['jpg', 'jpeg', 'png', 'webp'])
        ->flatMap(fn ($ext) => glob(public_path("images/galleries/*.{$ext}")) ?: [])
        ->map(fn ($path) => basename($path))
        ->reject(fn ($file) => strtolower($file) === 'default.png')
        ->values();

    $localPackageImages = collect(['jpg', 'jpeg', 'png', 'webp'])
        ->flatMap(fn ($ext) => glob(public_path("images/packages/*.{$ext}")) ?: [])
        ->map(fn ($path) => basename($path))
        ->values();

    $heroSlides = $galleries
        ->filter(fn ($item) => $item->image && file_exists(public_path('images/galleries/' . $item->image)))
        ->map(fn ($item) => [
            'url' => url('images/galleries/' . $item->image),
            'label' => $item->category ?: 'Sejenak',
            'title' => $item->title ?: 'Gallery Highlight',
        ])
        ->values();

    if ($heroSlides->isEmpty()) {
        $heroSlides = $localGalleryImages
            ->map(fn ($image) => [
                'url' => url('images/galleries/' . $image),
                'label' => 'Sejenak',
                'title' => 'Gallery Highlight',
            ])
            ->values();
    }

    $heroSlides = $heroSlides->take(6)->values();
@endphp

<style>
    .home-hero {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1.02fr) minmax(340px, .98fr);
        min-height: min(860px, calc(100vh - 76px));
        border-bottom: 1px solid var(--line);
        overflow: hidden;
        background:
            linear-gradient(90deg, rgba(19,120,135,.98) 0%, rgba(19,120,135,.92) 48%, rgba(247,169,0,.24) 100%);
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
            linear-gradient(90deg, rgba(19,120,135,.96) 0%, rgba(19,120,135,.86) 42%, rgba(247,169,0,.28) 100%),
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
        border-right: 1px solid var(--line);
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
    .home-hero h1 em { font-style: italic; }
    .hero-copy {
        color: rgba(255, 255, 255, .82);
        max-width: 470px;
        font-size: 16px;
        margin-bottom: 40px;
    }
    .hero-meta {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1px;
        max-width: 560px;
        margin-top: 48px;
        background: rgba(255, 255, 255, .22);
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }
    .hero-meta div {
        background: rgba(255, 250, 240, .94);
        padding: 18px;
    }
    .hero-meta strong {
        display: block;
        color: var(--ink);
        font-family: var(--serif);
        font-size: 24px;
        font-weight: 400;
        line-height: 1;
        margin-bottom: 8px;
    }
    .hero-meta span {
        color: var(--ink-deep);
        font-size: 11px;
        letter-spacing: .12em;
        text-transform: uppercase;
    }
    .home-hero-media {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-rows: minmax(320px, 1fr) auto;
        min-height: clamp(520px, 62vw, 640px);
        padding: clamp(22px, 4vw, 52px);
        gap: 18px;
    }
    .hero-frame {
        position: relative;
        min-height: clamp(320px, 48vw, 420px);
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        background: var(--paper-soft);
    }
    .hero-main-slide,
    .hero-mini-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity .9s ease, transform 4.8s ease;
        transform: scale(1.025);
    }
    .hero-main-slide.is-active,
    .hero-mini-slide.is-active {
        opacity: 1;
        transform: scale(1);
    }
    .hero-frame img,
    .hero-mini-slide,
    .gallery-tile img,
    .package-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: saturate(.78) contrast(.95);
    }
    .hero-frame::after {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 58%, rgba(13,100,114,.42));
        content: "";
    }
    .hero-caption {
        position: absolute;
        left: 22px;
        right: 22px;
        bottom: 18px;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        gap: 18px;
        color: var(--white);
        font-size: 10px;
        letter-spacing: .18em;
        text-transform: uppercase;
    }
    .hero-highlight-badge {
        position: absolute;
        top: 18px;
        left: 18px;
        z-index: 1;
        background: rgba(255, 250, 240, .9);
        border: 1px solid rgba(255, 250, 240, .58);
        border-radius: var(--radius-pill);
        color: var(--ink);
        padding: 9px 12px;
        font-size: 10px;
        letter-spacing: .16em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }
    .hero-slide-dots {
        position: absolute;
        right: 18px;
        bottom: 18px;
        z-index: 2;
        display: flex;
        gap: 8px;
    }
    .hero-slide-dot {
        width: 22px;
        height: 1px;
        border: 0;
        background: rgba(255, 255, 255, .5);
        border-radius: var(--radius-pill);
        padding: 0;
        transition: background .24s ease, width .24s ease;
    }
    .hero-slide-dot.is-active {
        width: 36px;
        background: var(--white);
    }
    .hero-side {
        display: grid;
        grid-template-columns: .86fr 1.14fr;
        gap: 18px;
    }
    .hero-note {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: clamp(164px, 22vw, 188px);
        padding: 22px;
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        background: rgba(255, 250, 240, .9);
    }
    .hero-note p {
        color: var(--muted);
        margin: 0;
        font-family: var(--serif);
        font-size: 22px;
        font-style: italic;
        line-height: 1.35;
    }
    .mini-frame {
        position: relative;
        min-height: clamp(164px, 22vw, 188px);
        overflow: hidden;
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        background: var(--photo);
    }
    .image-fallback {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        min-height: inherit;
        background:
            linear-gradient(135deg, rgba(247,169,0,.26), transparent 42%),
            repeating-linear-gradient(90deg, rgba(19,120,135,.12) 0 1px, transparent 1px 38px),
            var(--paper-soft);
        color: rgba(19,120,135,.58);
        font-family: var(--serif);
        font-size: clamp(22px, 3vw, 34px);
        font-style: italic;
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
    .experience-item:last-child { border-right: 0; }
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
        display: grid;
        grid-template-rows: auto 1fr;
        height: 100%;
        min-height: 100%;
        overflow: hidden;
        background: transparent;
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
    }
    .package-image {
        aspect-ratio: 4 / 3;
        background: var(--photo);
    }
    .package-body {
        display: flex;
        flex-direction: column;
        padding: 26px;
    }
    .package-body .text-muted {
        margin-bottom: 22px;
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
        text-shadow: 0 1px 14px rgba(13,100,114,.5);
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
    .home-cta .eyebrow { color: rgba(255, 255, 255, .72); }
    .home-cta p { color: rgba(255,255,255,.72); }
    .home-cta .btn-outline-primary {
        border-color: rgba(255,255,255,.48) !important;
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
        .package-image {
            aspect-ratio: 1 / 1;
        }
        .package-body .eyebrow {
            margin-bottom: 8px;
        }
        .package-body h3 {
            font-size: 20px;
            margin-bottom: 8px !important;
        }
        .package-body .text-muted {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            font-size: 12px;
            line-height: 1.55;
            margin-bottom: 12px;
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
</style>

<section class="home-hero {{ $heroSlides->isNotEmpty() ? 'has-gallery-bg' : '' }}" data-hero-gallery>
    @if($heroSlides->isNotEmpty())
        <div class="hero-bg-rotator" aria-hidden="true">
            @foreach($heroSlides as $slide)
                <img src="{{ $slide['url'] }}" class="hero-bg-slide {{ $loop->first ? 'is-active' : '' }}" data-hero-bg-slide alt="">
            @endforeach
        </div>
    @endif

    <div class="home-hero-copy">
        <div class="hero-kicker-row">
            <div class="eyebrow mb-0">Self Photo Studio Purwokerto</div>
        </div>
        <h1>Berhenti <em>sejenak</em>, simpan momenmu.</h1>
        <p class="hero-copy">Studio foto mandiri dengan suasana tenang, pilihan background rapi, dan proses reservasi yang dibuat sederhana dari awal sampai selesai.</p>
        <div class="d-flex gap-3 flex-wrap">
            <a href="{{ route('reservasi.index') }}" class="btn btn-primary">Booking Sekarang</a>
            <a href="{{ route('paket') }}" class="btn btn-outline-primary">Lihat Paket</a>
        </div>
        <div class="hero-meta">
            <div><strong>10-21</strong><span>Setiap Hari</span></div>
            <div><strong>4</strong><span>Background</span></div>
            <div><strong>Self</strong><span>Photo Room</span></div>
        </div>
    </div>

    <div class="home-hero-media">
        <div class="hero-frame">
            @if($heroSlides->isNotEmpty())
                @foreach($heroSlides as $slide)
                    <img src="{{ $slide['url'] }}" class="hero-main-slide {{ $loop->first ? 'is-active' : '' }}" data-hero-main-slide alt="{{ $slide['title'] }}">
                @endforeach
                <div class="hero-highlight-badge">Gallery Highlight</div>
                @if($heroSlides->count() > 1)
                    <div class="hero-slide-dots" aria-label="Highlight galeri">
                        @foreach($heroSlides as $slide)
                            <button type="button" class="hero-slide-dot {{ $loop->first ? 'is-active' : '' }}" data-hero-dot="{{ $loop->index }}" aria-label="Lihat highlight {{ $loop->iteration }}"></button>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="image-fallback">Sejenak Studio</div>
            @endif
            <div class="hero-caption">
                <span data-hero-label>{{ $heroSlides->first()['label'] ?? 'Recent Frame' }}</span>
                <span>Purwokerto</span>
            </div>
        </div>
        <div class="hero-side">
            <div class="hero-note">
                <div class="eyebrow">Mood</div>
                <p>Nyaman untuk sendiri, berdua, atau datang ramai-ramai.</p>
            </div>
            <div class="mini-frame">
                @if($heroSlides->count() > 1)
                    @foreach($heroSlides as $slide)
                        <img src="{{ $heroSlides->get(($loop->index + 1) % $heroSlides->count())['url'] }}" class="hero-mini-slide {{ $loop->first ? 'is-active' : '' }}" alt="Sesi foto Sejenak Studio">
                    @endforeach
                @elseif($heroSlides->isNotEmpty())
                    <img src="{{ $heroSlides->first()['url'] }}" class="w-100 h-100" style="object-fit: cover; filter: saturate(.78) contrast(.95);" alt="Sesi foto Sejenak Studio">
                @else
                    <div class="image-fallback">Self Photo</div>
                @endif
            </div>
        </div>
    </div>
</section>

@if($heroSlides->count() > 1)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hero = document.querySelector('[data-hero-gallery]');
        if (!hero) return;

        const bgSlides = Array.from(hero.querySelectorAll('[data-hero-bg-slide]'));
        const mainSlides = Array.from(hero.querySelectorAll('[data-hero-main-slide]'));
        const miniSlides = Array.from(hero.querySelectorAll('.hero-mini-slide'));
        const dots = Array.from(hero.querySelectorAll('[data-hero-dot]'));
        const label = hero.querySelector('[data-hero-label]');
        const labels = @json($heroSlides->pluck('label')->values());
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let current = 0;
        let timer = null;

        function setActive(index) {
            current = (index + mainSlides.length) % mainSlides.length;
            [bgSlides, mainSlides, miniSlides, dots].forEach(function(group) {
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

<section class="experience-strip">
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-lg-3 col-sm-6"><div class="experience-item"><div class="eyebrow">01</div><h3>Pilih jadwal</h3><p>Cek paket, tentukan tanggal, lalu kirim reservasi dengan form singkat.</p></div></div>
            <div class="col-lg-3 col-sm-6"><div class="experience-item"><div class="eyebrow">02</div><h3>Datang santai</h3><p>Tim kami membantu alur sesi agar kamu tinggal menikmati ruangnya.</p></div></div>
            <div class="col-lg-3 col-sm-6"><div class="experience-item"><div class="eyebrow">03</div><h3>Foto mandiri</h3><p>Gunakan waktu sesi untuk bereksperimen dengan pose dan ekspresi.</p></div></div>
            <div class="col-lg-3 col-sm-6"><div class="experience-item"><div class="eyebrow">04</div><h3>Terima file</h3><p>Hasil foto dikirim dalam bentuk soft file dan cetak sesuai paket.</p></div></div>
        </div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="section-heading">
            <div>
                <div class="eyebrow">Pricelist</div>
                <h2>Paket Layanan</h2>
            </div>
            <a href="{{ route('paket') }}" class="btn btn-outline-primary btn-sm">Semua Paket</a>
        </div>
        <div class="row g-4">
            @foreach($packages as $package)
                @php
                    $packageImage = $package->image && file_exists(public_path('images/packages/' . $package->image))
                        ? $package->image
                        : $localPackageImages->get($loop->index);
                @endphp
                <div class="col-6 col-md-4">
                    <article class="package-card">
                        <div class="package-image">
                            @if($packageImage)
                                <img src="{{ url('images/packages/' . $packageImage) }}" alt="{{ $package->name }}">
                            @else
                                <div class="image-fallback">{{ $package->name }}</div>
                            @endif
                        </div>
                        <div class="package-body">
                            <div class="eyebrow">Paket</div>
                            <h3 class="h4 mb-3">{{ $package->name }}</h3>
                            <p class="text-muted small">{{ Str::limit($package->description, 120) }}</p>
                            <div class="package-price mb-4">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                            <a href="{{ route('reservasi.index', ['package_id' => $package->id]) }}" class="btn btn-primary btn-sm">Pilih Paket</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-pad section-border">
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
                ->filter(fn ($gallery) => $gallery->image && file_exists(public_path('images/galleries/' . $gallery->image)))
                ->values();
        @endphp

        @if($galleryImages->isNotEmpty())
            <div class="gallery-layout">
                @foreach($galleryImages->take(5) as $gallery)
                    <div class="gallery-tile">
                        <img src="{{ url('images/galleries/' . $gallery->image) }}" alt="Galeri {{ $gallery->category }}">
                        <span>{{ $gallery->category }}</span>
                    </div>
                @endforeach
            </div>
        @elseif($localGalleryImages->isNotEmpty())
            <div class="gallery-layout">
                @foreach($localGalleryImages->take(5) as $image)
                    <div class="gallery-tile">
                        <img src="{{ url('images/galleries/' . $image) }}" alt="Galeri Sejenak Studio">
                        <span>Sejenak</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-muted border-top border-bottom py-5">Belum ada foto galeri.</div>
        @endif
    </div>
</section>

<section class="section-pad section-border">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-4">
                <div class="eyebrow">Testimonials</div>
                <h2 class="display-5">Cerita setelah sesi</h2>
            </div>
            <div class="col-lg-8">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="quote-box">
                            <p>"Tempatnya nyaman, jadi gampang dapat ekspresi natural."</p>
                            <h6 class="mb-0">Budi Santoso</h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quote-box">
                            <p>"Reservasinya mudah dan hasil fotonya rapi."</p>
                            <h6 class="mb-0">Siti Aminah</h6>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="quote-box">
                            <p>"Cocok untuk foto bareng teman tanpa suasana kaku."</p>
                            <h6 class="mb-0">Andi Wijaya</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-pad home-cta">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="eyebrow">Reserve</div>
                <h2 class="display-5 mb-3">Siapkan satu waktu kecil untuk momen yang ingin kamu simpan.</h2>
                <p class="mb-0">Pilih paket, background, tanggal, dan jam. Setelah itu admin akan membantu konfirmasi via WhatsApp.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('reservasi.index') }}" class="btn btn-outline-primary btn-lg">Reservasi</a>
            </div>
        </div>
    </div>
</section>
@endsection

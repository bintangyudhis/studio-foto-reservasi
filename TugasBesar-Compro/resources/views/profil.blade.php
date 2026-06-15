@extends('layouts.app')

@section('title', 'Profil Studio – Sejenak Studio Purwokerto')
@section('meta_description', 'Sejenak Studio adalah self photo studio di Purwokerto yang hadir untuk mengabadikan
    momenmu dengan cara yang nyaman, personal, dan bersahabat.')

@section('content')
    <style>
        /* ─── PROFIL PAGE ───────────────────────────────────────── */

        /* Hero: full-bleed — deep teal sesuai color palette */
        .profil-hero {
            background: #084f5c; /* versi gelap dari --ink-deep, masih teal */
            color: var(--white);
            padding: clamp(72px, 12vw, 120px) 0 clamp(60px, 9vw, 96px);
            position: relative;
            overflow: hidden;
        }

        /* Cahaya amber di sudut — melengkapi teal */
        .profil-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 55% 65% at 98% 5%,  rgba(247,169,0,.2) 0%, transparent 52%),
                radial-gradient(ellipse 30% 40% at 2%  95%,  rgba(247,169,0,.1) 0%, transparent 48%),
                radial-gradient(ellipse 70% 80% at 50% 100%, rgba(4,38,45,.5)   0%, transparent 70%);
            pointer-events: none;
        }

        /* Garis tipis bawah hero */
        .profil-hero::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(247,169,0,.4), transparent);
        }

        .profil-hero-eyebrow {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: rgba(247,169,0,.75);
            margin-bottom: 24px;
            display: block;
        }

        .profil-hero-quote {
            font-family: var(--serif);
            font-size: clamp(38px, 7vw, 78px);
            font-style: italic;
            font-weight: 400;
            line-height: 1.15;
            color: rgba(255,250,240,.95);
            margin: 0;
            max-width: 860px;
        }

        .profil-hero-quote em {
            color: #f7a900; /* amber murni, lebih bersih dari --accent */
            font-style: italic;
        }

        .profil-hero-sub {
            margin-top: 28px;
            font-size: clamp(14px, 2vw, 16px);
            color: rgba(255,250,240,.5);
            max-width: 520px;
            line-height: 1.8;
        }

        .profil-hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 36px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(255,250,240,.3);
        }

        .profil-hero-tag::before {
            content: '';
            width: 28px;
            height: 1px;
            background: rgba(247,169,0,.5);
            display: inline-block;
        }

        /* ─── Philosophy Strip — cream hangat, bukan kuning keras ── */
        .philosophy-strip {
            background: var(--paper); /* krem hangat, sama seperti bg halaman */
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
            padding: clamp(48px, 7vw, 80px) 0;
            position: relative;
            overflow: hidden;
        }

        /* Kutip dekoratif besar — teal halus di latar */
        .philosophy-strip::before {
            content: '\201C';
            position: absolute;
            left: -1%;
            top: -10%;
            font-family: var(--serif);
            font-size: 320px;
            color: rgba(19,120,135,.07);
            line-height: 1;
            pointer-events: none;
            user-select: none;
        }

        /* Garis aksen vertikal kiri */
        .philosophy-inner {
            border-left: 3px solid var(--accent);
            padding-left: 32px;
            position: relative;
            z-index: 1;
        }

        .philosophy-text {
            font-family: var(--serif);
            font-size: clamp(20px, 3.4vw, 30px);
            font-style: italic;
            color: var(--ink);
            line-height: 1.7;
            max-width: 780px;
            margin: 0;
        }

        .philosophy-source {
            margin-top: 20px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .philosophy-source::before {
            content: '';
            width: 20px;
            height: 1.5px;
            background: var(--accent);
            display: inline-block;
        }

        /* ─── Stats Row ────────────────────────────────────────── */
        .stat-card {
            text-align: center;
            padding: clamp(28px, 4vw, 44px) 20px;
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, .5);
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(19, 120, 135, .1);
        }

        .stat-num {
            font-family: var(--serif);
            font-size: clamp(42px, 7vw, 62px);
            font-style: italic;
            color: var(--ink);
            line-height: 1;
            display: block;
        }

        .stat-unit {
            font-size: 15px;
            font-family: var(--serif);
            font-style: italic;
            color: var(--accent);
        }

        .stat-label {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: 10px;
            display: block;
        }

        /* ─── Studio Story ─────────────────────────────────────── */
        .story-img-panel {
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
            aspect-ratio: 4/5;
            background:
                radial-gradient(circle at 10% 90%, rgba(247, 169, 0, .85) 0 22%, transparent 22.5%),
                radial-gradient(circle at 90% 8%, rgba(247, 169, 0, .65) 0 16%, transparent 16.5%),
                var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .story-img-panel .brand-big {
            font-family: var(--serif);
            font-size: clamp(48px, 9vw, 80px);
            font-style: italic;
            color: rgba(255, 250, 240, .9);
            text-align: center;
            position: relative;
            z-index: 2;
            line-height: 1.1;
        }

        .story-img-panel .brand-big span {
            display: block;
            font-size: clamp(16px, 2.5vw, 22px);
            font-style: normal;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--accent);
            margin-top: 6px;
        }

        .story-img-panel img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .88;
        }

        /* Timeline */
        .story-timeline {
            list-style: none;
            padding: 0;
            margin: 0;
            border-left: 2px solid var(--line-strong);
            padding-left: 28px;
        }

        .story-timeline li {
            position: relative;
            padding-bottom: 32px;
        }

        .story-timeline li:last-child {
            padding-bottom: 0;
        }

        .story-timeline li::before {
            content: '';
            position: absolute;
            left: -35px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--accent);
            border: 2px solid var(--paper);
            box-shadow: 0 0 0 2px var(--accent);
        }

        .story-year {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 4px;
            display: block;
        }

        .story-title {
            font-weight: 700;
            font-size: 15px;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .story-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.65;
        }

        /* ─── Values Grid ──────────────────────────────────────── */
        .value-card {
            padding: 30px 26px;
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, .46);
            transition: border-color .22s, background .22s;
            height: 100%;
        }

        .value-card:hover {
            border-color: var(--accent);
            background: rgba(255, 255, 255, .7);
        }

        .value-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--accent);
            color: var(--ink-deep);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 18px;
        }

        .value-title {
            font-weight: 700;
            font-size: 15px;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .value-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.65;
            margin: 0;
        }

        /* ─── Founder Note ─────────────────────────────────────── */
        .founder-section {
            background: var(--ink);
            border-radius: var(--radius-lg);
            padding: clamp(36px, 6vw, 60px);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .founder-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 50% 80% at 90% 50%, rgba(247, 169, 0, .15) 0%, transparent 65%);
            pointer-events: none;
        }

        .founder-quote-mark {
            font-family: var(--serif);
            font-size: 96px;
            color: var(--accent);
            line-height: .7;
            margin-bottom: 16px;
            display: block;
        }

        .founder-text {
            font-family: var(--serif);
            font-size: clamp(18px, 3vw, 26px);
            font-style: italic;
            color: rgba(255, 250, 240, .92);
            line-height: 1.65;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .founder-sig {
            margin-top: 28px;
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .founder-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--serif);
            font-size: 22px;
            color: var(--ink-deep);
            font-style: italic;
            font-weight: 400;
            flex-shrink: 0;
        }

        .founder-name {
            font-weight: 700;
            font-size: 14px;
            color: rgba(255, 250, 240, .9);
            margin: 0;
        }

        .founder-role {
            font-size: 11px;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 250, 240, .45);
        }

        /* ─── CTA ──────────────────────────────────────────────── */
        .profil-cta {
            text-align: center;
            padding: clamp(48px, 8vw, 80px) 0;
        }

        @media (max-width: 767.98px) {
            .story-img-panel {
                aspect-ratio: 3/2;
            }

            .philosophy-strip::after {
                display: none;
            }

            .founder-section {
                padding: 28px 22px;
            }
        }
    </style>

    {{-- ─── HERO ──────────────────────────────────────────────────── --}}
    <section class="profil-hero">
        <div class="container position-relative" style="z-index:1;">
            <span class="profil-hero-eyebrow">Tentang Kami · Purwokerto Self Photo Studio</span>
            <h1 class="profil-hero-quote">
                Hadir <em>sejenak,</em><br>
                disimpan <em>selamanya.</em>
            </h1>
            <p class="profil-hero-sub">
                Sejenak Studio adalah self photo studio di Purwokerto yang hadir untuk membantu siapa saja mengabadikan
                momen berharga — dengan suasana yang nyaman, hasil yang rapi, dan harga yang tetap bersahabat.
            </p>
            <span class="profil-hero-tag">Sejenak Studio · Purwokerto</span>
        </div>
    </section>

    {{-- ─── PHILOSOPHY STRIP ──────────────────────────────────────── --}}
    <section class="philosophy-strip">
        <div class="container">
            <div class="philosophy-inner">
                <p class="philosophy-text">
                    "Kata <strong>sejenak</strong> mengartikan bahwa mengambil momen itu hanya sejenak — namun hasilnya untuk selamanya. Seperti momen-momen yang terasa singkat, tapi tiap yang tergambar pada momen bisa diabadikan selamanya."
                </p>
                <span class="philosophy-source">Filosofi Sejenak Studio</span>
            </div>
        </div>
    </section>

    {{-- ─── STATS ─────────────────────────────────────────────────── --}}
    <section class="section-pad" style="padding-bottom: clamp(32px,5vw,56px);">
        <div class="container">
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <span class="stat-num">678<span class="stat-unit">+</span></span>
                        <span class="stat-label">Ulasan Google</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <span class="stat-num">5<span class="stat-unit">.0</span></span>
                        <span class="stat-label">Rating Bintang</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <span class="stat-num">10<span class="stat-unit">:00</span></span>
                        <span class="stat-label">Buka Tiap Hari</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <span class="stat-num">∞</span>
                        <span class="stat-label">Momen Terabadikan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── STUDIO STORY ───────────────────────────────────────────── --}}
    <section class="section-pad">
        <div class="container">
            <div class="row g-5 align-items-center">
                {{-- Panel visual kiri --}}
                <div class="col-lg-5">
                    <div class="story-img-panel">
                        <img src="{{ asset('images/1781112940_6a29a06c30653.jpg') }}" alt="Sejenak Studio Interior"
                            onerror="this.style.display='none'">
                        <div class="brand-big">
                            sejenak
                            <span>photobooth</span>
                        </div>
                    </div>
                </div>

                {{-- Konten kanan --}}
                <div class="col-lg-7">
                    <div class="eyebrow">Kisah Kami</div>
                    <h2 class="display-5 mb-4">Studio yang lahir dari<br><em>keinginan sederhana.</em></h2>
                    <p class="text-muted mb-4" style="line-height:1.8;">
                        Sejenak Studio lahir dari keinginan sederhana: menyediakan ruang bagi siapa saja — mahasiswa,
                        pasangan, sahabat, keluarga — untuk mengabadikan momen berharga mereka tanpa harus mengeluarkan
                        biaya besar. Berlokasi di Mangunjaya, Purwokerto, kami berkomitmen untuk selalu menghadirkan
                        pengalaman foto yang menyenangkan, personal, dan berkualitas.
                    </p>

                    {{-- Timeline --}}
                    <ul class="story-timeline mt-5">
                        <li>
                            <span class="story-year">Awal Berdiri</span>
                            <div class="story-title">Sejenak Studio dibuka di Purwokerto</div>
                            <div class="story-desc">Dengan konsep self photo studio yang simpel namun berkualitas, kami
                                mulai melayani pelanggan pertama kami di Mangunjaya.</div>
                        </li>
                        <li>
                            <span class="story-year">Berkembang</span>
                            <div class="story-title">Rating 5.0 dengan ratusan ulasan positif</div>
                            <div class="story-desc">Kepercayaan pelanggan tumbuh pesat — lebih dari 678 ulasan bintang lima
                                di Google Maps menjadi bukti nyata kualitas layanan kami.</div>
                        </li>
                        <li>
                            <span class="story-year">Sekarang</span>
                            <div class="story-title">Reservasi online & sistem booking modern</div>
                            <div class="story-desc">Kami terus berinovasi dengan menghadirkan sistem reservasi online agar
                                pelanggan bisa memilih jadwal dengan mudah kapan saja.</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── VALUES ─────────────────────────────────────────────────── --}}
    <section class="section-pad"
        style="background: rgba(19,120,135,.04); padding-top: clamp(48px,7vw,80px); padding-bottom: clamp(48px,7vw,80px);">
        <div class="container">
            <div class="section-heading text-center mb-5">
                <div class="eyebrow">Nilai Kami</div>
                <h2 class="display-5">Mengapa memilih<br><em>Sejenak Studio?</em></h2>
            </div>
            <div class="row g-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-camera"></i></div>
                        <div class="value-title">Peralatan Modern</div>
                        <p class="value-desc">Kamera dan lighting profesional untuk hasil foto yang tajam, terang, dan
                            memuaskan di setiap sesi.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-palette"></i></div>
                        <div class="value-title">Pilihan Background</div>
                        <p class="value-desc">Tersedia beragam pilihan background dan properti studio yang bisa disesuaikan
                            dengan tema fotomu.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-users"></i></div>
                        <div class="value-title">Ramah & Berpengalaman</div>
                        <p class="value-desc">Tim admin yang hangat dan fotografer berpengalaman siap membantumu tampil
                            natural dan percaya diri.</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="value-card">
                        <div class="value-icon"><i class="fas fa-tags"></i></div>
                        <div class="value-title">Harga Transparan</div>
                        <p class="value-desc">Tidak ada biaya tersembunyi. Semua harga paket sudah termasuk hasil foto yang
                            bisa langsung dicetak atau dikirim digital.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── FOUNDER NOTE ────────────────────────────────────────────── --}}
    <section class="section-pad">
        <div class="container">
            <div class="founder-section">
                <span class="founder-quote-mark">"</span>
                <p class="founder-text">
                    Kami percaya setiap orang berhak punya foto yang bagus — bukan karena punya kamera mahal, tapi karena
                    punya tempat yang tepat untuk mengabadikan momennya. Sejenak Studio hadir untuk menjadi tempat itu.
                </p>
                <div class="founder-sig">
                    <div class="founder-avatar">S</div>
                    <div>
                        <div class="founder-name">Tim Sejenak Studio</div>
                        <div class="founder-role">Sejenak Selfphoto · Purwokerto</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── CTA ─────────────────────────────────────────────────────── --}}
    <section class="profil-cta">
        <div class="container">
            <div class="eyebrow">Mulai Sekarang</div>
            <h2 class="display-5 mb-3">Siap mengabadikan<br><em>momenmu?</em></h2>
            <p class="text-muted mb-5" style="max-width:420px; margin:0 auto 32px;">Pilih paket yang sesuai dan buat
                reservasi langsung secara online. Prosesnya mudah, cepat, dan terjangkau.</p>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="{{ route('reservasi.index') }}" class="btn btn-primary px-5 py-3">
                    <i class="fas fa-calendar-check me-2"></i>Buat Reservasi
                </a>
                <a href="{{ route('paket') }}" class="btn btn-outline-primary px-5 py-3">
                    Lihat Paket
                </a>
            </div>
        </div>
    </section>

@endsection

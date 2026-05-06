@extends('layouts.app')

@section('content')
<style>
    .info-lead {
        max-width: 520px;
    }
    .info-list {
        border-top: 1px solid var(--line);
        margin-top: 28px;
    }
    .info-list-item {
        border-bottom: 1px solid var(--line);
        padding: 20px 0;
    }
    .info-list-item h3 {
        font-family: var(--sans);
        font-size: 14px;
        font-weight: 700 !important;
        letter-spacing: 0;
        margin-bottom: 6px;
    }
    .contact-stack {
        display: grid;
        gap: 16px;
    }
    .contact-card {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        padding: 22px;
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        background: rgba(255, 255, 255, .54);
        text-decoration: none;
        transition: transform .2s ease, border-color .2s ease, background .2s ease;
    }
    .contact-card:hover {
        background: rgba(255, 255, 255, .76);
        border-color: var(--line-strong);
        transform: translateY(-3px);
    }
    .contact-card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 48px;
        width: 48px;
        height: 48px;
        border-radius: 15px;
        background: var(--accent);
        color: var(--ink-deep);
        font-size: 20px;
    }
    .contact-card h3 {
        font-family: var(--sans);
        font-size: 13px;
        font-weight: 800 !important;
        letter-spacing: .12em;
        margin-bottom: 6px;
        text-transform: uppercase;
    }
    .contact-card p {
        margin-bottom: 0;
    }
    .map-frame {
        width: 100%;
        height: clamp(300px, 44vw, 440px);
        border: 0;
        display: block;
    }
    .rating-score {
        font-family: var(--serif);
        font-size: clamp(54px, 10vw, 72px);
        line-height: 1;
    }
    .mini-info-card {
        height: 100%;
    }

    @media (max-width: 767.98px) {
        .info-list {
            margin-top: 20px;
        }
        .info-list-item {
            padding: 15px 0;
        }
        .contact-card {
            padding: 16px;
            gap: 14px;
        }
        .contact-card-icon {
            flex-basis: 42px;
            width: 42px;
            height: 42px;
            font-size: 18px;
        }
        .map-frame {
            height: 260px;
        }
        .rating-score {
            font-size: 46px;
        }
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="eyebrow">Studio Info</div>
        <h1>Informasi & Kontak</h1>
        <p>Lokasi, jam operasional, kontak, dan akses menuju Sejenak Selfphoto Studio Purwokerto.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-5">
                <div class="eyebrow">Info</div>
                <h2 class="display-5 info-lead">Temukan kami lewat kanal resmi.</h2>

                <div class="info-list">
                    <div class="info-list-item">
                        <h3>Alamat</h3>
                        <p class="text-muted small mb-0">Gg. Masjid, Mangunjaya, Purwokerto, Jawa Tengah 53114</p>
                    </div>
                    <div class="info-list-item">
                        <h3>Telepon / WA</h3>
                        <p class="text-muted small mb-0">0858-7805-9861</p>
                    </div>
                    <div class="info-list-item">
                        <h3>Instagram</h3>
                        <p class="text-muted small mb-0">@sejenakselfphoto</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="contact-stack">
                    <a href="https://wa.me/6285878059861" target="_blank" class="contact-card">
                        <span class="contact-card-icon"><i class="fab fa-whatsapp"></i></span>
                        <span>
                            <h3>WhatsApp</h3>
                            <p class="text-muted">Reservasi, konfirmasi jadwal, dan tanya paket: <strong>0858-7805-9861</strong></p>
                        </span>
                    </a>

                    <a href="https://instagram.com/sejenakselfphoto" target="_blank" class="contact-card">
                        <span class="contact-card-icon"><i class="fab fa-instagram"></i></span>
                        <span>
                            <h3>Instagram</h3>
                            <p class="text-muted">Lihat update studio, referensi pose, promo, dan hasil foto di <strong>@sejenakselfphoto</strong></p>
                        </span>
                    </a>

                    <a href="https://www.google.com/maps?q=-7.419678,109.250097" target="_blank" class="contact-card">
                        <span class="contact-card-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <span>
                            <h3>Google Maps</h3>
                            <p class="text-muted">Gg. Masjid, Mangunjaya, Purwokerto, Jawa Tengah 53114</p>
                        </span>
                    </a>

                    <div class="contact-card">
                        <span class="contact-card-icon"><i class="fas fa-clock"></i></span>
                        <span>
                            <h3>Jam Operasional</h3>
                            <p class="text-muted">Buka setiap hari pukul <strong>10.00 - 21.00 WIB</strong>, termasuk hari libur nasional.</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-5">
            <div class="col-lg-8">
                <div class="card overflow-hidden h-100">
                    <div class="p-4 border-bottom d-flex justify-content-between align-items-center gap-3 flex-wrap">
                        <div>
                            <div class="eyebrow mb-1">Map</div>
                            <h2 class="h3 mb-0">Lokasi Sejenak Studio</h2>
                        </div>
                        <a href="https://www.google.com/maps?q=-7.419678,109.250097" target="_blank" class="btn btn-outline-primary btn-sm">Buka Maps</a>
                    </div>
                    <iframe src="https://maps.google.com/maps?q=-7.419678,109.250097&z=17&output=embed"
                        class="map-frame"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Lokasi Sejenak Selfphoto Studio Purwokerto"></iframe>
                    <div class="p-4 border-top small text-muted">
                        Koordinat: -7.419678, 109.250097
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card p-4 mini-info-card">
                    <div class="eyebrow">Review</div>
                    <div class="rating-score">5.0</div>
                    <div class="small text-muted mb-3">678 ulasan di Google Maps</div>
                    <h3 class="h4 mb-2">Sejenak Selfphoto Studio Purwokerto</h3>
                    <p class="text-muted small mb-4">Portrait studio terpercaya di Purwokerto dengan ratusan ulasan positif dari pelanggan.</p>
                    <a href="https://www.google.com/maps?q=-7.419678,109.250097" target="_blank" class="btn btn-primary w-100">Lihat Google Maps</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

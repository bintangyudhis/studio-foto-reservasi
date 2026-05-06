@extends('layouts.app')

@section('content')
<style>
    .map-frame {
        width: 100%;
        height: clamp(320px, 48vw, 470px);
        border: 0;
        display: block;
    }
    .rating-score {
        font-family: var(--serif);
        font-size: clamp(54px, 10vw, 72px);
        line-height: 1;
    }
    @media (max-width: 575.98px) {
        .map-frame {
            height: 260px;
        }
        .info-row {
            align-items: flex-start !important;
            flex-direction: column;
            gap: 4px;
        }
        .card h3,
        .card h2 {
            font-size: 22px;
        }
        .card .p-4 {
            padding: 18px !important;
        }
        .rating-score {
            font-size: 46px;
        }
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="eyebrow">Studio Info</div>
        <h1>Informasi Studio</h1>
        <p>Lokasi, jam operasional, kontak, dan akses menuju Sejenak Selfphoto Studio Purwokerto.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card p-4 mb-4">
                    <div class="eyebrow">Hours</div>
                    <h3 class="h4 mb-3">Jam Operasional</h3>
                    <div class="d-flex justify-content-between border-top py-3 info-row">
                        <span class="text-muted small">Senin - Minggu</span>
                        <strong>10:00 - 21:00 WIB</strong>
                    </div>
                    <div class="d-flex justify-content-between border-top py-3 info-row">
                        <span class="text-muted small">Hari Libur</span>
                        <strong>Tetap buka</strong>
                    </div>
                </div>

                <div class="card p-4 mb-4">
                    <div class="eyebrow">Address</div>
                    <h3 class="h4 mb-3">Alamat Lengkap</h3>
                    <p class="text-muted small">Gg. Masjid, Mangunjaya, Purwokerto, Kec. Purwokerto Tim., Kabupaten Banyumas, Jawa Tengah 53114</p>
                    <a href="https://www.google.com/maps?q=-7.419678,109.250097" target="_blank" class="btn btn-primary w-100">Get Directions</a>
                </div>

                <div class="card p-4">
                    <div class="eyebrow">Contact</div>
                    <h3 class="h4 mb-3">Hubungi Kami</h3>
                    <a href="https://wa.me/6285878059861" target="_blank" class="d-block text-decoration-none border-top py-3">WhatsApp: 0858-7805-9861</a>
                    <a href="https://instagram.com/sejenakselfphoto" target="_blank" class="d-block text-decoration-none border-top py-3">Instagram: @sejenakselfphoto</a>
                </div>
            </div>

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
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="rating-score">5.0</div>
                            <div class="small text-muted">678 ulasan di Google Maps</div>
                        </div>
                        <div class="col-md-8">
                            <div class="eyebrow">Review</div>
                            <h3 class="mb-2">Sejenak Selfphoto Studio Purwokerto</h3>
                            <p class="text-muted mb-4">Portrait studio terpercaya di Purwokerto dengan ratusan ulasan positif dari pelanggan.</p>
                            <a href="https://www.google.com/maps?q=-7.419678,109.250097" target="_blank" class="btn btn-primary">Lihat di Google Maps</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

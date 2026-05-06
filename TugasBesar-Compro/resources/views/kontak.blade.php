@extends('layouts.app')

@section('content')
<style>
    @media (max-width: 575.98px) {
        .contact-info-block {
            padding-top: 14px !important;
            padding-bottom: 14px !important;
        }
        .contact-socials {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr);
        }
        .contact-socials .btn {
            width: 100%;
        }
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="eyebrow">Contact</div>
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu memilih paket, mengecek jadwal, atau menjawab pertanyaan sebelum sesi foto.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-5">
                <div class="eyebrow">Info</div>
                <h2 class="display-5 mb-4">Mari mulai dari pesan singkat.</h2>

                <div class="border-top py-4 contact-info-block">
                    <h6 class="fw-bold mb-1">Alamat</h6>
                    <p class="text-muted small mb-0">Gg. Masjid, Mangunjaya, Purwokerto, Jawa Tengah 53114</p>
                </div>
                <div class="border-top py-4 contact-info-block">
                    <h6 class="fw-bold mb-1">Telepon / WA</h6>
                    <p class="text-muted small mb-0">0858-7805-9861</p>
                </div>
                <div class="border-top py-4 contact-info-block">
                    <h6 class="fw-bold mb-1">Instagram</h6>
                    <p class="text-muted small mb-0">@sejenakselfphoto</p>
                </div>

                <div class="d-flex gap-2 mt-3 contact-socials">
                    <a href="https://instagram.com/sejenakselfphoto" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/6285878059861" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.google.com/maps?q=-7.419678,109.250097" target="_blank" class="btn btn-outline-primary btn-sm"><i class="fas fa-map-marker-alt"></i></a>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card p-4 p-md-5">
                    <h3 class="mb-4">Kirim Pesan</h3>
                    <form action="#">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" placeholder="Nama Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Email Anda" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subjek</label>
                            <input type="text" class="form-control" placeholder="Tujuan Pesan">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Pesan Anda</label>
                            <textarea class="form-control" rows="5" placeholder="Tuliskan pesan Anda di sini..."></textarea>
                        </div>
                        <button type="button" class="btn btn-primary px-5">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

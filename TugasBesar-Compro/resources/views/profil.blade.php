@extends('layouts.app')

@section('content')
<style>
    .profile-logo-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: clamp(260px, 46vw, 430px);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        background:
            radial-gradient(circle at 14% 86%, rgba(247, 169, 0, .96) 0 18%, transparent 18.5%),
            radial-gradient(circle at 94% 12%, rgba(247, 169, 0, .78) 0 14%, transparent 14.5%),
            var(--white);
        padding: clamp(32px, 6vw, 72px);
    }
    .profile-logo-panel img {
        width: min(100%, 420px);
        height: auto;
        filter: drop-shadow(0 18px 30px rgba(19, 120, 135, .14));
    }
    @media (max-width: 575.98px) {
        .profile-logo-panel {
            padding: 28px;
        }
        .profile-logo-panel img {
            width: min(100%, 300px);
        }
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="eyebrow">About</div>
        <h1>Tentang Sejenak</h1>
        <p>Studio foto mandiri yang memberi ruang untuk hadir sebentar, mengambil napas, lalu menyimpan momen dengan cara yang sederhana.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-md-6">
                <div class="profile-logo-panel">
                    <img src="{{ asset('images/sejenak-logo.svg') }}" alt="Logo Sejenak Studio">
                </div>
            </div>
            <div class="col-md-6">
                <div class="eyebrow">Visi & Misi</div>
                <h2 class="display-5 mb-4">Momen yang terasa personal.</h2>
                <p class="text-muted">Sejenak Studio lahir dari keinginan membantu setiap orang mengabadikan momen berharga dengan suasana yang nyaman, hasil rapi, dan harga yang tetap bersahabat.</p>
                <p class="text-muted">Kami percaya setiap jepretan adalah cerita yang layak disimpan, baik untuk diri sendiri, pasangan, sahabat, maupun keluarga.</p>

                <div class="row g-3 mt-4">
                    <div class="col-sm-6"><div class="border-top pt-3">Fotografer dan admin berpengalaman</div></div>
                    <div class="col-sm-6"><div class="border-top pt-3">Pilihan background studio</div></div>
                    <div class="col-sm-6"><div class="border-top pt-3">Peralatan modern</div></div>
                    <div class="col-sm-6"><div class="border-top pt-3">Harga transparan</div></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

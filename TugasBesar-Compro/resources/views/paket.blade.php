@extends('layouts.app')

@section('content')
<style>
    .price-card { display: flex; flex-direction: column; height: 100%; border: 1px solid var(--line); border-radius: var(--radius-lg); background: rgba(255,255,255,.42); overflow: hidden; }
    .price-head { padding: clamp(20px, 3vw, 24px); border-bottom: 1px solid var(--line); }
    .price-value { padding: 28px clamp(20px, 3vw, 24px) 12px; font-family: var(--serif); font-size: clamp(46px, 7vw, 58px); line-height: 1; }
    .price-body { display: flex; flex: 1; flex-direction: column; padding: 12px clamp(20px, 3vw, 24px) 26px; }
    .price-body li { border-top: 1px solid var(--line); padding: 12px 0; color: var(--muted); }
    .price-body .btn { margin-top: auto; }
    .tag-popular { float: right; font-family: var(--sans); font-size: 10px; letter-spacing: .14em; text-transform: uppercase; color: var(--muted); }
    .background-tile { border: 1px solid var(--line); border-radius: var(--radius-lg); background: rgba(255,255,255,.42); overflow: hidden; }
    .background-swatch { height: clamp(150px, 22vw, 210px); display: flex; align-items: center; justify-content: center; }
    .background-name { padding: 16px; border-top: 1px solid var(--line); font-family: var(--serif); font-size: 22px; font-style: italic; text-align: center; }
    @media (max-width: 575.98px) {
        .price-head {
            padding: 14px;
        }
        .price-head h2 {
            font-size: 22px;
        }
        .price-value {
            padding: 16px 14px 6px;
            font-size: 36px;
        }
        .price-body {
            padding: 6px 14px 16px;
        }
        .price-body ul {
            margin-bottom: 14px !important;
        }
        .price-body li {
            padding: 8px 0;
            font-size: 12px;
            line-height: 1.45;
        }
        .price-card .btn {
            width: 100%;
            min-height: 36px;
            padding: 8px 12px;
            font-size: 9px;
        }
        .tag-popular {
            font-size: 9px;
        }
        .background-swatch {
            height: 120px;
        }
        .background-name {
            font-size: 18px;
            padding: 13px;
        }
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="eyebrow">Pricelist</div>
        <h1>Selfphoto Packages</h1>
        <p>Pilih paket yang sesuai. Semua sesi berlangsung pukul 10.00 sampai 21.00 WIB setiap hari, termasuk hari libur.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach ($packages as $package)
                <div class="col-md-6 col-lg-3">
                    <article class="price-card">
                        <div class="price-head">
                            @if (Str::contains(strtolower($package->name), 'memori'))
                                <span class="tag-popular">Populer</span>
                            @endif
                            <div class="eyebrow mb-2">Paket</div>
                            <h2 class="h3 mb-0">{{ $package->name }}</h2>
                        </div>
                        <div class="price-value">
                            {{ $package->price >= 1000 ? intval($package->price / 1000) . 'K' : $package->price }}
                        </div>
                        <div class="price-body">
                            <ul class="list-unstyled mb-4">
                                @foreach (explode("\n", $package->description) as $line)
                                    @if (trim($line))
                                        <li>{{ ltrim(trim($line), '-– ') }}</li>
                                    @endif
                                @endforeach
                            </ul>
                            <a href="{{ route('reservasi.index', ['package_id' => $package->id]) }}" class="btn btn-primary w-100">Pilih Paket</a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="border-top border-bottom py-4 text-center">
                    <div class="eyebrow">Add-on</div>
                    <div class="d-flex justify-content-center gap-5 flex-wrap">
                        <div><strong>Rp 20.000</strong><div class="small text-muted">+10 menit sesi foto</div></div>
                        <div><strong>Rp 10.000</strong><div class="small text-muted">+1 orang tambahan</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-pad section-border">
    <div class="container">
        <div class="text-center mb-5">
            <div class="eyebrow">Background</div>
            <h2 class="display-5">Pilihan Ruang</h2>
            <p class="text-muted mb-0">Semua paket termasuk satu pilihan background.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3"><div class="background-tile"><div class="background-swatch" style="background: linear-gradient(180deg, #f5f5f2, #dfddd8);"></div><div class="background-name">White</div></div></div>
            <div class="col-6 col-md-3"><div class="background-tile"><div class="background-swatch" style="background: linear-gradient(180deg, #c8c8c8, #9f9f9f);"></div><div class="background-name">Elevator</div></div></div>
            <div class="col-6 col-md-3"><div class="background-tile"><div class="background-swatch" style="background: linear-gradient(180deg, #b54830, #7c2d20);"></div><div class="background-name">Red Box</div></div></div>
            <div class="col-6 col-md-3"><div class="background-tile"><div class="background-swatch" style="background: linear-gradient(180deg, #7a7a7a, #4f4f4f);"></div><div class="background-name">Grey</div></div></div>
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('reservasi.index') }}" class="btn btn-primary btn-lg">Reservasi Sekarang</a>
        </div>
    </div>
</section>
@endsection

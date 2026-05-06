@extends('layouts.app')

@section('content')
<style>
    .gallery-frame {
        aspect-ratio: 3 / 4;
        background: var(--photo);
        border-radius: var(--radius-lg);
    }
    .gallery-frame img {
        transition: transform .35s ease, filter .35s ease;
    }
    .gallery-frame:hover img {
        transform: scale(1.035);
        filter: saturate(.9);
    }
    @media (max-width: 767.98px) {
        .gallery-frame {
            aspect-ratio: 3 / 4;
        }
    }
    @media (max-width: 575.98px) {
        .filter-btn {
            flex: 1 1 calc(50% - 8px);
            min-width: 0;
        }
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="eyebrow">Gallery</div>
        <h1>Galeri Foto</h1>
        <p>Koleksi frame dari sesi Sejenak Studio, disusun sederhana agar fotonya yang bicara.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
            <button class="btn btn-primary btn-sm filter-btn" data-filter="all">Semua</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="Berdua">Berdua</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="Senandung">Senandung</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="Memori">Memori</button>
            <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="Lembayung">Lembayung</button>
        </div>

        <div class="row g-3" id="gallery-container">
            @forelse($galleries as $gallery)
                <div class="col-md-4 col-sm-6 gallery-item" data-category="{{ $gallery->category }}">
                    <div class="border overflow-hidden gallery-frame">
                        <img src="{{ url('images/galleries/' . $gallery->image) }}"
                            onerror="this.onerror=null; this.src='{{ asset('images/sejenak-logo.svg') }}'; this.style.objectFit='contain'; this.style.padding='28px';"
                            class="img-fluid w-100 h-100" style="object-fit: cover; filter: saturate(.75);"
                            alt="Paket {{ $gallery->category }}">
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Galeri masih kosong.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.filter-btn');
        const items = document.querySelectorAll('.gallery-item');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                buttons.forEach(btn => {
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                });

                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-primary');

                const filter = button.getAttribute('data-filter');
                items.forEach(item => {
                    const category = item.getAttribute('data-category');
                    item.style.display = filter === 'all' || category.includes(filter) ? 'block' : 'none';
                });
            });
        });
    });
</script>
@endsection

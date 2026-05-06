@extends('layouts.app')

@section('content')
<div class="container section-pad text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="py-5 border-top border-bottom">
                <i class="fas fa-check-circle display-1 mb-4"></i>
                <div class="eyebrow">Booking Received</div>
                <h1>Reservasi Hampir Selesai!</h1>
                <div class="alert alert-warning mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i> WAJIB KONFIRMASI VIA WHATSAPP
                </div>
                <p class="lead text-muted mb-5">Pesanan Anda telah tercatat. Untuk menyelesaikan proses reservasi dan penjadwalan, klik tombol di bawah ini untuk mengirim format konfirmasi ke Admin kami.</p>

                <div class="d-flex flex-column gap-3 justify-content-center align-items-center">
                    <a href="{{ $waLink ?? 'https://wa.me/6285878059861' }}" id="wa-btn" class="btn btn-success btn-lg px-5 py-3">
                        <i class="fab fa-whatsapp me-2 fa-lg"></i> Konfirmasi WhatsApp
                    </a>
                    <a href="{{ route('home') }}" class="text-muted text-decoration-none mt-2">Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Opsional: Buka window WA secara otomatis (browser mungkin memblokir popup tanpa interaksi)
    setTimeout(() => {
        window.open(document.getElementById('wa-btn').href, '_blank');
    }, 2000);
</script>
@endsection

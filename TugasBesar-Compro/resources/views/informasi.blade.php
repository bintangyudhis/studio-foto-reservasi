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

<style>
    /* ─── Booking Calendar Section ──────────────────────────── */
    .booking-calendar-wrap {
        background: rgba(255,255,255,.58);
        border: 1px solid var(--line);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    /* Header */
    .bc-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 22px 26px;
        border-bottom: 1px solid var(--line);
        background: rgba(255,250,240,.7);
        flex-wrap: wrap;
        gap: 12px;
    }
    .bc-month-label {
        font-family: var(--serif);
        font-size: 22px;
        font-style: italic;
        color: var(--ink);
        margin: 0;
    }
    .bc-nav-btn {
        width: 38px; height: 38px;
        border: 1px solid var(--line);
        border-radius: 50%;
        background: transparent;
        color: var(--ink);
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: background .2s, border-color .2s;
    }
    .bc-nav-btn:hover { background: var(--accent); border-color: var(--accent); color: #fff; }

    /* Weekday header */
    .bc-grid {
        padding: 18px 20px 20px;
    }
    .bc-weekdays {
        display: grid;
        grid-template-columns: repeat(7,1fr);
        margin-bottom: 6px;
    }
    .bc-weekday {
        text-align: center;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 6px 0;
    }
    .bc-weekday:first-child { color: #e0634a; }

    /* Day cells */
    .bc-days {
        display: grid;
        grid-template-columns: repeat(7,1fr);
        gap: 4px;
    }
    .bc-day {
        aspect-ratio: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        position: relative;
        transition: background .2s, transform .15s;
        border: 1.5px solid transparent;
    }
    .bc-day:hover:not(.bc-empty):not(.bc-past) {
        transform: scale(1.08);
        border-color: var(--ink);
    }
    .bc-day.bc-empty { cursor: default; }
    .bc-day.bc-past  { opacity: .35; cursor: not-allowed; }
    .bc-day.bc-today { border-color: var(--ink) !important; font-weight: 800; }
    .bc-day.bc-selected { border-color: var(--ink) !important; background: var(--ink); color: #fff !important; }

    /* Status dot */
    .bc-dot {
        width: 5px; height: 5px;
        border-radius: 50%;
        margin-top: 3px;
        flex-shrink: 0;
    }
    .bc-day.bc-available .bc-dot  { background: #27ae60; }
    .bc-day.bc-partial  .bc-dot   { background: var(--accent); }
    .bc-day.bc-full     .bc-dot   { background: #e0634a; }
    .bc-day.bc-available { color: var(--ink); }
    .bc-day.bc-partial   { color: var(--ink); }
    .bc-day.bc-full      { color: var(--muted); }
    .bc-day.bc-nodata    { color: var(--muted); }

    /* Loading shimmer */
    .bc-loading .bc-day { animation: bcShimmer 1.2s ease-in-out infinite; }
    @keyframes bcShimmer { 0%,100%{opacity:.4} 50%{opacity:1} }

    /* Legend */
    .bc-legend {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        padding: 14px 26px;
        border-top: 1px solid var(--line);
        background: rgba(255,250,240,.5);
    }
    .bc-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .06em;
        color: var(--muted);
    }
    .bc-legend-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
    }

    /* Slot panel */
    .bc-slot-panel {
        border-left: 1px solid var(--line);
        display: flex;
        flex-direction: column;
    }
    .bc-slot-header {
        padding: 22px 22px 14px;
        border-bottom: 1px solid var(--line);
        background: rgba(255,250,240,.7);
    }
    .bc-slot-title {
        font-family: var(--serif);
        font-size: 16px;
        font-style: italic;
        color: var(--ink);
        margin: 0;
    }
    .bc-slot-sub {
        font-size: 11px;
        color: var(--muted);
        margin-top: 2px;
    }

    .bc-slot-list {
        padding: 14px 16px;
        flex: 1;
        overflow-y: auto;
        max-height: 420px;
    }
    .bc-slot-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-radius: var(--radius-md);
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid transparent;
        transition: background .18s;
    }
    .bc-slot-item.slot-avail {
        background: rgba(39,174,96,.08);
        border-color: rgba(39,174,96,.2);
        color: #27ae60;
    }
    .bc-slot-item.slot-booked {
        background: rgba(224,99,74,.08);
        border-color: rgba(224,99,74,.2);
        color: #e0634a;
    }
    .bc-slot-badge {
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        padding: 3px 8px;
        border-radius: 99px;
    }
    .slot-avail  .bc-slot-badge { background: rgba(39,174,96,.15); }
    .slot-booked .bc-slot-badge { background: rgba(224,99,74,.15); }

    .bc-slot-empty {
        text-align: center;
        color: var(--muted);
        font-size: 13px;
        padding: 40px 16px;
        opacity: .7;
    }

    @media (max-width: 767.98px) {
        .bc-slot-panel { border-left: none; border-top: 1px solid var(--line); }
        .bc-slot-list { max-height: 280px; }
        .bc-header { padding: 16px; }
        .bc-grid { padding: 12px 10px 14px; }
        .bc-day { font-size: 12px; border-radius: 8px; }
    }
</style>

{{-- ─── BOOKING CALENDAR SECTION ─────────────────────────────────── --}}
<section class="section-pad" style="padding-top: 0;">
    <div class="container">
        <div class="section-heading text-center mb-5">
            <div class="eyebrow">Jadwal Studio</div>
            <h2 class="display-5">Ketersediaan Booking</h2>
            <p class="text-muted mx-auto" style="max-width:520px;">Lihat jadwal dan ketersediaan slot booking Sejenak Studio secara real-time. Pilih tanggal untuk melihat detail jam yang tersedia.</p>
        </div>

        <div class="row g-0 booking-calendar-wrap shadow-sm">
            {{-- KIRI: Kalender --}}
            <div class="col-lg-8">
                <div class="bc-header">
                    <div class="d-flex align-items-center gap-3">
                        <button class="bc-nav-btn" id="bc-prev" aria-label="Bulan sebelumnya">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h2 class="bc-month-label" id="bc-month-label">Memuat...</h2>
                        <button class="bc-nav-btn" id="bc-next" aria-label="Bulan berikutnya">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <a href="{{ route('reservasi.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-calendar-plus me-1"></i>Buat Reservasi
                    </a>
                </div>

                <div class="bc-grid" id="bc-grid">
                    <div class="bc-weekdays">
                        <div class="bc-weekday">Min</div>
                        <div class="bc-weekday">Sen</div>
                        <div class="bc-weekday">Sel</div>
                        <div class="bc-weekday">Rab</div>
                        <div class="bc-weekday">Kam</div>
                        <div class="bc-weekday">Jum</div>
                        <div class="bc-weekday">Sab</div>
                    </div>
                    <div class="bc-days" id="bc-days">
                        {{-- diisi via JS --}}
                    </div>
                </div>

                <div class="bc-legend">
                    <div class="bc-legend-item"><span class="bc-legend-dot" style="background:#27ae60;"></span>Tersedia</div>
                    <div class="bc-legend-item"><span class="bc-legend-dot" style="background:var(--accent);"></span>Sebagian terisi</div>
                    <div class="bc-legend-item"><span class="bc-legend-dot" style="background:#e0634a;"></span>Penuh</div>
                    <div class="bc-legend-item"><span class="bc-legend-dot" style="background:#ccc;"></span>Belum ada data</div>
                </div>
            </div>

            {{-- KANAN: Slot jam --}}
            <div class="col-lg-4 bc-slot-panel">
                <div class="bc-slot-header">
                    <div class="bc-slot-title" id="bc-slot-title">Pilih tanggal</div>
                    <div class="bc-slot-sub" id="bc-slot-sub">Klik tanggal di kalender untuk melihat slot jam</div>
                </div>
                <div class="bc-slot-list" id="bc-slot-list">
                    <div class="bc-slot-empty">
                        <i class="fas fa-calendar-day fa-2x mb-3 d-block" style="color:var(--line-strong);"></i>
                        Pilih tanggal di kalender
                    </div>
                </div>
            </div>
        </div>

        {{-- Info tambahan --}}
        <div class="row g-3 mt-4">
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center">
                    <i class="fas fa-clock fa-2x mb-3" style="color:var(--accent);"></i>
                    <h3 class="h6 fw-bold mb-1">Jam Operasional</h3>
                    <p class="text-muted small mb-0">10.00 – 21.00 WIB setiap hari<br>Termasuk hari libur nasional</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center">
                    <i class="fas fa-users fa-2x mb-3" style="color:var(--accent);"></i>
                    <h3 class="h6 fw-bold mb-1">Durasi per Sesi</h3>
                    <p class="text-muted small mb-0">Setiap slot berlangsung ±60 menit<br>1 slot = 1 waktu booking</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 text-center">
                    <i class="fas fa-whatsapp fa-2x mb-3" style="color:var(--accent);"></i>
                    <h3 class="h6 fw-bold mb-1">Konfirmasi Booking</h3>
                    <p class="text-muted small mb-0">Setelah booking, konfirmasi via<br>WhatsApp: 0858-7805-9861</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    const ALL_SLOTS = ['10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00'];
    const MONTH_NAMES = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    let currentYear  = new Date().getFullYear();
    let currentMonth = new Date().getMonth() + 1; // 1-based
    let calendarData = {};
    let selectedDate = null;

    const elMonthLabel = document.getElementById('bc-month-label');
    const elDays       = document.getElementById('bc-days');
    const elSlotTitle  = document.getElementById('bc-slot-title');
    const elSlotSub    = document.getElementById('bc-slot-sub');
    const elSlotList   = document.getElementById('bc-slot-list');

    // ─── Fetch calendar data ───────────────────────────────────
    async function fetchCalendar(year, month) {
        elDays.innerHTML = '';
        elDays.closest('.bc-grid').classList.add('bc-loading');
        elMonthLabel.textContent = MONTH_NAMES[month - 1] + ' ' + year;

        try {
            const res  = await fetch(`/reservasi/calendar?year=${year}&month=${month}`);
            const data = await res.json();
            calendarData = data.dates || {};
        } catch(e) {
            calendarData = {};
        }

        elDays.closest('.bc-grid').classList.remove('bc-loading');
        renderDays(year, month);
    }

    // ─── Render day cells ──────────────────────────────────────
    function renderDays(year, month) {
        elDays.innerHTML = '';

        const today    = new Date();
        today.setHours(0,0,0,0);
        const firstDay = new Date(year, month - 1, 1).getDay(); // 0=Sun
        const daysInMonth = new Date(year, month, 0).getDate();

        // Empty cells before first day
        for (let i = 0; i < firstDay; i++) {
            const blank = document.createElement('div');
            blank.className = 'bc-day bc-empty';
            elDays.appendChild(blank);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = `${year}-${String(month).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const dateObj = new Date(year, month - 1, d);
            const isPast  = dateObj < today;
            const isToday = dateObj.getTime() === today.getTime();
            const status  = calendarData[dateStr] || 'nodata';

            const cell = document.createElement('div');
            cell.className = `bc-day bc-${status}${isPast ? ' bc-past' : ''}${isToday ? ' bc-today' : ''}${selectedDate === dateStr ? ' bc-selected' : ''}`;
            cell.setAttribute('data-date', dateStr);
            cell.setAttribute('title', dateStr);
            cell.innerHTML = `<span>${d}</span><span class="bc-dot"></span>`;

            if (!isPast) {
                cell.addEventListener('click', () => selectDate(dateStr, d, month, year));
            }

            elDays.appendChild(cell);
        }
    }

    // ─── Select date & load slots ──────────────────────────────
    async function selectDate(dateStr, day, month, year) {
        selectedDate = dateStr;

        // Update selected styling
        document.querySelectorAll('.bc-day').forEach(c => c.classList.remove('bc-selected'));
        const clicked = document.querySelector(`.bc-day[data-date="${dateStr}"]`);
        if (clicked) clicked.classList.add('bc-selected');

        // Update slot panel header
        const dayNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const dow = new Date(year, month - 1, day).getDay();
        elSlotTitle.textContent = `${dayNames[dow]}, ${day} ${MONTH_NAMES[month-1]} ${year}`;
        elSlotSub.textContent = 'Memuat slot jam...';
        elSlotList.innerHTML = '<div class="bc-slot-empty"><i class="fas fa-spinner fa-spin fa-lg"></i></div>';

        try {
            const res  = await fetch(`/reservasi/slots?date=${dateStr}`);
            const data = await res.json();
            renderSlots(data.booked_times || []);
        } catch(e) {
            elSlotList.innerHTML = '<div class="bc-slot-empty">Gagal memuat data. Coba lagi.</div>';
        }
    }

    // ─── Render slot items ─────────────────────────────────────
    function renderSlots(bookedTimes) {
        const bookedSet = new Set(bookedTimes);
        const available = ALL_SLOTS.filter(s => !bookedSet.has(s)).length;

        elSlotSub.textContent = `${available} dari ${ALL_SLOTS.length} slot tersedia`;
        elSlotList.innerHTML = '';

        ALL_SLOTS.forEach(slot => {
            const isBooked = bookedSet.has(slot);
            const item = document.createElement('div');
            item.className = `bc-slot-item ${isBooked ? 'slot-booked' : 'slot-avail'}`;
            item.innerHTML = `
                <span><i class="fas fa-${isBooked ? 'lock' : 'clock'} me-2"></i>${slot} WIB</span>
                <span class="bc-slot-badge">${isBooked ? 'Terbooked' : 'Tersedia'}</span>
            `;
            elSlotList.appendChild(item);
        });
    }

    // ─── Nav buttons ───────────────────────────────────────────
    document.getElementById('bc-prev').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 1) { currentMonth = 12; currentYear--; }
        fetchCalendar(currentYear, currentMonth);
    });

    document.getElementById('bc-next').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 12) { currentMonth = 1; currentYear++; }
        fetchCalendar(currentYear, currentMonth);
    });

    // ─── Initial load ──────────────────────────────────────────
    fetchCalendar(currentYear, currentMonth);
})();
</script>

@endsection

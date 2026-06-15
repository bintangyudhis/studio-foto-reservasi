@extends('layouts.app')

@section('content')
<style>
    /* ====== MINI CALENDAR ====== */
    .res-calendar-wrap {
        border: 1.5px solid var(--line);
        border-radius: var(--radius-md);
        overflow: hidden;
        background: #fff;
        margin-bottom: 20px;
    }
    .cal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--ink);
        color: #fff;
        padding: 12px 16px;
        font-family: var(--sans);
    }
    .cal-header button {
        background: rgba(255,255,255,.15);
        border: none;
        color: #fff;
        width: 30px; height: 30px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
        transition: background .2s;
    }
    .cal-header button:hover { background: rgba(255,255,255,.3); }
    .cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0;
    }
    .cal-dayname {
        text-align: center;
        padding: 8px 4px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--muted);
        border-bottom: 1px solid var(--line);
    }
    .cal-day {
        text-align: center;
        padding: 8px 4px;
        font-size: 13px;
        cursor: pointer;
        border-radius: 0;
        transition: background .15s;
        min-height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .cal-day.empty { cursor: default; }
    .cal-day.past  { color: #ccc; cursor: not-allowed; }
    .cal-day.full  { background: #fee2e2; color: #c0392b; cursor: not-allowed; font-weight: 600; }
    .cal-day.full::after { content:'✕'; font-size:8px; position:absolute; top:3px; right:4px; color:#c0392b; }
    .cal-day.partial { background: #fef9c3; color: #92400e; }
    .cal-day.partial::after { content:'~'; font-size:10px; position:absolute; top:2px; right:4px; color:#b45309; }
    .cal-day.available:hover { background: rgba(19,120,135,.1); }
    .cal-day.selected { background: var(--ink) !important; color: #fff !important; border-radius: 6px; font-weight: 700; }

    /* ====== TIME SLOT PICKER ====== */
    .time-slot-section { margin-bottom: 20px; }
    .time-slot-section label { font-weight: 700; font-family: var(--sans); display: block; margin-bottom: 8px; }
    .slot-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
    }
    .slot-btn {
        padding: 10px 4px;
        border: 1.5px solid var(--line);
        border-radius: var(--radius-sm);
        background: #fff;
        font-family: var(--sans);
        font-size: 12px;
        font-weight: 600;
        color: var(--ink);
        cursor: pointer;
        transition: all .2s;
        text-align: center;
    }
    .slot-btn:hover:not(.booked) { border-color: var(--ink); background: rgba(19,120,135,.08); }
    .slot-btn.selected { background: var(--ink); color: #fff; border-color: var(--ink); }
    .slot-btn.booked {
        background: #f3f4f6;
        color: #9ca3af;
        border-color: #e5e7eb;
        cursor: not-allowed;
        text-decoration: line-through;
    }
    .slot-loading { text-align:center; color:var(--muted); padding:16px; font-size:13px; }

    .cal-legend { display:flex; gap:14px; flex-wrap:wrap; font-size:11px; color:var(--muted); margin-top:10px; padding: 0 12px 10px; }
    .cal-legend span { display:flex; align-items:center; gap:4px; }
    .dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; }

    @media (max-width: 575.98px) {
        .reservation-card { padding: 18px !important; }
        .slot-grid { grid-template-columns: repeat(3, 1fr); }
    }
</style>

<section class="page-header">
    <div class="container text-center">
        <div class="eyebrow">Booking</div>
        <h1>Buat Reservasi</h1>
        <p>Pilih paket dan jadwal sesuai keinginan Anda.</p>
    </div>
</section>

<div class="container section-pad">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4 p-md-5 reservation-card">

                <form action="{{ route('reservasi.store') }}" method="POST" id="reservation-form">
                    @csrf

                    {{-- Nama & Telepon --}}
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso"
                                value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">No. HP (WhatsApp)</label>
                            <input type="text" name="phone" class="form-control" placeholder="Contoh: 08123456789"
                                value="{{ old('phone') }}" required>
                        </div>
                    </div>

                    {{-- Paket --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Paket Layanan</label>
                        <select name="service_package_id" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}"
                                    {{ old('service_package_id') == $package->id ? 'selected' : '' }}>
                                    {{ $package->name }} — Rp {{ number_format($package->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Background --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Background</label>
                        <select name="background" class="form-select" required>
                            <option value="">-- Pilih Background --</option>
                            <option value="White"    {{ old('background') == 'White'    ? 'selected' : '' }}>White</option>
                            <option value="Elevator" {{ old('background') == 'Elevator' ? 'selected' : '' }}>Elevator</option>
                            <option value="Red Box"  {{ old('background') == 'Red Box'  ? 'selected' : '' }}>Red Box</option>
                            <option value="Grey"     {{ old('background') == 'Grey'     ? 'selected' : '' }}>Grey</option>
                        </select>
                    </div>

                    {{-- MINI CALENDAR --}}
                    <div class="mb-2">
                        <label class="form-label fw-bold d-block mb-2">Pilih Tanggal</label>
                        <div class="res-calendar-wrap">
                            <div class="cal-header">
                                <button type="button" id="cal-prev" title="Bulan sebelumnya">&#8249;</button>
                                <span id="cal-title" style="font-weight:600; font-size:14px;"></span>
                                <button type="button" id="cal-next" title="Bulan berikutnya">&#8250;</button>
                            </div>
                            <div class="cal-grid" id="cal-daynames">
                                @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $d)
                                    <div class="cal-dayname">{{ $d }}</div>
                                @endforeach
                            </div>
                            <div class="cal-grid" id="cal-days"></div>
                            <div class="cal-legend">
                                <span><span class="dot" style="background:#dcfce7;border:1px solid #16a34a;"></span> Tersedia</span>
                                <span><span class="dot" style="background:#fef9c3;border:1px solid #b45309;"></span> Sebagian terisi</span>
                                <span><span class="dot" style="background:#fee2e2;border:1px solid #c0392b;"></span> Penuh</span>
                            </div>
                        </div>
                        <input type="hidden" name="reservation_date" id="reservation_date" value="{{ old('reservation_date') }}" required>
                        <div id="selected-date-label" class="small text-muted mt-1"></div>
                    </div>

                    {{-- TIME SLOT PICKER --}}
                    <div class="time-slot-section mb-4" id="slot-section" style="display:none;">
                        <label>Pilih Jam Sesi</label>
                        <div id="slot-grid-container">
                            <div class="slot-loading"><i class="fas fa-spinner fa-spin me-1"></i> Memuat slot...</div>
                        </div>
                        <input type="hidden" name="reservation_time" id="reservation_time" value="{{ old('reservation_time') }}" required>
                    </div>

                    {{-- Jumlah Orang & Catatan --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Orang</label>
                        <input type="number" name="head_count" class="form-control" min="1"
                            value="{{ old('head_count', 1) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="3"
                            placeholder="Contoh: Request khusus, dll.">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3" id="submit-btn" style="min-height:52px;">
                        Kirim Reservasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const TIME_SLOTS = ['10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00'];
    const MONTHS_ID  = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

    let curYear    = new Date().getFullYear();
    let curMonth   = new Date().getMonth() + 1; // 1-indexed
    let statusMap  = {};  // { 'YYYY-MM-DD': 'full'|'partial'|'available' }
    let selectedDate = document.getElementById('reservation_date').value || '';
    let selectedTime = document.getElementById('reservation_time').value || '';

    const calDays    = document.getElementById('cal-days');
    const calTitle   = document.getElementById('cal-title');
    const slotSection= document.getElementById('slot-section');
    const slotCont   = document.getElementById('slot-grid-container');
    const dateInput  = document.getElementById('reservation_date');
    const timeInput  = document.getElementById('reservation_time');
    const dateLabel  = document.getElementById('selected-date-label');

    async function fetchCalendar(y, m) {
        calDays.innerHTML = '<div class="slot-loading" style="grid-column:1/-1"><i class="fas fa-spinner fa-spin me-1"></i>Memuat...</div>';
        try {
            const res = await fetch(`/reservasi/calendar?year=${y}&month=${m}`);
            const json = await res.json();
            statusMap = json.dates || {};
        } catch(e) { statusMap = {}; }
        renderCalendar(y, m);
    }

    function renderCalendar(y, m) {
        calTitle.textContent = MONTHS_ID[m-1] + ' ' + y;
        const today    = new Date(); today.setHours(0,0,0,0);
        const firstDay = new Date(y, m-1, 1).getDay(); // 0=Sunday
        const daysInM  = new Date(y, m, 0).getDate();

        let html = '';
        // Empty cells for first week
        for (let i = 0; i < firstDay; i++) html += '<div class="cal-day empty"></div>';

        for (let d = 1; d <= daysInM; d++) {
            const dateStr = `${y}-${String(m).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const thisDate = new Date(y, m-1, d);
            let cls = 'cal-day';
            let attr = `data-date="${dateStr}"`;

            if (thisDate < today) {
                cls += ' past'; attr += ' title="Tanggal sudah lewat"';
            } else if (statusMap[dateStr] === 'full') {
                cls += ' full'; attr += ' title="Semua slot sudah penuh"';
            } else if (statusMap[dateStr] === 'partial') {
                cls += ' partial available'; attr += ' title="Sebagian slot tersedia"';
            } else {
                cls += ' available'; attr += ' title="Tersedia"';
            }

            if (dateStr === selectedDate) cls += ' selected';

            html += `<div class="${cls}" ${attr}>${d}</div>`;
        }

        calDays.innerHTML = html;

        // Click handlers
        calDays.querySelectorAll('.cal-day.available').forEach(el => {
            el.addEventListener('click', () => selectDate(el.dataset.date));
        });
    }

    function selectDate(dateStr) {
        selectedDate = dateStr;
        dateInput.value = dateStr;

        // Update label
        const [y, m, d] = dateStr.split('-');
        dateLabel.textContent = `📅 Dipilih: ${parseInt(d)} ${MONTHS_ID[parseInt(m)-1]} ${y}`;

        // Update calendar highlight
        calDays.querySelectorAll('.cal-day').forEach(el => {
            el.classList.toggle('selected', el.dataset.date === dateStr);
        });

        // Reset time
        selectedTime = '';
        timeInput.value = '';
        slotSection.style.display = 'block';
        fetchSlots(dateStr);
    }

    async function fetchSlots(dateStr) {
        slotCont.innerHTML = '<div class="slot-loading"><i class="fas fa-spinner fa-spin me-1"></i> Memuat slot jam...</div>';
        try {
            const res  = await fetch(`/reservasi/slots?date=${dateStr}`);
            const json = await res.json();
            renderSlots(json.booked_times || []);
        } catch(e) {
            slotCont.innerHTML = '<div class="slot-loading text-danger">Gagal memuat slot. Coba lagi.</div>';
        }
    }

    function renderSlots(booked) {
        let html = '<div class="slot-grid">';
        TIME_SLOTS.forEach(t => {
            const isBooked = booked.includes(t);
            const isSelected = t === selectedTime;
            let cls = 'slot-btn' + (isBooked ? ' booked' : '') + (isSelected ? ' selected' : '');
            const attr = isBooked ? 'disabled title="Sudah terisi"' : `data-time="${t}"`;
            html += `<button type="button" class="${cls}" ${attr}>${t}<br><small>WIB</small></button>`;
        });
        html += '</div>';
        slotCont.innerHTML = html;

        slotCont.querySelectorAll('.slot-btn:not(.booked)').forEach(btn => {
            btn.addEventListener('click', () => {
                selectedTime = btn.dataset.time;
                timeInput.value = selectedTime;
                slotCont.querySelectorAll('.slot-btn').forEach(b => b.classList.remove('selected'));
                btn.classList.add('selected');
            });
        });
    }

    // Month navigation
    document.getElementById('cal-prev').addEventListener('click', () => {
        curMonth--; if (curMonth < 1) { curMonth = 12; curYear--; }
        fetchCalendar(curYear, curMonth);
    });
    document.getElementById('cal-next').addEventListener('click', () => {
        curMonth++; if (curMonth > 12) { curMonth = 1; curYear++; }
        fetchCalendar(curYear, curMonth);
    });

    // Init
    fetchCalendar(curYear, curMonth);

    // If old value exists, show slot section
    if (selectedDate) {
        slotSection.style.display = 'block';
        fetchSlots(selectedDate);
        const [y, m, d] = selectedDate.split('-');
        dateLabel.textContent = `📅 Dipilih: ${parseInt(d)} ${MONTHS_ID[parseInt(m)-1]} ${y}`;
    }

    // Form validation: pastikan tanggal & jam dipilih
    document.getElementById('reservation-form').addEventListener('submit', function(e) {
        if (!dateInput.value) {
            e.preventDefault();
            alert('Silakan pilih tanggal dari kalender.');
            return;
        }
        if (!timeInput.value) {
            e.preventDefault();
            alert('Silakan pilih jam sesi.');
            return;
        }
    });
})();
</script>
@endsection

@extends('admin.layouts.app')

@section('title', 'Daftar Reservasi - Sejenak Studio')

@section('content')
    <style>
        /* === ADMIN CALENDAR === */
        .admin-cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #137887;
            color: #fff;
            padding: 14px 20px;
            border-radius: 12px 12px 0 0;
        }

        .admin-cal-header button {
            background: rgba(255, 255, 255, .18);
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 18px;
            line-height: 1;
            transition: background .2s;
        }

        .admin-cal-header button:hover {
            background: rgba(255, 255, 255, .35);
        }

        .admin-cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border: 1px solid #e5e7eb;
            border-top: none;
        }

        .admin-cal-dayname {
            text-align: center;
            padding: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: #5d7d82;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }

        .admin-cal-cell {
            min-height: 90px;
            padding: 6px;
            border-bottom: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            background: #fff;
            vertical-align: top;
            font-size: 12px;
            overflow: hidden;
        }

        .admin-cal-cell.empty {
            background: #f9fafb;
        }

        .admin-cal-cell.today {
            background: #fffbeb;
        }

        .admin-cal-datenum {
            font-size: 13px;
            font-weight: 700;
            color: #137887;
            margin-bottom: 4px;
        }

        .admin-cal-cell.today .admin-cal-datenum {
            background: #137887;
            color: #fff;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .res-chip {
            display: block;
            margin-bottom: 3px;
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: opacity .15s;
        }

        .res-chip:hover {
            opacity: .8;
        }

        .chip-pending {
            background: #fef9c3;
            color: #854d0e;
        }

        .chip-confirmed {
            background: #dcfce7;
            color: #14532d;
        }

        .chip-completed {
            background: #dbeafe;
            color: #1e3a8a;
        }

        .chip-cancelled {
            background: #fee2e2;
            color: #7f1d1d;
        }

        /* Day view */
        #day-view-container {
            display: none;
        }

        .day-timeline {
            list-style: none;
            padding: 0;
        }

        .day-slot-row {
            display: flex;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            align-items: center;
        }

        .day-slot-time {
            width: 60px;
            font-weight: 700;
            font-size: 13px;
            color: #137887;
            flex-shrink: 0;
        }

        .day-slot-badge {
            display: inline-block;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }

        .day-slot-empty {
            color: #9ca3af;
            font-size: 12px;
            font-style: italic;
        }

        /* Modal detail */
        #res-detail-modal .modal-header {
            background: #137887;
            color: #fff;
            border-radius: 12px 12px 0 0;
        }

        #res-detail-modal .modal-header .btn-close {
            filter: invert(1);
        }

        @media (max-width: 768px) {
            .admin-cal-cell {
                min-height: 56px;
            }

            .res-chip {
                font-size: 9px;
                padding: 1px 4px;
            }
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold" style="color: #007A75;">Daftar Reservasi</h3>
    </div>

    {{-- TABS --}}
    <ul class="nav nav-tabs mb-4" id="resTabs">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-list">
                <i class="fas fa-list me-1"></i> Daftar
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-calendar" id="tab-cal-btn">
                <i class="fas fa-calendar-alt me-1"></i> Kalender
            </button>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ===== TAB LIST ===== --}}
        <div class="tab-pane fade show active" id="tab-list">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="text-secondary">#ID</th>
                                <th class="text-secondary">Pelanggan</th>
                                <th class="text-secondary">Paket</th>
                                <th class="text-secondary">Jadwal</th>
                                <th class="text-secondary">Status</th>
                                <th class="text-secondary">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $res)
                                <tr>
                                    <td class="text-muted fw-bold">#{{ $res->id }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $res->name }}</div>
                                        <div class="small text-muted"><i
                                                class="fab fa-whatsapp text-success me-1"></i>{{ $res->phone }}</div>
                                    </td>
                                    <td><span class="badge"
                                            style="background:#00A99D;">{{ $res->servicePackage->name }}</span></td>
                                    <td>
                                        <i
                                            class="far fa-calendar-alt text-muted me-1"></i>{{ $res->reservation_date->format('d M Y') }}<br>
                                        <i class="far fa-clock text-muted me-1"></i>{{ $res->reservation_time }} WIB
                                    </td>
                                    <td>
                                        @if ($res->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($res->status == 'confirmed')
                                            <span class="badge bg-success">Confirmed</span>
                                        @elseif($res->status == 'completed')
                                            <span class="badge bg-primary">Completed</span>
                                        @elseif($res->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.reservations.edit', $res->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3"><i
                                                class="fas fa-edit me-1"></i>Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-calendar-times fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-0">Belum ada data reservasi pelanggan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== TAB CALENDAR ===== --}}
        <div class="tab-pane fade" id="tab-calendar">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- Calendar Header --}}
                <div class="admin-cal-header">
                    <button type="button" id="adm-cal-prev">&#8249;</button>
                    <div>
                        <div id="adm-cal-title" style="font-weight:700; font-size:16px;"></div>
                        <div id="adm-cal-subtitle" style="font-size:11px; opacity:.8;"></div>
                    </div>
                    <button type="button" id="adm-cal-next">&#8250;</button>
                </div>

                {{-- Day Names --}}
                <div class="admin-cal-grid" id="adm-daynames">
                    @foreach (['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $d)
                        <div class="admin-cal-dayname">{{ $d }}</div>
                    @endforeach
                </div>

                {{-- Calendar Days --}}
                <div class="admin-cal-grid" id="adm-cal-cells">
                    <div style="grid-column:1/-1; text-align:center; padding:24px; color:#9ca3af;">
                        <i class="fas fa-spinner fa-spin me-2"></i>Memuat...
                    </div>
                </div>

                <div class="p-3" style="font-size:11px; color:#5d7d82; border-top:1px solid #e5e7eb;">
                    <span class="me-3"><span
                            style="display:inline-block;width:10px;height:10px;background:#fef9c3;border:1px solid #b45309;border-radius:2px;margin-right:4px;"></span>Pending</span>
                    <span class="me-3"><span
                            style="display:inline-block;width:10px;height:10px;background:#dcfce7;border:1px solid #14532d;border-radius:2px;margin-right:4px;"></span>Confirmed</span>
                    <span class="me-3"><span
                            style="display:inline-block;width:10px;height:10px;background:#dbeafe;border:1px solid #1e3a8a;border-radius:2px;margin-right:4px;"></span>Completed</span>
                    <span><span
                            style="display:inline-block;width:10px;height:10px;background:#fee2e2;border:1px solid #7f1d1d;border-radius:2px;margin-right:4px;"></span>Cancelled</span>
                </div>
            </div>

            {{-- Day View --}}
            <div id="day-view-container" class="card border-0 shadow-sm rounded-4 p-4 mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0" id="day-view-title" style="color:#137887;"></h6>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill" id="close-day-view">✕ Tutup</button>
                </div>
                <ul class="day-timeline" id="day-timeline"></ul>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div class="modal fade" id="res-detail-modal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content rounded-4 border-0">
                <div class="modal-header">
                    <h6 class="modal-title fw-bold mb-0">Detail Reservasi</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-body-content" style="font-size:13px;"></div>
                <div class="modal-footer">
                    <a id="modal-edit-link" href="#" class="btn btn-sm"
                        style="background:#137887;color:#fff;">Edit Status</a>
                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const TIMES = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00',
                '20:00', '21:00'
            ];

            let year = new Date().getFullYear();
            let month = new Date().getMonth() + 1;
            let allRes = [];

            const cells = document.getElementById('adm-cal-cells');
            const title = document.getElementById('adm-cal-title');
            const subtitle = document.getElementById('adm-cal-subtitle');
            const dayView = document.getElementById('day-view-container');
            const dayTitle = document.getElementById('day-view-title');
            const timeline = document.getElementById('day-timeline');

            async function fetchData(y, m) {
                cells.innerHTML =
                    '<div style="grid-column:1/-1;text-align:center;padding:24px;color:#9ca3af;"><i class="fas fa-spinner fa-spin me-2"></i>Memuat...</div>';
                try {
                    const res = await fetch(`/admin/reservasi/calendar-data?year=${y}&month=${m}`);
                    const json = await res.json();
                    allRes = json.reservations || [];
                } catch (e) {
                    allRes = [];
                }
                render(y, m);
            }

            function render(y, m) {
                title.textContent = MONTHS[m - 1] + ' ' + y;
                const totalRes = allRes.length;
                subtitle.textContent = totalRes + ' reservasi bulan ini';

                const today = new Date();
                today.setHours(0, 0, 0, 0);
                const firstDay = new Date(y, m - 1, 1).getDay();
                const daysInM = new Date(y, m, 0).getDate();

                // Group by date
                const byDate = {};
                allRes.forEach(r => {
                    if (!byDate[r.date]) byDate[r.date] = [];
                    byDate[r.date].push(r);
                });

                let html = '';
                for (let i = 0; i < firstDay; i++) html += '<div class="admin-cal-cell empty"></div>';

                for (let d = 1; d <= daysInM; d++) {
                    const dateStr = `${y}-${String(m).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
                    const dt = new Date(y, m - 1, d);
                    const isToday = dt.toDateString() === today.toDateString();
                    const items = byDate[dateStr] || [];

                    html +=
                        `<div class="admin-cal-cell ${isToday ? 'today' : ''}" data-date="${dateStr}" style="cursor:${items.length?'pointer':'default'}">`;
                    html += `<div class="admin-cal-datenum">${d}</div>`;
                    items.slice(0, 3).forEach(r => {
                        html +=
                            `<span class="res-chip chip-${r.status}" data-id="${r.id}" title="${r.name} • ${r.time}">${r.name.split(' ')[0]} • ${r.time}</span>`;
                    });
                    if (items.length > 3) html +=
                        `<span style="font-size:9px;color:#9ca3af;">+${items.length-3} lagi</span>`;
                    html += '</div>';
                }

                cells.innerHTML = html;

                // Click on date → day view
                cells.querySelectorAll('.admin-cal-cell:not(.empty)').forEach(cell => {
                    cell.addEventListener('click', (e) => {
                        if (e.target.classList.contains('res-chip')) return; // handled by chip
                        showDayView(cell.dataset.date, byDate[cell.dataset.date] || []);
                    });
                });

                // Click on chip → show detail modal
                cells.querySelectorAll('.res-chip').forEach(chip => {
                    chip.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const r = allRes.find(x => x.id == chip.dataset.id);
                        if (r) showModal(r);
                    });
                });
            }

            function showDayView(dateStr, items) {
                const [y, m, d] = dateStr.split('-');
                dayTitle.textContent = `📅 ${parseInt(d)} ${MONTHS[parseInt(m)-1]} ${y} — ${items.length} Reservasi`;
                dayView.style.display = 'block';
                dayView.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });

                let html = '';
                TIMES.forEach(t => {
                    const r = items.find(x => x.time === t);
                    html += `<li class="day-slot-row">
                <div class="day-slot-time">${t}</div>
                <div style="flex:1">`;
                    if (r) {
                        html +=
                            `<span class="day-slot-badge chip-${r.status}" data-id="${r.id}" style="cursor:pointer">${r.name} — ${r.package || '-'} (${r.count} org)</span>`;
                    } else {
                        html += `<span class="day-slot-empty">Tersedia</span>`;
                    }
                    html += `</div></li>`;
                });
                timeline.innerHTML = html;

                timeline.querySelectorAll('.day-slot-badge').forEach(b => {
                    b.addEventListener('click', () => {
                        const r = allRes.find(x => x.id == b.dataset.id);
                        if (r) showModal(r);
                    });
                });
            }

            function showModal(r) {
                const statusMap = {
                    pending: '⏳ Pending',
                    confirmed: '✅ Confirmed',
                    completed: '📷 Completed',
                    cancelled: '❌ Cancelled'
                };
                document.getElementById('modal-body-content').innerHTML = `
            <table class="table table-sm table-borderless mb-0">
                <tr><td class="text-muted">Nama</td><td><b>${r.name}</b></td></tr>
                <tr><td class="text-muted">Paket</td><td>${r.package||'-'}</td></tr>
                <tr><td class="text-muted">Background</td><td>${r.background||'-'}</td></tr>
                <tr><td class="text-muted">Tanggal</td><td>${r.date}</td></tr>
                <tr><td class="text-muted">Jam</td><td>${r.time} WIB</td></tr>
                <tr><td class="text-muted">Jml Orang</td><td>${r.count} orang</td></tr>
                <tr><td class="text-muted">Status</td><td>${statusMap[r.status]||r.status}</td></tr>
                ${r.notes ? `<tr><td class="text-muted">Catatan</td><td>${r.notes}</td></tr>` : ''}
                <tr><td class="text-muted">No. WA</td><td><a href="https://wa.me/${r.phone}" target="_blank">${r.phone}</a></td></tr>
            </table>`;
                document.getElementById('modal-edit-link').href = '/admin/reservasi/' + r.id + '/edit';
                bootstrap.Modal.getOrCreateInstance(document.getElementById('res-detail-modal')).show();
            }

            document.getElementById('adm-cal-prev').addEventListener('click', () => {
                month--;
                if (month < 1) {
                    month = 12;
                    year--;
                }
                dayView.style.display = 'none';
                fetchData(year, month);
            });
            document.getElementById('adm-cal-next').addEventListener('click', () => {
                month++;
                if (month > 12) {
                    month = 1;
                    year++;
                }
                dayView.style.display = 'none';
                fetchData(year, month);
            });
            document.getElementById('close-day-view').addEventListener('click', () => {
                dayView.style.display = 'none';
            });

            // Load calendar when tab is clicked
            document.getElementById('tab-cal-btn').addEventListener('click', () => {
                if (!allRes.length) fetchData(year, month);
            });
        })();
    </script>
@endsection

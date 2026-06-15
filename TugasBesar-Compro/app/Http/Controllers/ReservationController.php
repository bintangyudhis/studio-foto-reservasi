<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ServicePackage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /** Semua slot jam yang tersedia */
    const TIME_SLOTS = ['10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00'];

    /**
     * Menampilkan form reservasi.
     */
    public function index()
    {
        $packages = ServicePackage::all();
        return view('reservasi.index', compact('packages'));
    }

    /**
     * Menyimpan data reservasi baru.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'               => 'required|string|max:255',
                'phone'              => 'required|string|max:20',
                'service_package_id' => 'required|exists:service_packages,id',
                'background'         => 'required|string',
                'reservation_date'   => 'required|date|after_or_equal:today',
                'reservation_time'   => 'required',
                'head_count'         => 'required|integer|min:1',
                'notes'              => 'nullable|string',
            ]);

            // Cek bentrok jadwal (Tanggal + Jam sama, status pending/confirmed)
            $isConflict = Reservation::where('reservation_date', $request->reservation_date)
                ->where('reservation_time', $request->reservation_time)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if ($isConflict) {
                return back()->withErrors(['reservation_time' => 'Maaf, jadwal pada tanggal dan jam tersebut sudah terisi. Silakan pilih waktu lain.'])->withInput();
            }

            // Cek kapasitas orang
            $package = ServicePackage::find($request->service_package_id);
            if ($request->head_count > $package->max_people) {
                return back()->withErrors(['head_count' => "Jumlah orang melebihi kapasitas paket ({$package->max_people} orang)."])->withInput();
            }

            // Simpan ke database
            Reservation::create([
                'name'               => $request->name,
                'phone'              => $request->phone,
                'service_package_id' => $request->service_package_id,
                'background'         => $request->background,
                'reservation_date'   => $request->reservation_date,
                'reservation_time'   => $request->reservation_time,
                'head_count'         => $request->head_count,
                'notes'              => $request->notes,
                'status'             => 'pending',
            ]);

            $waMessage = "Halo admin Sejenak Studio! Saya ingin mengonfirmasi reservasi saya:\n\n"
                       . "Nama: {$request->name}\n"
                       . "Paket: {$package->name}\n"
                       . "Background: {$request->background}\n"
                       . "Tanggal: " . Carbon::parse($request->reservation_date)->format('d F Y') . "\n"
                       . "Jam: {$request->reservation_time} WIB\n"
                       . "Jumlah Orang: {$request->head_count} Orang\n";

            if ($request->notes) {
                $waMessage .= "Catatan: {$request->notes}\n";
            }

            $waLink = "https://wa.me/6285878059861?text=" . urlencode($waMessage);

            return redirect()->route('reservasi.success')->with('wa_link', $waLink);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // Re-throw agar Laravel menangani redirect balik ke form
        } catch (\Exception $e) {
            \Log::error('Reservasi error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan, silakan coba lagi atau hubungi admin.')->withInput();
        }
    }

    public function success()
    {
        $waLink = session('wa_link', 'https://wa.me/6285878059861');
        return view('reservasi.success', compact('waLink'));
    }

    /**
     * AJAX: Ambil slot jam yang sudah terbooked pada tanggal tertentu.
     * GET /reservasi/slots?date=YYYY-MM-DD
     * Response: { "booked_times": ["10:00", "14:00"] }
     */
    public function getSlots(Request $request)
    {
        $date = $request->query('date');

        if (!$date || !strtotime($date)) {
            return response()->json(['booked_times' => []]);
        }

        $booked = Reservation::where('reservation_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('reservation_time')
            ->map(fn($t) => substr($t, 0, 5)) // format HH:MM
            ->toArray();

        return response()->json(['booked_times' => $booked]);
    }

    /**
     * AJAX: Status ketersediaan per hari dalam satu bulan.
     * GET /reservasi/calendar?year=YYYY&month=MM
     * Response: { "dates": { "2025-06-10": "full", "2025-06-15": "partial", "2025-06-20": "available" } }
     */
    public function getCalendar(Request $request)
    {
        $year  = (int) $request->query('year',  date('Y'));
        $month = (int) $request->query('month', date('m'));
        $totalSlots = count(self::TIME_SLOTS);

        // Ambil semua reservasi di bulan ini
        $reservations = Reservation::whereYear('reservation_date', $year)
            ->whereMonth('reservation_date', $month)
            ->whereIn('status', ['pending', 'confirmed'])
            ->select('reservation_date', 'reservation_time')
            ->get();

        // Group by tanggal → hitung slot terisi
        $grouped = $reservations->groupBy(fn($r) => Carbon::parse($r->reservation_date)->format('Y-m-d'));

        $dates = [];
        foreach ($grouped as $dateStr => $items) {
            $booked = $items->count();
            if ($booked >= $totalSlots) {
                $dates[$dateStr] = 'full';
            } elseif ($booked > 0) {
                $dates[$dateStr] = 'partial';
            } else {
                $dates[$dateStr] = 'available';
            }
        }

        return response()->json(['dates' => $dates]);
    }
}

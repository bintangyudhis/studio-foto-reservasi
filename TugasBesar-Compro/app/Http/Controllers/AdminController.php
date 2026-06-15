<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ServicePackage;
use App\Models\Gallery;
use App\Models\Faq;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard statistik sederhana.
     */
    public function index()
    {
        $stats = [
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'confirmed_reservations' => Reservation::where('status', 'confirmed')->count(),
            'total_packages' => ServicePackage::count(),
        ];

        $recentReservations = Reservation::with('servicePackage')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentReservations'));
    }

    // --- RESERVATION MANAGEMENT ---

    /**
     * AJAX: Data kalender reservasi untuk admin.
     * GET /admin/reservasi/calendar-data?year=YYYY&month=MM
     */
    public function calendarData(Request $request)
    {
        $year  = (int) $request->query('year',  date('Y'));
        $month = (int) $request->query('month', date('m'));

        $reservations = Reservation::with('servicePackage')
            ->whereYear('reservation_date', $year)
            ->whereMonth('reservation_date', $month)
            ->orderBy('reservation_date')
            ->orderBy('reservation_time')
            ->get()
            ->map(fn($r) => [
                'id'      => $r->id,
                'name'    => $r->name,
                'phone'   => $r->phone,
                'package' => optional($r->servicePackage)->name,
                'background' => $r->background,
                'date'    => Carbon::parse($r->reservation_date)->format('Y-m-d'),
                'time'    => substr($r->reservation_time, 0, 5),
                'count'   => $r->head_count,
                'status'  => $r->status,
                'notes'   => $r->notes,
            ]);

        return response()->json(['reservations' => $reservations]);
    }

    public function reservations()
    {
        $reservations = Reservation::with('servicePackage')->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function editReservation(Reservation $reservation)
    {
        return view('admin.reservations.edit', compact('reservation'));
    }

    public function updateReservationStatus(Request $request, Reservation $reservation)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,completed,cancelled']);
        $reservation->update(['status' => $request->status]);

        return back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function destroyReservation(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations')->with('success', 'Reservasi berhasil dihapus.');
    }

    // --- PACKAGE MANAGEMENT ---
    public function packages()
    {
        $packages = ServicePackage::all();
        return view('admin.packages.index', compact('packages'));
    }

    public function createPackage()
    {
        return view('admin.packages.create');
    }

    public function storePackage(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'max_people' => 'required|integer',
        ]);

        ServicePackage::create($data);
        return redirect()->route('admin.packages')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function editPackage(ServicePackage $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function updatePackage(Request $request, ServicePackage $package)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'max_people' => 'required|integer',
        ]);

        $package->update($data);
        return redirect()->route('admin.packages')->with('success', 'Paket berhasil diperbarui.');
    }

    public function deletePackage(ServicePackage $package)
    {
        $package->delete();
        return redirect()->route('admin.packages')->with('success', 'Paket berhasil dihapus.');
    }

    // --- FAQ MANAGEMENT ---
    public function faqs()
    {
        $faqs = Faq::all();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        Faq::create($data);
        return back()->with('success', 'FAQ / Informasi berhasil ditambahkan.');
    }

    public function editFaq(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function updateFaq(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);

        $faq->update($data);
        return redirect()->route('admin.faqs')->with('success', 'FAQ berhasil diubah.');
    }

    public function deleteFaq(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ berhasil dihapus.');
    }

    // --- GALLERY MANAGEMENT ---
    public function galleries()
    {
        $galleries = Gallery::all();
        // Pakai list paket unik untuk kategori filter
        $categories = ServicePackage::pluck('name')->toArray();
        return view('admin.galleries.index', compact('galleries', 'categories'));
    }

    public function storeGallery(Request $request)
    {
        $data = $request->validate([
            'title'    => 'nullable|string',
            'category' => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,jpg,png,webp|max:20480', // maks 20MB
        ]);

        $categoryCount = Gallery::where('category', $request->category)->count();
        if ($categoryCount >= 5) {
            return back()->withErrors(['Kategori ' . $request->category . ' sudah mencapai batas maksimal 5 foto.']);
        }

        $data['title'] = $request->input('title', 'Gallery');

        if ($request->hasFile('image')) {
            $destination   = public_path('images/galleries');
            $data['image'] = $this->compressAndSaveImage($request->file('image'), $destination);
        } else {
            $data['image'] = 'default.png';
        }

        Gallery::create($data);
        return back()->with('success', 'Foto Galeri berhasil ditambah.');
    }

    /**
     * Compress & resize image using PHP GD (built-in).
     * - JPEG/WebP: quality 75
     * - PNG: compression level 7
     * - Resize if width > 1920px (maintain aspect ratio)
     */
    private function compressAndSaveImage(\Illuminate\Http\UploadedFile $file, string $destination): string
    {
        $maxWidth = 1920;
        $quality  = 75;
        $mime     = $file->getMimeType();
        $ext      = match(true) {
            str_contains($mime, 'png')  => 'png',
            str_contains($mime, 'webp') => 'webp',
            default                     => 'jpg',
        };
        $fileName = time() . '_' . uniqid() . '.' . $ext;
        $destPath = $destination . DIRECTORY_SEPARATOR . $fileName;

        $src = match(true) {
            str_contains($mime, 'png')  => @imagecreatefrompng($file->getRealPath()),
            str_contains($mime, 'webp') => @imagecreatefromwebp($file->getRealPath()),
            default                     => @imagecreatefromjpeg($file->getRealPath()),
        };

        if (!$src) {
            // GD failed — move file as-is
            $fallback = time() . '.' . $file->extension();
            $file->move($destination, $fallback);
            return $fallback;
        }

        $origW = imagesx($src);
        $origH = imagesy($src);

        if ($origW > $maxWidth) {
            $newW = $maxWidth;
            $newH = (int) round($origH * ($maxWidth / $origW));
            $dst  = imagecreatetruecolor($newW, $newH);
            if (str_contains($mime, 'png')) {
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
                imagefilledrectangle($dst, 0, 0, $newW, $newH,
                    imagecolorallocatealpha($dst, 255, 255, 255, 127));
            }
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
            imagedestroy($src);
            $src = $dst;
        }

        if (str_contains($mime, 'png')) {
            imagepng($src, $destPath, 7);
        } elseif (str_contains($mime, 'webp')) {
            imagewebp($src, $destPath, $quality);
        } else {
            imagejpeg($src, $destPath, $quality);
        }

        imagedestroy($src);
        return $fileName;
    }

    public function deleteGallery(Gallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Foto Galeri berhasil dihapus.');
    }


    // --- USER MANAGEMENT ---
    public function users()
    {
        $users = \App\Models\User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function deleteUser(\App\Models\User $user)
    {
        // Proteksi: tidak boleh hapus user dengan role admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak bisa menghapus akun admin!');
        }

        $user->delete();
        return back()->with('success', 'Akun pengguna berhasil dihapus.');
    }

    public function editUser(\App\Models\User $user)
    {
        // Hanya bisa edit user dengan role admin
        if ($user->role !== 'admin') {
            return back()->with('error', 'Hanya bisa edit data admin!');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, \App\Models\User $user)
    {
        // Hanya bisa edit user dengan role admin
        if ($user->role !== 'admin') {
            return back()->with('error', 'Hanya bisa edit data admin!');
        }

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->email = $validated['email'];
        if ($validated['password']) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Data admin berhasil diperbarui.');
    }

    // --- AUTHENTICATION ---
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            // Check apakah user yang login adalah admin
            if (auth()->user()->role !== 'admin') {
                auth()->logout();
                return back()->withErrors([
                    'email' => 'Anda tidak memiliki akses ke admin panel.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

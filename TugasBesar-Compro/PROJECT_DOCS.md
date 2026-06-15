# 📸 Sejenak Studio — Dokumentasi Proyek Lengkap

> **Sejenak Selfphoto Studio Purwokerto** — Platform company profile & sistem reservasi online untuk studio foto mandiri (self photo) di Purwokerto, Jawa Tengah.

---

## 🗂️ Daftar Isi

1. [Gambaran Umum](#gambaran-umum)
2. [Tech Stack](#tech-stack)
3. [Struktur Direktori](#struktur-direktori)
4. [Database & Model](#database--model)
5. [Halaman Publik (User)](#halaman-publik-user)
6. [Admin CMS](#admin-cms)
7. [Sistem Reservasi](#sistem-reservasi)
8. [Chatbot AI](#chatbot-ai)
9. [Design System & Warna](#design-system--warna)
10. [Routes Lengkap](#routes-lengkap)
11. [Cara Menjalankan](#cara-menjalankan)
12. [Akun Admin](#akun-admin)

---

## Gambaran Umum

Sejenak Studio adalah aplikasi web berbasis **Laravel 12** yang mencakup:

- **Company Profile** lengkap (beranda, profil, paket, galeri, informasi, kontak)
- **Sistem Reservasi Online** dengan validasi jadwal bentrok & integrasi WhatsApp
- **Admin CMS** untuk mengelola semua konten secara dinamis (paket, galeri, reservasi, FAQ)
- **Chatbot** berbasis algoritma Levenshtein untuk menjawab pertanyaan pengunjung

**Lokasi Studio:**

- Gg. Masjid, Mangunjaya, Purwokerto Tim., Kabupaten Banyumas, Jawa Tengah 53114
- Koordinat: `-7.419678, 109.250097`
- Instagram: `@sejenakselfphoto`
- WhatsApp Admin: `+62 858-7805-9861`
- Jam Operasional: **Setiap Hari, 10.00 – 21.00 WIB**

---

## Tech Stack

| Komponen  | Teknologi                                          |
| --------- | -------------------------------------------------- |
| Framework | Laravel 12 (PHP 8.3)                               |
| Database  | MySQL (`db_compro`)                                |
| Frontend  | Blade Template + Bootstrap 5.3                     |
| CSS       | Vanilla CSS (custom design system)                 |
| Icons     | Font Awesome 6.4                                   |
| Fonts     | Playfair Display (serif), Manrope (sans)           |
| Chatbot   | Algoritma Levenshtein (PHP native)                 |
| WhatsApp  | Redirect ke `wa.me` dengan template pesan otomatis |

---

## Struktur Direktori

```
TugasBesar-Compro/
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php       # CRUD semua konten admin
│   │   ├── AuthController.php        # Login/logout umum
│   │   ├── ChatbotController.php     # Logika chatbot Levenshtein
│   │   └── ReservationController.php # Proses reservasi publik
│   └── Models/
│       ├── Faq.php
│       ├── Gallery.php
│       ├── Reservation.php
│       ├── ServicePackage.php
│       └── User.php
├── database/
│   ├── migrations/                   # 10 file migrasi
│   └── seeders/
│       ├── AdminSeeder.php
│       ├── DatabaseSeeder.php
│       ├── FaqSeeder.php
│       ├── GallerySeeder.php
│       └── ServicePackageSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php         # Layout utama publik
│   ├── home.blade.php                # Beranda
│   ├── profil.blade.php              # Profil studio
│   ├── paket.blade.php               # Daftar paket lengkap
│   ├── galeri.blade.php              # Galeri foto
│   ├── informasi.blade.php           # FAQ / informasi
│   ├── chatbot.blade.php             # Halaman chatbot
│   ├── reservasi/
│   │   ├── index.blade.php           # Form reservasi
│   │   └── success.blade.php         # Halaman sukses + link WA
│   └── admin/
│       ├── layouts/app.blade.php     # Layout admin
│       ├── login.blade.php
│       ├── dashboard.blade.php
│       ├── reservations/             # Manajemen reservasi
│       ├── packages/                 # Manajemen paket
│       ├── galleries/                # Manajemen galeri
│       ├── faqs/                     # Manajemen FAQ
│       └── users/                    # Manajemen pengguna
├── public/
│   └── images/
│       └── galleries/               # Upload foto galeri (max 5/paket)
└── routes/web.php                    # Semua routing
```

---

## Database & Model

### Tabel `users`

| Kolom      | Tipe                  | Keterangan      |
| ---------- | --------------------- | --------------- |
| id         | bigint PK             |                 |
| name       | varchar               |                 |
| email      | varchar unique        |                 |
| username   | varchar unique        |                 |
| nomor_hp   | varchar               |                 |
| password   | varchar (hashed)      |                 |
| role       | enum: `admin`, `user` | Default: `user` |
| timestamps |                       |                 |

### Tabel `service_packages`

| Kolom       | Tipe      | Keterangan                                |
| ----------- | --------- | ----------------------------------------- |
| id          | bigint PK |                                           |
| name        | varchar   | Nama paket                                |
| description | text      | Deskripsi & fasilitas (dipisah tanda `-`) |
| price       | integer   | Harga (Rupiah)                            |
| max_people  | integer   | Kapasitas maksimal orang                  |
| timestamps  |           |                                           |

**Data Paket Saat Ini:**
| Nama | Harga | Kapasitas | Fasilitas Utama |
|---|---|---|---|
| Paket Berdua | Rp 35.000 | 2 orang | 5 mnt, 1 BG, soft file, Google Drive |
| Paket Senandung | Rp 50.000 | 4 orang | 10 mnt, 1 BG, soft file, 2 polaroid |
| Paket Memori | Rp 80.000 | 8 orang | 10 mnt, 1 BG, soft file, 6 polaroid |
| Paket Lembayung | Rp 100.000 | 8 orang | 15 mnt, 1 BG, soft file, 8 polaroid |

### Tabel `galleries`

| Kolom      | Tipe             | Keterangan                            |
| ---------- | ---------------- | ------------------------------------- |
| id         | bigint PK        |                                       |
| title      | varchar nullable | Judul foto                            |
| category   | varchar          | Nama paket (misal: "Paket Senandung") |
| image      | varchar          | Nama file gambar                      |
| timestamps |                  |                                       |

> **Aturan:** Maksimal **5 foto per kategori** (paket). Upload disimpan ke `public/images/galleries/`.

### Tabel `faqs`

| Kolom      | Tipe      | Keterangan |
| ---------- | --------- | ---------- |
| id         | bigint PK |            |
| question   | text      | Pertanyaan |
| answer     | text      | Jawaban    |
| timestamps |           |            |

### Tabel `reservations`

| Kolom              | Tipe                                                   | Keterangan                        |
| ------------------ | ------------------------------------------------------ | --------------------------------- |
| id                 | bigint PK                                              |                                   |
| name               | varchar                                                | Nama pemesan                      |
| phone              | varchar                                                | No. HP / WA                       |
| service_package_id | FK → service_packages                                  | Paket dipilih                     |
| background         | varchar                                                | White / Elevator / Red Box / Grey |
| reservation_date   | date                                                   | Tanggal sesi                      |
| reservation_time   | time                                                   | Jam sesi (10:00–21:00)            |
| head_count         | integer                                                | Jumlah orang                      |
| notes              | text nullable                                          | Catatan tambahan                  |
| status             | enum: `pending`, `confirmed`, `completed`, `cancelled` | Default: `pending`                |
| timestamps         |                                                        |                                   |

---

## Halaman Publik (User)

### 1. Beranda (`/`)

**Komponen Tampilan:**

- **Hero Section**: Banner teal dengan gambar galeri sebagai background blur + slideshow otomatis (interval 4.2 detik). Dibungkus dalam container dengan `border-radius: 24px` agar tidak mepet tepi layar. Padding 24px dari atas.
- **Quick Info Strip**: 4 kotak strip (Pilih jadwal → Datang santai → Foto mandiri → Terima file)
- **Paket Layanan**: Grid 4 kolom (col-lg-3) menampilkan SEMUA paket dari database — hanya nama, harga, dan tombol "Pilih Paket" (tanpa deskripsi detail)
- **Galeri Terbaru**: Grid masonry 4 kolom, menampilkan 5 foto terbaru dari database. Foto pertama span 2 kolom & 2 baris
- **Testimonials**: 3 kutipan pelanggan (statis)
- **CTA Section**: Latar gelap (teal), ajakan reservasi

**Data yang di-pass ke view:**

```php
$packages = ServicePackage::all();
$galleries = Gallery::latest()->take(6)->get();
```

---

### 2. Profil (`/profil`)

Halaman statis berisi profil studio: visi, misi, cerita pendirian, dan nilai-nilai brand Sejenak Studio.

---

### 3. Paket Layanan (`/paket`)

- Menampilkan semua paket dari database secara **dinamis**
- Setiap card paket menampilkan: nama, deskripsi lengkap (fasilitas per baris), harga, kapasitas, tombol "Pilih Paket"
- Perubahan harga/nama di Admin CMS **langsung tercermin** di halaman ini

---

### 4. Galeri Foto (`/galeri`)

- **Filter Kategori** (tombol pill): Semua | Berdua | Senandung | Memori | Lembayung
- Filter menggunakan JavaScript `includes()` — cocok meski nama di database diawali "Paket" (contoh: "Paket Senandung" cocok dengan filter "Senandung")
- Gambar ditampilkan dengan `aspect-ratio: 1/1; object-fit: cover` (grid persegi presisi)
- Fallback jika gambar tidak ada: placeholder via `onerror`

---

### 5. Informasi (`/informasi`)

- FAQ/informasi yang dikelola lewat Admin CMS
- Ditampilkan dalam format Accordion Bootstrap
- Data diambil dari tabel `faqs`

---

### 6. Kontak (`/kontak`)

- Peta Google Maps embed (koordinat: `-7.419678, 109.250097`)
- Alamat lengkap studio
- Informasi jam operasional & kontak

---

### 7. Chatbot (`/chatbot`)

- Chat UI modern (bubble chat)
- Menggunakan algoritma Levenshtein untuk mencocokkan pertanyaan dengan FAQ di database
- Threshold minimal: **25% kemiripan**
- Skor gabungan: 50% Levenshtein string penuh + 50% kecocokan per kata

---

### 8. Reservasi (`/reservasi`)

Lihat bagian [Sistem Reservasi](#sistem-reservasi) di bawah.

---

## Admin CMS

**URL:** `http://localhost:8000/admin`  
**Login:** `/admin/login`

### Navigasi Sidebar Admin

- 🏠 Dashboard
- 📅 Reservasi
- 📦 Paket Layanan
- 🖼️ Galeri Foto
- ❓ FAQ & Bot
- 👤 Keluar (Logout)

### Design Admin

- **Background sidebar**: `#137887` (teal gelap)
- **Teks sidebar**: putih
- **Tombol aktif sidebar**: latar `rgba(255,255,255,0.15)`
- **Warna aksen/tombol aksi**: `#FFD000` (kuning)
- **Tombol tambah**: kuning dengan teks gelap
- **Font**: Manrope

---

### Dashboard Admin

Menampilkan statistik:

- Total Reservasi
- Reservasi Pending
- Reservasi Confirmed
- Total Paket
- Tabel 5 reservasi terbaru

---

### Manajemen Reservasi (`/admin/reservasi`)

**Fitur:**

- Lihat semua reservasi (nama, paket, background, tanggal, jam, status)
- Ubah status: `pending` → `confirmed` → `completed` / `cancelled`
- Hapus reservasi

**Status Badge:**
| Status | Warna |
|---|---|
| pending | Kuning |
| confirmed | Hijau/Teal |
| completed | Biru |
| cancelled | Merah |

---

### Manajemen Paket (`/admin/packages`)

**Fitur CRUD:** Tambah, Edit, Hapus paket

**Form Paket** (tanpa foto — sesuai desain):

- Nama Paket
- Deskripsi / Fasilitas
- Harga (Rp)
- Kapasitas Maksimal (orang)

> ⚠️ Tidak ada upload foto di form paket. Tampilan paket di website hanya berupa card teks.

---

### Manajemen Galeri (`/admin/galleries`)

**Fitur:** Upload foto per kategori paket, Hapus foto

**Form Upload:**

- Kategori (dropdown dari nama paket di database)
- Upload file gambar

**Aturan Upload:**

- Maksimal **5 foto per kategori**
- File disimpan ke: `public/images/galleries/[timestamp].[ext]`
- Jika kategori sudah penuh (5 foto), upload diblokir dengan pesan error

---

### Manajemen FAQ & Bot (`/admin/faqs`)

**Fitur CRUD:** Tambah, Edit, Hapus FAQ

**Form FAQ:**

- Pertanyaan
- Jawaban

> FAQ yang ditambahkan di sini otomatis digunakan oleh chatbot.

---

### Manajemen Pengguna (`/admin/users`)

**Fitur:**

- Lihat semua user terdaftar
- Edit data admin (email & password)
- Hapus user (tidak bisa hapus admin)

---

## Sistem Reservasi

### Alur Reservasi (4 Langkah)

1. **Pilih Paket & Background** — Tentukan paket dan warna background
2. **Isi Formulir Booking** — Nama, WA, tanggal, jam, jumlah orang, catatan
3. **Konfirmasi via WhatsApp** — Diarahkan ke WA Admin dengan pesan otomatis
4. **Datang & Sesi Foto** — Setelah admin konfirmasi, datang ke studio

### Validasi Sistem

- **Bentrok jadwal**: Jika tanggal + jam sudah ada reservasi `pending`/`confirmed`, ditolak
- **Kapasitas**: Jika jumlah orang melebihi `max_people` paket, ditolak
- **Tanggal**: Tidak boleh tanggal lampau (`after_or_equal:today`)
- **Jam**: Pilihan tersedia dari 10:00 – 21:00 WIB (per jam)

### Background yang Tersedia

- White
- Elevator
- Red Box
- Grey

### Template Pesan WhatsApp Otomatis

```
Halo admin Sejenak Studio! Saya ingin mengonfirmasi reservasi saya:

Nama: [nama]
Paket: [nama paket]
Background: [background]
Tanggal: [dd MMMM YYYY]
Jam: [HH:mm] WIB
Jumlah Orang: [n] Orang
Catatan: [catatan jika ada]
```

Dikirim ke: **+62 858-7805-9861**

---

## Chatbot AI

### Algoritma: Levenshtein Distance Hybrid

```
Input user → normalisasi lowercase
    ↓
Cek sapaan? (halo/hai/hi/hello) → jawab sambutan
    ↓
Load semua FAQ dari database
    ↓
Untuk setiap FAQ:
  Skor A = Levenshtein string penuh (dinormalisasi 0–1)
  Skor B = Kecocokan per kata (word overlap, toleransi 1 typo/kata)
  Skor Gabungan = (A × 0.5) + (B × 0.5)
    ↓
Pilih FAQ dengan skor tertinggi
    ↓
Jika skor ≥ 0.25 → tampilkan jawaban FAQ
Jika skor < 0.25 → tampilkan pesan fallback
```

**Respons API:**

```json
{
    "reply": "...",
    "score": 0.432,
    "matched_faq": "Berapa harga paket foto?"
}
```

---

## Design System & Warna

### Palet Warna Utama

```css
:root {
    --ink: #137887; /* Teal — warna primer teks & elemen utama */
    --ink-deep: #0d6472; /* Teal gelap — hover & gradient */
    --paper: #fffaf0; /* Krem — background halaman */
    --paper-soft: #fff0c7; /* Kuning muda — aksen lembut */
    --white: #ffffff;
    --accent: #f7a900; /* Kuning emas — CTA & aksen */
    --accent-soft: #ffc841; /* Kuning terang — hover CTA */
    --muted: #5d7d82; /* Teal muted — teks sekunder */
    --line: rgba(19, 120, 135, 0.18); /* Border lembut */
    --line-strong: rgba(19, 120, 135, 0.34); /* Border medium */
    --photo: #e7d6b5; /* Cokelat muda — placeholder gambar */
}
```

### Tipografi

| Jenis | Font             | Kegunaan                           |
| ----- | ---------------- | ---------------------------------- |
| Serif | Playfair Display | Heading (h1–h5), harga, kutipan    |
| Sans  | Manrope          | Body text, label, tombol, navigasi |

### Border Radius

| Variabel        | Nilai | Digunakan pada         |
| --------------- | ----- | ---------------------- |
| `--radius-sm`   | 10px  | Form input             |
| `--radius-md`   | 16px  | Card, alert, badge     |
| `--radius-lg`   | 24px  | Hero card, galeri tile |
| `--radius-pill` | 999px | Tombol, badge bulat    |

### Tombol

| Kelas                  | Latar      | Border    | Teks      | Hover                  |
| ---------------------- | ---------- | --------- | --------- | ---------------------- |
| `.btn-primary`         | `#f7a900`  | `#f7a900` | `#0d6472` | `#ffc841`              |
| `.btn-outline-primary` | transparan | teal      | teal      | latar teal, teks putih |

### Animasi

- **Reveal on scroll**: Elemen masuk viewport → `opacity: 0 → 1` + `translateY(28px → 0)`, durasi 0.72s
- **Navbar shrink on scroll**: padding berkurang dari 18px → 11px, shadow muncul
- **Hero slideshow**: Interval 4.2 detik, transisi fade 0.9s + scale 1.025→1
- **Hover tombol**: `translateY(-2px)` durasi 0.24s
- **Card hover**: `translateY(-3px)` + border lebih gelap

### Navbar

- **Desain**: Sticky top (selalu terlihat saat scroll), background krem semi-transparan `rgba(255,250,240,.96)` dengan `backdrop-filter: blur(16px)`
- **Link**: uppercase, font-size 12px, letter-spacing 0.1em, warna muted → ink saat hover
- **Underline aktif**: animasi `scaleX` dari 0.35 → 1 dengan warna aksen kuning
- **CTA button**: tombol kuning "Reservasi Sekarang" di ujung kanan

---

## Routes Lengkap

### Publik

| Method | URL                 | Controller                    | Fungsi           |
| ------ | ------------------- | ----------------------------- | ---------------- |
| GET    | `/`                 | (closure)                     | Beranda          |
| GET    | `/profil`           | (closure)                     | Profil studio    |
| GET    | `/paket`            | (closure)                     | Daftar paket     |
| GET    | `/galeri`           | (closure)                     | Galeri foto      |
| GET    | `/informasi`        | (closure)                     | FAQ / informasi  |
| GET    | `/kontak`           | (closure)                     | Halaman kontak   |
| GET    | `/reservasi`        | ReservationController@index   | Form reservasi   |
| POST   | `/reservasi`        | ReservationController@store   | Simpan reservasi |
| GET    | `/reservasi/sukses` | ReservationController@success | Halaman sukses   |
| GET    | `/chatbot`          | ChatbotController@index       | Halaman chatbot  |
| POST   | `/chatbot/chat`     | ChatbotController@handle      | API chat (JSON)  |

### Admin (Memerlukan Auth + Role Admin)

| Method | URL                            | Controller                              | Fungsi           |
| ------ | ------------------------------ | --------------------------------------- | ---------------- |
| GET    | `/admin/login`                 | AdminController@showLoginForm           | Form login       |
| POST   | `/admin/login`                 | AdminController@login                   | Proses login     |
| POST   | `/admin/logout`                | AdminController@logout                  | Logout           |
| GET    | `/admin/dashboard`             | AdminController@index                   | Dashboard        |
| GET    | `/admin/reservasi`             | AdminController@reservations            | Daftar reservasi |
| PATCH  | `/admin/reservasi/{id}/status` | AdminController@updateReservationStatus | Update status    |
| DELETE | `/admin/reservasi/{id}`        | AdminController@destroyReservation      | Hapus reservasi  |
| GET    | `/admin/packages`              | AdminController@packages                | Daftar paket     |
| GET    | `/admin/packages/create`       | AdminController@createPackage           | Form tambah      |
| POST   | `/admin/packages`              | AdminController@storePackage            | Simpan paket     |
| GET    | `/admin/packages/{id}/edit`    | AdminController@editPackage             | Form edit        |
| PUT    | `/admin/packages/{id}`         | AdminController@updatePackage           | Update paket     |
| DELETE | `/admin/packages/{id}`         | AdminController@deletePackage           | Hapus paket      |
| GET    | `/admin/faqs`                  | AdminController@faqs                    | Daftar FAQ       |
| POST   | `/admin/faqs`                  | AdminController@storeFaq                | Tambah FAQ       |
| GET    | `/admin/faqs/{id}/edit`        | AdminController@editFaq                 | Form edit FAQ    |
| PUT    | `/admin/faqs/{id}`             | AdminController@updateFaq               | Update FAQ       |
| DELETE | `/admin/faqs/{id}`             | AdminController@deleteFaq               | Hapus FAQ        |
| GET    | `/admin/galleries`             | AdminController@galleries               | Daftar galeri    |
| POST   | `/admin/galleries`             | AdminController@storeGallery            | Upload foto      |
| DELETE | `/admin/galleries/{id}`        | AdminController@deleteGallery           | Hapus foto       |
| GET    | `/admin/users`                 | AdminController@users                   | Daftar user      |
| GET    | `/admin/users/{id}/edit`       | AdminController@editUser                | Form edit user   |
| PUT    | `/admin/users/{id}`            | AdminController@updateUser              | Update user      |
| DELETE | `/admin/users/{id}`            | AdminController@deleteUser              | Hapus user       |

---

## Cara Menjalankan

### Prasyarat

- PHP >= 8.2
- Composer
- MySQL
- Node.js

### Setup Awal

```bash
# Clone / masuk direktori
cd "d:\KULIAH\Semester 6\Computing Project\Tugas Besar -sc\TugasBesar-Compro"

# Install dependensi PHP
composer install

# Copy file environment
cp .env.example .env

# Set konfigurasi database di .env:
DB_DATABASE=db_compro
DB_USERNAME=root
DB_PASSWORD=

# Generate app key
php artisan key:generate

# Jalankan migrasi + seeder
php artisan migrate --seed

# Buat symlink storage
php artisan storage:link

# Buat folder galeri jika belum ada
mkdir -p public/images/galleries

# Jalankan server
php artisan serve
```

### Perintah Seeder

```bash
# Jalankan semua seeder
php artisan db:seed

# Reset + seed ulang
php artisan migrate:fresh --seed
```

---

## Akun Admin

| Email              | Password | Role  |
| ------------------ | -------- | ----- |
| admin@sejenak.com  | admin123 | admin |
| admin1@sejenak.com | admin123 | admin |
| admin2@sejenak.com | admin123 | admin |

> URL Login Admin: `http://localhost:8000/admin/login`

---

## Catatan Penting

1. **Foto Galeri** disimpan di `public/images/galleries/` — bukan di `storage/`. Tidak perlu `php artisan storage:link` untuk galeri.
2. **Batas upload galeri**: Maksimal 5 foto per kategori paket. Divalidasi di `AdminController@storeGallery`.
3. **Harga paket dinamis**: Perubahan harga di Admin CMS langsung tercermin di halaman `/paket` dan beranda karena menggunakan query database (`ServicePackage::all()`).
4. **Filter galeri**: Menggunakan `String.prototype.includes()` di JavaScript — sehingga filter "Senandung" akan cocok dengan kategori "Paket Senandung" di database.
5. **Chatbot FAQ**: Setiap FAQ yang ditambahkan lewat admin otomatis dapat digunakan oleh chatbot tanpa perlu konfigurasi tambahan.
6. **WhatsApp Admin**: Nomor terkonfigurasi di `ReservationController.php` — `+62 858-7805-9861`.
7. **Validasi bentrok reservasi**: Sistem hanya mengecek status `pending` dan `confirmed`. Reservasi `cancelled`/`completed` tidak dihitung sebagai bentrok.

---

_Dibuat untuk: Tugas Besar Mata Kuliah Computing Project, Semester 6_
_Studio: Sejenak Selfphoto Studio Purwokerto_

---

## 💻 Referensi Kode Lengkap

### `routes/web.php` — Semua Routing

```php
<?php
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Models\ServicePackage;
use App\Models\Gallery;

// PUBLIC ROUTES
Route::get('/', function () {
    $packages = ServicePackage::all();
    $galleries = Gallery::latest()->take(6)->get();
    return view('home', compact('packages', 'galleries'));
})->name('home');

Route::get('/profil', fn() => view('profil'))->name('profil');
Route::get('/paket', function () {
    return view('paket', ['packages' => ServicePackage::all()]);
})->name('paket');
Route::get('/galeri', function () {
    return view('galeri', ['galleries' => Gallery::all()]);
})->name('galeri');
Route::get('/informasi', fn() => view('informasi'))->name('informasi');
Route::redirect('/faq', '/informasi');
Route::redirect('/kontak', '/informasi')->name('kontak');

// RESERVASI (butuh login user)
Route::middleware('auth')->group(function () {
    Route::get('/reservasi', [ReservationController::class, 'index'])->name('reservasi.index');
    Route::post('/reservasi', [ReservationController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/sukses', [ReservationController::class, 'success'])->name('reservasi.success');
});

// AUTH USER
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// CHATBOT
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/chat', [ChatbotController::class, 'handle'])->name('chatbot.chat');

// ADMIN (prefix: /admin, middleware: auth + admin role)
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        // Reservasi
        Route::get('/reservasi', [AdminController::class, 'reservations'])->name('admin.reservations');
        Route::patch('/reservasi/{reservation}/status', [AdminController::class, 'updateReservationStatus'])->name('admin.reservations.status');
        Route::delete('/reservasi/{reservation}', [AdminController::class, 'destroyReservation'])->name('admin.reservations.destroy');
        // Paket
        Route::get('/packages', [AdminController::class, 'packages'])->name('admin.packages');
        Route::get('/packages/create', [AdminController::class, 'createPackage'])->name('admin.packages.create');
        Route::post('/packages', [AdminController::class, 'storePackage'])->name('admin.packages.store');
        Route::get('/packages/{package}/edit', [AdminController::class, 'editPackage'])->name('admin.packages.edit');
        Route::put('/packages/{package}', [AdminController::class, 'updatePackage'])->name('admin.packages.update');
        Route::delete('/packages/{package}', [AdminController::class, 'deletePackage'])->name('admin.packages.destroy');
        // FAQ
        Route::get('/faqs', [AdminController::class, 'faqs'])->name('admin.faqs');
        Route::post('/faqs', [AdminController::class, 'storeFaq'])->name('admin.faqs.store');
        Route::get('/faqs/{faq}/edit', [AdminController::class, 'editFaq'])->name('admin.faqs.edit');
        Route::put('/faqs/{faq}', [AdminController::class, 'updateFaq'])->name('admin.faqs.update');
        Route::delete('/faqs/{faq}', [AdminController::class, 'deleteFaq'])->name('admin.faqs.destroy');
        // Galeri
        Route::get('/galleries', [AdminController::class, 'galleries'])->name('admin.galleries');
        Route::post('/galleries', [AdminController::class, 'storeGallery'])->name('admin.galleries.store');
        Route::delete('/galleries/{gallery}', [AdminController::class, 'deleteGallery'])->name('admin.galleries.destroy');
        // Users
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.destroy');
    });
});
```

---

### `ReservationController.php` — Proses Reservasi

```php
public function store(Request $request)
{
    // Validasi input
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

    // Cek bentrok jadwal (tanggal + jam sama, status pending/confirmed)
    $isConflict = Reservation::where('reservation_date', $request->reservation_date)
        ->where('reservation_time', $request->reservation_time)
        ->whereIn('status', ['pending', 'confirmed'])
        ->exists();

    if ($isConflict) {
        return back()->withErrors(['reservation_time' => 'Maaf, jadwal sudah terisi. Pilih waktu lain.'])->withInput();
    }

    // Cek kapasitas paket
    $package = ServicePackage::find($request->service_package_id);
    if ($request->head_count > $package->max_people) {
        return back()->withErrors(['head_count' => "Melebihi kapasitas paket ({$package->max_people} orang)."])->withInput();
    }

    // Simpan reservasi (status default = pending)
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

    // Buat link WhatsApp otomatis
    $waMessage = "Halo admin Sejenak Studio! Saya ingin mengonfirmasi reservasi:\n\n"
               . "Nama: {$request->name}\n"
               . "Paket: {$package->name}\n"
               . "Background: {$request->background}\n"
               . "Tanggal: " . Carbon::parse($request->reservation_date)->format('d F Y') . "\n"
               . "Jam: {$request->reservation_time} WIB\n"
               . "Jumlah Orang: {$request->head_count} Orang\n";

    if ($request->notes) $waMessage .= "Catatan: {$request->notes}\n";

    $waLink = "https://wa.me/6285878059861?text=" . urlencode($waMessage);

    return redirect()->route('reservasi.success')->with('wa_link', $waLink);
}
```

---

### `AdminController.php` — Logika Upload Galeri (dengan batas 5 foto)

```php
public function storeGallery(Request $request)
{
    $data = $request->validate([
        'title'    => 'nullable|string',
        'category' => 'required|string',
        'image'    => 'nullable|image',
    ]);

    // Cek batas maksimal 5 foto per kategori
    $categoryCount = Gallery::where('category', $request->category)->count();
    if ($categoryCount >= 5) {
        return back()->withErrors(['Kategori ' . $request->category . ' sudah mencapai batas maksimal 5 foto.']);
    }

    $data['title'] = $request->input('title', 'Gallery');

    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/galleries'), $imageName);
        $data['image'] = $imageName;
    } else {
        $data['image'] = 'default.png';
    }

    Gallery::create($data);
    return back()->with('success', 'Foto Galeri berhasil ditambah.');
}
```

---

### `AuthController.php` — Login & Register User

```php
// REGISTER
public function register(Request $request)
{
    $validated = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'username' => 'required|string|unique:users,username',
        'nomor_hp' => 'required|string|min:10|max:15',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = User::create([...$validated, 'password' => Hash::make($validated['password'])]);
    Auth::login($user);
    return redirect()->route('home')->with('success', 'Akun berhasil dibuat!');
}

// LOGIN (via username, bukan email)
public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
        // Admin diblokir dari login user biasa
        if (Auth::user()->role === 'admin') {
            Auth::logout();
            return back()->withErrors(['username' => 'Admin harus login melalui admin panel.']);
        }
        $request->session()->regenerate();
        return redirect()->intended(route('reservasi.index'));
    }

    return back()->withErrors(['username' => 'Username atau password salah.']);
}
```

> **Catatan penting**: Login user biasa menggunakan **username**, bukan email. Login admin menggunakan **email** di `/admin/login`.

---

### `ChatbotController.php` — Algoritma Levenshtein

```php
public function handle(Request $request)
{
    $input = trim(strtolower($request->input('message', '')));

    // Cek sapaan
    $greetings = ['halo', 'hai', 'hi', 'hello', 'hei', 'hey', 'p', 'permisi'];
    foreach ($greetings as $greeting) {
        if (levenshtein($input, $greeting) <= 2) {
            return response()->json(['reply' => 'Halo! Selamat datang di Sejenak Studio 📸 Ada yang bisa saya bantu?']);
        }
    }

    $faqs = Faq::all();
    $bestMatch = null;
    $bestScore = 0.0;
    $inputWords = array_filter(explode(' ', $input), fn($w) => strlen($w) > 1);

    foreach ($faqs as $faq) {
        $question = strtolower($faq->question);

        // Skor A: Levenshtein string penuh (dinormalisasi 0-1)
        $levDistance   = levenshtein($input, $question);
        $maxLen        = max(strlen($input), strlen($question));
        $levSimilarity = $maxLen > 0 ? 1 - ($levDistance / $maxLen) : 0;

        // Skor B: Kecocokan per kata (toleransi 1 typo/kata)
        $qWords      = array_filter(explode(' ', $question), fn($w) => strlen($w) > 1);
        $wordMatches = 0;
        foreach ($inputWords as $iWord) {
            foreach ($qWords as $qWord) {
                if (levenshtein($iWord, $qWord) <= 1) { $wordMatches++; break; }
            }
        }
        $wordScore = count($inputWords) > 0 ? $wordMatches / count($inputWords) : 0;

        // Gabungkan 50:50
        $combinedScore = ($levSimilarity * 0.5) + ($wordScore * 0.5);
        if ($combinedScore > $bestScore) {
            $bestScore = $combinedScore;
            $bestMatch = $faq;
        }
    }

    // Threshold 25%
    $reply = ($bestMatch && $bestScore >= 0.25)
        ? $bestMatch->answer
        : "Maaf, saya belum bisa memahami pertanyaan tersebut.\nCoba tanya: lokasi, jam buka, harga, cara reservasi.";

    return response()->json([
        'reply'       => $reply,
        'score'       => round($bestScore, 3),
        'matched_faq' => $bestMatch?->question,
    ]);
}
```

---

### `galeri.blade.php` — Filter Galeri JavaScript

```blade
{{-- Filter buttons --}}
<div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
    <button class="btn btn-primary btn-sm filter-btn" data-filter="all">Semua</button>
    <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="Berdua">Berdua</button>
    <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="Senandung">Senandung</button>
    <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="Memori">Memori</button>
    <button class="btn btn-outline-primary btn-sm filter-btn" data-filter="Lembayung">Lembayung</button>
</div>

{{-- Gallery grid --}}
<div class="row g-3" id="gallery-container">
    @forelse($galleries as $gallery)
        <div class="col-md-4 col-sm-6 gallery-item" data-category="{{ $gallery->category }}">
            <div class="border overflow-hidden gallery-frame" style="aspect-ratio:3/4;">
                <img src="{{ url('images/galleries/' . $gallery->image) }}"
                     onerror="this.src='{{ asset('images/sejenak-logo.svg') }}';"
                     class="img-fluid w-100 h-100" style="object-fit:cover;">
            </div>
        </div>
    @empty
        <p class="text-muted text-center">Galeri masih kosong.</p>
    @endforelse
</div>

<script>
// Filter logic — pakai includes() agar "Senandung" cocok dengan "Paket Senandung"
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.replace('btn-primary', 'btn-outline-primary');
        });
        btn.classList.replace('btn-outline-primary', 'btn-primary');

        const filter = btn.dataset.filter;
        document.querySelectorAll('.gallery-item').forEach(item => {
            item.style.display = (filter === 'all' || item.dataset.category.includes(filter))
                ? 'block' : 'none';
        });
    });
});
</script>
```

---

### `reservasi/index.blade.php` — Form Booking

```blade
<form action="{{ route('reservasi.store') }}" method="POST">
    @csrf

    {{-- Nama & No. WA --}}
    <input type="text"   name="name"  class="form-control" placeholder="Nama Lengkap" required>
    <input type="text"   name="phone" class="form-control" placeholder="No. HP (WhatsApp)" required>

    {{-- Paket (dari database, dinamis) --}}
    <select name="service_package_id" class="form-select" required>
        <option value="">-- Pilih Paket --</option>
        @foreach ($packages as $package)
            <option value="{{ $package->id }}" {{ old('service_package_id') == $package->id ? 'selected' : '' }}>
                {{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}
            </option>
        @endforeach
    </select>

    {{-- Background (4 opsi statis) --}}
    <select name="background" class="form-select" required>
        <option value="">-- Pilih Background --</option>
        <option value="White">White</option>
        <option value="Elevator">Elevator</option>
        <option value="Red Box">Red Box</option>
        <option value="Grey">Grey</option>
    </select>

    {{-- Tanggal & Jam (10:00 - 21:00) --}}
    <input type="date" name="reservation_date" class="form-control" required>
    <select name="reservation_time" class="form-select" required>
        @foreach(['10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00'] as $time)
            <option value="{{ $time }}">{{ $time }} WIB</option>
        @endforeach
    </select>

    <input type="number" name="head_count" class="form-control" min="1" value="1" required>
    <textarea name="notes" class="form-control" rows="3"></textarea>

    <button type="submit" class="btn btn-primary w-100">Kirim Reservasi</button>
</form>
```

---

### Migration `reservations` Table

```php
Schema::create('reservations', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('phone');
    $table->foreignId('service_package_id')
          ->constrained('service_packages')
          ->onDelete('cascade');
    $table->date('reservation_date');
    $table->time('reservation_time');
    $table->integer('head_count');
    $table->text('notes')->nullable();
    $table->enum('status', ['pending','confirmed','completed','cancelled'])
          ->default('pending');
    $table->string('background')->nullable(); // ditambah via migration terpisah
    $table->timestamps();
});
```

---

### Admin Gallery View — Upload Modal

```blade
{{-- Tombol buka modal --}}
<button class="btn fw-bold text-dark" style="background:#FFD000;"
        data-bs-toggle="modal" data-bs-target="#addGalleryModal">
    <i class="fas fa-plus me-2"></i>Tambah Foto
</button>

{{-- Grid galeri admin (4 kolom, aspect-ratio 3:4) --}}
@forelse($galleries as $gallery)
    <div class="col-md-3 col-sm-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative">
            <img src="{{ url('images/galleries/' . $gallery->image) }}"
                 class="w-100" style="aspect-ratio:3/4; object-fit:cover;">
            <span class="badge bg-primary">{{ $gallery->category }}</span>

            {{-- Tombol hapus --}}
            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}"
                  method="POST" class="position-absolute" style="top:10px;right:10px;">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger rounded-circle"
                        onclick="return confirm('Hapus foto ini?')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
@endforelse

{{-- Modal Upload --}}
<div class="modal fade" id="addGalleryModal">
    <div class="modal-dialog">
        <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <select name="category" class="form-select" required>
                @foreach($categories as $category)
                    <option value="{{ $category }}">{{ $category }}</option>
                @endforeach
            </select>
            <input type="file" name="image" class="form-control" accept="image/*">
            <button type="submit" class="btn text-white" style="background:#00A99D;">Upload Foto</button>
        </form>
    </div>
</div>
```

---

### CSS Design Tokens (dari `layouts/app.blade.php`)

```css
:root {
    --ink: #137887; /* Teal primer */
    --ink-deep: #0d6472; /* Teal gelap */
    --paper: #fffaf0; /* Krem — background */
    --paper-soft: #fff0c7; /* Kuning muda */
    --white: #ffffff;
    --accent: #f7a900; /* Kuning emas — CTA */
    --accent-soft: #ffc841; /* Kuning terang hover */
    --muted: #5d7d82; /* Teal muted */
    --line: rgba(19, 120, 135, 0.18);
    --line-strong: rgba(19, 120, 135, 0.34);
    --radius-sm: 10px;
    --radius-md: 16px;
    --radius-lg: 24px;
    --radius-pill: 999px;
    --serif: "Playfair Display", serif;
    --sans: "Manrope", sans-serif;
}

/* Navbar — sticky, blur background */
.navbar {
    position: sticky;
    top: 0;
    z-index: 1050;
    background: rgba(255, 250, 240, 0.96);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid var(--line);
}
.navbar.navbar-scrolled {
    box-shadow: 0 10px 32px rgba(13, 100, 114, 0.12);
}
/* Navbar tidak boleh kena efek reveal-on-scroll */
.navbar.reveal-on-scroll {
    opacity: 1 !important;
    transform: none !important;
}

/* Tombol primary = kuning, teks teal gelap */
.btn-primary {
    background: var(--accent) !important;
    color: var(--ink-deep) !important;
}
.btn-primary:hover {
    background: var(--accent-soft) !important;
}

/* Reveal on scroll animation */
.reveal-on-scroll {
    opacity: 0;
    transform: translateY(28px);
    transition:
        opacity 0.72s ease,
        transform 0.72s ease;
}
.reveal-on-scroll.is-visible {
    opacity: 1;
    transform: translateY(0);
}

/* Card */
.card {
    background: rgba(255, 255, 255, 0.46);
    border: 1px solid var(--line) !important;
    transition: transform 0.28s ease;
}
.card:hover {
    transform: translateY(-3px);
}

/* Page header (teal gelap, sudut bawah membulat) */
.page-header {
    background: var(--ink);
    border-radius: 0 0 34px 34px;
    padding: clamp(62px, 8vw, 82px) 0 clamp(46px, 7vw, 62px);
}
```

---

_Dokumentasi ini mencakup seluruh aspek teknis proyek Sejenak Studio._
_Dibuat untuk: Tugas Besar Mata Kuliah Computing Project, Semester 6_
_Studio: Sejenak Selfphoto Studio Purwokerto_

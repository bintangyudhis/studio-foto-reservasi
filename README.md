# Studio Foto Reservasi

Studio Foto Reservasi adalah website company profile dan sistem reservasi online untuk Sejenak Studio. Pengunjung dapat melihat profil studio, paket layanan, galeri, dan informasi tanya jawab. Pengguna yang terdaftar dapat membuat reservasi dengan memilih paket, tanggal, slot waktu, dan latar foto. Kode aplikasi Laravel berada di folder `TugasBesar-Compro`. Folder `asset` di root berisi berkas foto pendukung.

## Fitur

- Halaman profil studio, paket layanan, galeri, dan informasi
- Registrasi dan login pengguna
- Formulir reservasi dengan pilihan paket dan latar foto
- Pengecekan slot waktu dan kalender ketersediaan reservasi
- Halaman sukses setelah reservasi dibuat
- Chatbot yang menjawab pertanyaan berdasarkan data FAQ
- Login admin terpisah dari login pengguna
- Panel admin untuk mengelola reservasi dan mengubah status reservasi
- Panel admin untuk mengelola paket layanan, galeri, FAQ, dan pengguna

## Teknologi

- PHP 8.2
- Laravel 12
- SQLite
- Blade dan Vite
- Tailwind CSS 4

## Cara Instalasi

Prasyarat:

- PHP 8.2 atau lebih baru
- Composer
- Node.js dan npm

Langkah instalasi:

1. Clone repositori ini.
2. Masuk ke folder aplikasi dengan perintah `cd TugasBesar-Compro`.
3. Jalankan `composer install`.
4. Jalankan `npm install`.
5. Salin file `.env.example` menjadi `.env`. Konfigurasi bawaan memakai SQLite pada variabel `DB_CONNECTION`.
6. Jalankan `php artisan key:generate`.
7. Jalankan `php artisan migrate --seed` untuk membuat tabel dan data awal paket, galeri, FAQ, dan admin.

## Cara Menjalankan

Jalankan perintah berikut dari folder `TugasBesar-Compro`:

```bash
php artisan serve
npm run dev
```

Website dapat dibuka di `http://127.0.0.1:8000`. Panel admin berada di `/admin/login`.

Dokumentasi proyek yang lebih rinci tersedia di berkas `TugasBesar-Compro/PROJECT_DOCS.md`.

## Lisensi

Proyek ini memakai lisensi MIT. Lihat berkas [LICENSE](LICENSE).

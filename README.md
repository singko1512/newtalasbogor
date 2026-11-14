# TALAS BOGOR - Portal Layanan dan Aplikasi Diskominfo Kabupaten Bogor

Proyek redesign portal **TALAS BOGOR** (Dinas Komunikasi dan Informatika Kabupaten Bogor) berbasis Laravel, Blade, dan Tailwind CSS v4.

## Status Saat Ini: Fase 1 (Landing Page)

Implementasi saat ini berfokus pada **1 rute publik (`/`)** yang dirender di server melalui Laravel Blade dengan progressive enhancement (`lucide` & `motion` via Vite, tanpa framework SPA dan tanpa modul luar domain layanan).

Komponen utama yang aktif pada Fase 1:
- Rute tunggal: `GET /` -> `App\Http\Controllers\BerandaController@index` (`routes/web.php`)
- Snapshot data terverifikasi: `config/talas.php` dan `config/talas_directory.php` (hasil observasi publik `https://talas.bogorkab.go.id/` & `https://diskominfo.bogorkab.go.id/` per `13 November 2026`)
- Layout & tampilan: `resources/views/layouts/app.blade.php`, `resources/views/beranda.blade.php`, `resources/views/components/ui/section-header.blade.php`, dan 8 partial di `resources/views/partials/` (`header`, `hero`, `layanan`, `direktori`, `capaian`, `akses-portal`, `footer`, `modals`)
- Dokumentasi teknis:
  - `docs/00-recon.md`: Laporan Fase 0 Reverse Engineering dan pertanyaan konfirmasi
  - `docs/rea-talas.md`: Laporan audit visual dan runtime (REA + Playwright Chromium)
  - `docs/02-fase-1-landing-page.md`: Ringkasan implementasi Fase 1 Landing Page, desain sistem, aset yang dibutuhkan, dan hasil verifikasi

## Prasyarat

- PHP `8.2+` (terverifikasi berjalan di PHP `8.3.30` / Laravel `13.42.0`)
- Composer
- Node.js & npm
- MySQL / MariaDB (untuk database aplikasi lokal) atau SQLite (untuk pengujian otomatis PHPUnit)

## Menjalankan Proyek Secara Lokal

1. Pasang dependensi PHP dan frontend:
   ```bash
   composer install
   npm install
   ```
2. Salin konfigurasi environment dan buat application key (jika belum ada `.env`):
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Sesuaikan koneksi database di `.env`, lalu jalankan migrasi awal Laravel:
   ```bash
   php artisan migrate
   ```
4. Kompilasi aset Tailwind CSS dan JavaScript dengan Vite:
   ```bash
   npm run build
   ```
   Untuk mode pengembangan dengan hot reload:
   ```bash
   npm run dev
   ```
5. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```
   Akses `http://127.0.0.1:8000` di peramban. Direktori penuh (`42` instansi / `239` aplikasi, `100` website dengan filter kategori & tautan Scoreweb, serta `416` desa.id) mendukung pencarian, filter kategori, dan paginasi baik via JavaScript maupun server-side (`GET /?tab=website&web_cat=SKPD&q=...&page=1#direktori`).

## Pengujian Otomatis

Jalankan seluruh pengujian fitur dan unit Laravel:
```bash
php artisan test
```
Pengujian landing page berada di `tests/Feature/LandingPageTest.php` dan mencakup:
- Status HTTP 200 beserta seluruh angka metrik terverifikasi (`755`, `239`, `100`, `416`, `4,34`, `MEMUASKAN`, `14.737`, `63,2%`)
- Daftar 9 layanan utama portal, ringkasannya, panel lipat 10 dokumen SOP resmi (`SOP 01` sampai `SOP 10`), Capaian SPBE (`4,34 MEMUASKAN`), Smart City, ekosistem pendukung (`6` item), portal akses (`4` peran), kontak resmi Diskominfo Cibinong, dan modal akses portal
- Pergantian tab direktori, filter kategori website (`SKPD`/`KECAMATAN`/dll.), paginasi (`page`), penyaringan kata kunci lewat `GET ?tab=...&q=...`, validasi fallback tab/kategori invalid, dan escaping XSS
- Kepastian tidak adanya referensi modul luar domain layanan, jejak kata placeholder draf, maupun karakter em dash pada keluaran HTML

## Aset & Konfirmasi yang Masih Dibutuhkan untuk Fase Berikutnya

Aset logo resmi (`public/images/logo-pemkab-bogor.png`, `public/images/logo-diskominfo-bogorkab.png`, `public/favicon.ico`) dan kontak desk bantuan resmi Diskominfo Kabupaten Bogor (`Jalan Tegar Beriman, Cibinong`, `(021) 8758605`, `diskominfo@bogorkab.go.id`) sudah terpasang pada Fase 1. Untuk masuk ke fase integrasi formulir dan direktori dinamis:
- Konfirmasi apakah perlu foto dokumentasi internal resmi gedung Diskominfo Kab. Bogor atau tetap menggunakan foto arsitektur berlisensi bebas (`public/images/hero-bogor.webp`)
- Dokumen syarat berkas detail dan estimasi penyelesaian (SLA) per layanan untuk diintegrasikan pada alur formulir pengajuan & halaman masuk autentikasi/dashboard operator

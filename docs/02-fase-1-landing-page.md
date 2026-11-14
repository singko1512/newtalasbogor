# Fase 1: Implementasi & Audit Redesign Landing Page TALAS BOGOR

Dokumen ini merangkum arsitektur landing page **TALAS BOGOR - Portal Layanan dan Aplikasi Dinas Komunikasi dan Informatika Kabupaten Bogor** (`GET /`) setelah audit berlapis (`/superior-ui-audit`, `/superior-ui`, dan `/superior-logic`).

## 1. Ringkasan Temuan Audit Lanjutan (`/superior-ui-audit`)

Selain 5 temuan awal redesign struktur section, audit lanjutan terhadap versi terang sebelumnya mengidentifikasi 5 poin perbaikan utama:
1. **Identitas Visual & Hero**: favicon bawaan dan SVG daun tiruan menggantikan lambang resmi Diskominfo Kabupaten Bogor, sementara latar hero yang polos belum menghadirkan bobot visual instansi pemerintah daerah.
2. **Pemangkasan Direktori**: tabel direktori hanya menampilkan cuplikan 5-6 baris sehingga pencarian untuk OPD lain (misal `DISDUKCAPIL`), situs `bogorkab.go.id` lain, maupun desa luar sampel gagal menemukan data asli.
3. **Ketiadaan Informasi Statistik & Modul Lama**: tautan langsung `Scoreweb Kecamatan/Kelurahan`, angka KPI aplikasi (`195 Aktif`, `36 Tidak Aktif`, `8 Tidak Digunakan`, `159 Hosting Diskominfo`), `Dashboard SKM` (`14.737 responden`, `63,2% positif`), serta kontak resmi Diskominfo (`Jalan Tegar Beriman, Cibinong`, `(021) 8758605`, `diskominfo@bogorkab.go.id`) sebelumnya tersembunyi atau belum ditampilkan di badan halaman.
4. **Animasi & Library Komponen UI**: transisi kategori, modal, akordion SOP, dan angka rekap masih mengandalkan toggle `.hidden` statis tanpa library koreografi gerak terstandar maupun ikon vektor konsisten.
5. **Tata Letak Strip Tab Direktori**: pada layar `1440px`, 3 tombol tab direktori sempat turun menjadi 2 baris di samping kotak pencarian.

## 2. Arsitektur & Peningkatan Landing Page

- **Rute**: `GET /` (`routes/web.php`)
- **Controller (`/superior-logic`)**: `App\Http\Controllers\BerandaController@index` (`app/Http/Controllers/BerandaController.php`)
  - Validasi parameter `tab` (`aplikasi|website|desaid`), `web_cat` (`SEMUA|PEMKAB|SKPD|KECAMATAN|KELURAHAN|LAINNYA`), `q` (maks. 80 karakter), serta `page` (di-clamp otomatis `1..totalPages`).
  - Menurunkan state ringkasan hero (`buildHeroSummary`) langsung dari satu sumber data `config/talas.php` tanpa indeks posisional rapuh di template Blade.
  - Menyajikan paginasi sisi server (`10` baris per halaman) sekaligus menyertakan JSON direktori penuh (`#talas-directory-data`) untuk pencarian/paginasi instan bebas-reload dan sinkronisasi URL (`history.replaceState`).
- **Tatanan Hero Gateway (`partials/hero.blade.php`)**:
  - Mengadaptasi struktur ikonik TALAS BOGOR ke palet modern: panggung atas gelap fotografis terpusat (identitas resmi Diskominfo + judul portal) yang langsung menaungi lembar putih terpadu sambutan & rekapitulasi `755` layanan beraksen garis atas emas `#d49b35` (tanpa menyertakan modul luar domain maupun ubin ikon tambahan).
- **Basis Data & Aset Terverifikasi**:
  - `config/talas.php`: metadata, kontak resmi Diskominfo Kab. Bogor (`Jalan Tegar Beriman, Cibinong`, `(021) 8758605`, `diskominfo@bogorkab.go.id`), 9 layanan utama, 10 SOP, SPBE 2025 (`4,34 MEMUASKAN`), Smart City, ekosistem modul (termasuk Scoreweb & SKM `14.737`), serta ringkasan 4 peran login (`38` SKPD, `40` Kecamatan, `416` Desa, `3` Admin).
  - `config/talas_directory.php`: seluruh data publik tanpa modul di luar cakupan (`42` instansi Aplikasi total `239`, `100` Website `bogorkab.go.id`, dan `416` registrasi `desa.id` SIDEKA-NG).
  - Aset lokal di `public/`: `favicon.ico`, `images/logo-pemkab-bogor.png`, `images/logo-diskominfo-bogorkab.png`, dan `images/hero-bogor.webp`.
- **Komponen UI & Library**:
  - `motion` (`animate`, `inView`, `stagger`): hero entrance bertahap, count-up KPI `755 / 416 / 239 / 100`, fill batang Smart City saat masuk viewport, filter layanan bertahap, akordion SOP, dan spring transition modal (menghormati `prefers-reduced-motion`).
  - `lucide`: ikon vektor terukur untuk kategori layanan, pencarian, navigasi paginasi, gembok portal, dan penutup modal.
  - Komponen Blade: `resources/views/components/ui/section-header.blade.php` serta 8 partial di `resources/views/partials/`.

## 3. Verifikasi Otomatis & Peramban

- `npm run build` (Vite v8 + Tailwind CSS v4 + `@fontsource-variable/lexend` + `@fontsource-variable/plus-jakarta-sans` + `motion` + `lucide`).
- `php artisan test` (`Tests\Feature\LandingPageTest`): mencakup kelengkapan direktori penuh (`42`/`100`/`416`), filter kategori website, batas paginasi `out-of-range`, sanitasi input XSS query, ketiadaan `digidesa`, dan nol karakter em dash (`\u2014`).
- Audit Chromium (`1440x900` desktop & `375x812` mobile) dengan `0` console error dan `0` page error.

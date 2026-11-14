# Laporan Observasi REA (Reverse Engineering & Visual/Runtime Audit) — TALAS BOGOR

Tanggal observasi: **13 November 2026** (14:30–14:35 WIB)
Target tunggal: `https://talas.bogorkab.go.id/`
Metode: REA MCP (`capture_browser_scenario` menggunakan Chromium `157.0.8103.78`, viewport desktop `1440x900` dan mobile `375x812`, `locale: id-ID`, `color_scheme: light`), dipadukan dengan inspeksi pasif respons HTTP dan stylesheet publik.
Catatan kepatuhan: Tidak ada aset asli target (gambar, logo, video, CSS, JS) yang disalin ke codebase Laravel. Seluruh tangkapan layar audit disimpan sementara di direktori scratch percakapan sebagai bukti observasi.

---

## 1. Ringkasan Eksekusi & Bukti REA

| Target URL | Viewport | REA Evidence ID | Status Akhir | Screenshot Audit (Scratch) | Temuan Utama Runtime |
|---|---|---|---|---|---|
| `https://talas.bogorkab.go.id/` | `1440x900` | `ev_...` (langkah 90, `capture_browser_scenario`) | 200 OK | `scratch/rea_screenshots/home_desktop_1440.png` (391.300 B, SHA-256 `2b572e78...`) | `[TERVERIFIKASI]` Video background `video-back.mp4` dimuat, 5 tab ikon JS (`.cd-slider-nav`), DataTables memaginasi tabel menjadi 25 baris/halaman, dan bagian `LAYANAN TALAS BOGOR` ter-render sebagai tabel 3x3 berisi 9 layanan. |
| `https://talas.bogorkab.go.id/` | `375x812` | `ev_...` (langkah 91, `capture_browser_scenario`) | 200 OK | `scratch/rea_screenshots/home_mobile_375.png` (144.603 B, SHA-256 `3a6cb5dd...`) | `[TERVERIFIKASI]` Label teks pada 5 tab ikon disembunyikan (`display: none`), bar tab berubah menjadi strip `#09efc5` setinggi `80px` dengan ikon rendah kontras, dan aksen atas kartu putih berubah dari `#f8c471` menjadi `#09efc5`. |
| `https://talas.bogorkab.go.id/dashboardlayanan/` | `1440x900` | `ev_...` (langkah 93, `capture_browser_scenario`) | 200 OK | `scratch/rea_screenshots/dashboardlayanan_1440.png` (63.842 B, SHA-256 `3302e282...`) | `[TERVERIFIKASI]` Sub-aplikasi terpisah memakai Tailwind CDN + Chart.js. Data tabel dan grafik diisi via inline JS saat runtime (5 kartu/grafik: Web Pemerintah 100, Desa.id 416, Status 239, Hosting 239, Jenis Layanan 239). |
| `https://talas.bogorkab.go.id/?pgtype=dashboardskp` | `1440x900` | `ev_...` (langkah 94, `capture_browser_scenario`) | 200 OK | `scratch/rea_screenshots/dashboardskp_1440.png` (203.370 B, SHA-256 `93592cef...`) | `[TERVERIFIKASI]` Wrapper TALAS memuat `<iframe src="https://devlop.bogorkab.go.id/index-skp/dashboard.php?page_code=D13k0m1nf0">` yang menampilkan dashboard dark-mode eksternal (Total Baris Data: `14,737`; Positif `9,318` / `63.2%`, Netral `3,164` / `21.5%`, Negatif `2,255` / `15.3%`). |
| `https://talas.bogorkab.go.id/chikiber/` | `1440x900` | `ev_...` (langkah 95, `capture_browser_scenario`) | 200 OK | `scratch/rea_screenshots/chikiber_1440.png` (509.197 B, SHA-256 `ebdcf0ea...`) | `[TERVERIFIKASI]` Halaman terpisah memakai Bootstrap 4.5 + OwlCarousel2. Panel kiri berisi intro + 12 tombol edisi bulanan diduplikasi pada tiap slide carousel (5x di HTML mentah, 11x di DOM setelah OwlCarousel mengkloning slide). |

---

## 2. Peta Layout (Desktop `1440px` vs Mobile `375px`)

### 2.1 Peta Layout Desktop (`1440x900`) — `home_desktop_1440.png`

```text
+-------------------------------------------------------------------------+
| [Top Link Bar]   HOME | SPBE | SMARTCITY | LOGIN                        |
| [Brand Header]   Logo "Talas Bogor - PORTAL LAYANAN & APLIKASI..."      |
|                  (Di atas latar video-back.mp4 + overlay gelap)         |
+-------------------------------------------------------------------------+
| [5 Icon Tabs]    [HOME]    [APLIKASI]   [WEBSITE]  [DESA.ID]  [DIGIDESA]|
|                  (kotak 80x80px, aktif slate, label uppercase di bawah) |
+-------------------------------------------------------------------------+
|                            HOME (H1 38px)                               |
|  +-------------------------------------------------------------------+  |
|  | =========== border atas #f8c471 (kuning/oranye) ================ |  |
|  | [Ilustrasi Laptop+Ikon]   | SELAMAT DATANG!                       |  |
|  | (web/img/aplikasi.png)    | ----                                  |  |
|  |                           | Di Portal Layanan dan Aplikasi...     |  |
|  |                           | TALAS BOGOR adalah portal...          |  |
|  +---------------------------+---------------------------------------+  |
|  |                      LAYANAN TALAS BOGOR                          |  |
|  |  [v] Permohonan Domain... | [v] Permohonan... | [v] Permohonan... |  |
|  |  (Tabel 3 kolom x 3 baris = 9 item layanan statis)                |  |
|  +-------------------------------------------------------------------+  |
|  |          REKAPITULASI JUMLAH LAYANAN DI KABUPATEN BOGOR           |  |
|  |  Aplikasi (239) | Website bogorkab.go.id (100) | Desa.id (416)    |  |
|  |  TOTAL: 755                                                       |  |
|  +-------------------------------------------------------------------+  |
+-------------------------------------------------------------------------+
| [Footer #546d69] ADMIN | SOP LAYANAN | DASHBOARD LAYANAN | ...          |
|                  DINAS KOMUNIKASI DAN INFORMATIKA (c) 2022 - 2026       |
+-------------------------------------------------------------------------+
```

### 2.2 Peta Layout Mobile (`375x812`) — `home_mobile_375.png`

```text
+-----------------------------------+
| HOME | SPBE | SMARTCITY | LOGIN   |
|     [Logo "Talas Bogor"]          |
|  PORTAL LAYANAN & APLIKASI...     |
+-----------------------------------+
| [Strip Cyan #09efc5 tinggi 80px]  |  <- label teks disembunyikan!
| [ico] [ico] [ico] [ico] [ico]     |     ikon 25px berdempetan, kontras rendah
+-----------------------------------+
|             HOME                  |
| +-------------------------------+ |
| | ===== border atas #09efc5 === | |
| |   [Ilustrasi aplikasi.png]    | |
| |   SELAMAT DATANG!             | |
| |   ----                        | |
| |   Di Portal Layanan...        | |
| |   (stack vertikal 1 kolom)    | |
| +-------------------------------+ |
+-----------------------------------+
```

---

## 3. Tabel Design System AS-IS (Lengkap dengan Bukti REA)

| Kategori | Elemen / Token | Nilai Teramati AS-IS | Bukti REA (Selector / File / Screenshot) | Catatan Audit untuk Redesign |
|---|---|---|---|---|
| **Tipografi** | Font utama (Portal utama) | `'Montserrat', sans-serif` (Google Fonts) | `01_home.html` `<link>`, `templatemo-style.css` (`body { font-family: 'Montserrat', sans-serif; }`) | Untuk redesign Fase 1, aturan proyek mewajibkan `font-sans` sistem (Tailwind) agar nol dependensi eksternal dan cepat dimuat. |
| **Tipografi** | Font sub-app Chikiber | `'Poppins', sans-serif` | `chikiber_1440_dom.html` `<link>` Google Fonts `Poppins:300..900` | Tidak konsisten dengan portal utama (`Montserrat`) dan Dashboard Layanan (Tailwind default sans). |
| **Tipografi** | Heading utama halaman | `38px`, `font-weight: 900`, `uppercase`, `#ffffff`, `letter-spacing: 1px` (mobile `24px`, `700`) | `templatemo-style.css` (`.heading h1` dan `@media (max-width: 850px)`) & `home_desktop_1440.png` | Terlalu banyak teks `UPPERCASE` di portal utama; sulit dipindai pada teks panjang. |
| **Tipografi** | Footer copy | `13px`, `font-weight: 400`, `#ffffff` | `templatemo-style.css` (`footer p`) | Kecil dan kurang struktur hierarki informasi kontak instansi. |
| **Warna** | Aksen utama / tombol / tab mobile | `#09efc5` (cyan/mint neon), `#8bffcc`, `#91e1ff` | `templatemo-style.css` (`.primary-button a`, `.heading span`, `.cd-slider-nav` mobile, `.cd-slider-nav ul .selected h6`), `home_mobile_375.png` | `[TERVERIFIKASI]` Kontras teks `#ffffff` atau ikon hijau di atas `#09efc5` gagal memenuhi rasio kontras WCAG 2.1 AA (`>= 4,5:1`). |
| **Warna** | Aksen border kartu desktop | `#f8c471` (kuning/amber) | `templatemo-style.css` (hex list) & `home_desktop_1440.png` | Berubah-ubah antar viewport (`#f8c471` di desktop, `#09efc5` di mobile). |
| **Warna** | Latar navigasi tab desktop & footer | `#6a8c6f` (teks tab), `#546d69` (latar footer), `#343434` (teks tombol), `#fafaff` (tautan footer) | `templatemo-style.css` (`footer`, `.cd-slider-nav ul li h6`, `.primary-button a`) | Nuansa hijau-abu kusam di template bawaan *TemplateMo*; di Dashboard Layanan sudah memakai token baru `techDark: '#2A3F35'`, `techSage: '#40795A'`. |
| **Warna** | Token sub-app Dashboard Layanan | `techDark #2A3F35`, `techSage #40795A`, `techSageLight #76A78D`, `techCocoa #B87A54`, `techCocoaLight #ede0ce` | `10_dashboardlayanan.html` (`tailwind.config`) & `dashboardlayanan_1440.png` | Sub-app terbaru (2026) sudah mengarah ke hijau-krem, namun terpisah total dari portal utama. |
| **Layout & Spacing** | Wrapper portal utama | Hero video penuh + `.cd-slider-nav` (`margin: 80px 40px` per item tab desktop) + kartu putih terpusat | `templatemo-style.css` (`.cd-slider-nav ul li`, `.heading { margin-bottom: 100px; }`) & `home_desktop_1440.png` | Spacing vertikal di atas lipatan boros (`margin-bottom: 100px`, `margin: 80px 40px`) sehingga konten inti `SELAMAT DATANG!` terdorong ke bawah lipatan di layar standar. |
| **Komponen** | Tab ikon 5 fitur | Kotak `80x80px`, `border-radius: 10%`, `opacity: 0.40`, gambar PNG statis (`ico-*.png`) | `templatemo-style.css` (`.cd-slider-nav .image-icon`) & `home_desktop_1440_dom.html` | Navigasi berbasis slider JS (`#0`), bukan anchor/URL semantik; pada `<= 850px` label `<h6>` hilang (`display: none`). |
| **Komponen** | Tabel data raksasa | jQuery DataTables `1.x` (`#maindatagrid`, `#maindatagrid2`, `#maindatagrid3`), `pageLength: 25` | `01_home.html` inline script & `home_desktop_1440_dom.html` (`select` + `input[type=search]`) | Semua 42 / 100 / 416 baris dikirim sekaligus dalam HTML awal (113 KB) lalu dipaginasi di sisi klien oleh JS. |
| **Komponen** | Media latar hero | `<video autoplay muted loop>` (`web/vid/video-back.mp4` + `.ogg`) | `01_home.html`, REA network requests (`steps/90`) | Membebani bandwidth dan performa LCP; melanggar kebutuhan efisiensi portal layanan publik. |
| **Breakpoints** | Media query CSS utama | `768px`, `850px`, `1170px` (plus Bootstrap `767px`) | `templatemo-style.css` & `sb-admin-2.css` | Perilaku di `<= 850px` merusak keterbacaan tab ikon. |

---

## 4. Konflik antara REA / Live DOM vs Teks / Temuan Awal (§0.4)

| No | Aspek | Klaim Awal / Ekstraksi Teks (§0.3–§0.4) | Fakta Live + Observasi REA (13 Nov 2026) | Penjelasan Teknis Konflik & Status Akhir |
|---|---|---|---|---|
| **1** | **9 Layanan di Homepage (`LAYANAN TALAS BOGOR`)** | §0.4 menyatakan ke-9 nama layanan *tidak muncul* di ekstraksi homepage baris 0–1246 dan berstatus `[TIDAK TERVERIFIKASI]`. | **ADA di homepage live!** Teramati di `01_home.html`, DOM REA `home_desktop_1440_dom.html` (`Table[0]`), dan screenshot `home_desktop_1440.png` tepat di bawah `SELAMAT DATANG!`: (1) `Permohonan Domain Bogorkab`, (2) `Permohonan Domain Desa.id`, (3) `Permohonan Domain & Hosting`, (4) `Permohonan Email Bogorkab`, (5) `Permohonan Reset Password Website`, (6) `Permohonan VA / Pentest`, (7) `Pengajuan / Perubahan Operator`, (8) `Perubahan Seting Domain`, (9) `Pemulihan Eror Website`. | **Penyebab teknis:** PHP server-side mencetak tag `<tr>` dan `<td>` **tanpa tag penutup `</tr>` dan `</td>`** di `Table[0]` (`01_home.html`). Parser HTML ketat / script ekstraksi berbasis `<tr>...</tr>` gagal membaca 0 baris (`total_rows=0`), sedangkan HTML5 parser Chromium di REA memperbaikinya menjadi 3 baris x 3 kolom. **Catatan penting:** Ke-9 item tersebut di homepage hanyalah daftar teks statis berikon centang (`fa-check`), bukan link/form, tanpa deskripsi syarat/estimasi, sehingga pemetaannya ke 10 dokumen SOP tetap belum terkonfirmasi. |
| **2** | **Dashboard Layanan (`/dashboardlayanan/`)** | Terlihat kosong (hanya header tabel) dalam ekstraksi teks biasa. | `[TERVERIFIKASI]` Di REA (`dashboardlayanan_1440.png` + `dashboardlayanan_1440_dom.html`), seluruh grafik Chart.js dan 5 tabel terisi penuh oleh inline JavaScript (`dataweb1`, `dataweb2`, `dtlaystatus`, `dtlayhosting`, `dtlayjenis`). | Konten `<tbody>` dirender client-side via `document.getElementById(...).innerHTML = ...` dari array JS yang disuntikkan oleh PHP saat halaman dimuat. |
| **3** | **Dashboard SKM (`/?pgtype=dashboardskp`)** | Tampil kosong / hanya judul dalam ekstraksi teks. | `[TERVERIFIKASI]` Di REA (`dashboardskp_1440.png`), area konten memuat `<iframe src="https://devlop.bogorkab.go.id/index-skp/dashboard.php?page_code=D13k0m1nf0">` yang menampilkan pie chart & tabel 14.737 responden. | Konten berada pada domain berbeda (`devlop.bogorkab.go.id`) di dalam `<iframe>`, sehingga tidak ikut terbaca saat mengambil HTML `talas.bogorkab.go.id`. |
| **4** | **Chikiber (`/chikiber/`)** | Blok pengantar muncul berulang 5 kali pada ekstraksi teks. | `[TERVERIFIKASI]` Di HTML mentah (`11_chikiber.html`), 5 slide OwlCarousel masing-masing menyertakan salinan penuh kolom kiri (logo, judul, deskripsi, 12 tombol edisi bulan, copyright). Di DOM REA (`chikiber_1440_dom.html`), OwlCarousel menambahkan slide kloning untuk infinite loop sehingga teks terduplikasi **11 kali**. | Struktur DOM carousel tidak efisien dan membingungkan screen reader. |
| **5** | **Tabel Smart City & DataTables di PHP** | Beberapa tabel terdeteksi 0 baris oleh regex `<tr>...</tr>`. | `[TERVERIFIKASI]` Tabel `APLIKASI` (42 baris), `WEBSITE` (100 baris), `DESA.ID` (416 baris), `Scoreweb` (40 & 19 baris), dan `Smart City` di HTML mentah memakai markup `<tr>`/`<td>` yang tidak selalu ditutup rapi, namun tetap terbaca oleh browser Chromium. | Wajib dibersihkan menjadi markup HTML5 semantik valid saat redesign. |

---

## 5. Tabel Pemetaan ke 9 Section Landing Page TALAS (Target Desain Baru)

| # | Section Usulan | Sumber Bukti AS-IS / REA | Perubahan Desain yang Direncanakan (Anti-Slop) |
|---|---|---|---|
| 1 | **Header / Navigasi** | Top bar (`HOME \| SPBE \| SMARTCITY \| LOGIN`) + 5 tab ikon + footer links (`ADMIN`, `SOP LAYANAN`, dll.) | Satukan dua sistem navigasi menjadi **satu header tunggal** berlogo monogram CSS `TALAS BOGOR` + tautan anchor (`#rekap`, `#layanan`, `#direktori`, `#spbe`, `#smartcity`, `#lacak-tiket`) + tombol "Masuk (Fase Berikutnya)". Hapus tab `DIGIDESA`. |
| 2 | **Hero** | `SELAMAT DATANG!` + `web/img/aplikasi.png` + `video-back.mp4` | Hapus video background dan gambar unduhan; ganti dengan **pola geometris CSS** palet hijau-emas Kabupaten Bogor (`#14532d`, `#15803d`, `#b45309`). Parafrase sambutan + 2 CTA ke `#layanan` dan `#direktori`. |
| 3 | **Rekap** | Tabel `#LAYANAN` (Aplikasi `239`, Website bogorkab.go.id `100`, Website desa.id `416`, Total `755`) | Ubah menjadi **4 kartu statistik** berhierarki jelas dengan label sumber & tanggal verifikasi (`13 Nov 2026`). |
| 4 | **Layanan** | **Konflik ditemukan:** di homepage ada 9 item `LAYANAN TALAS BOGOR`, sedangkan di `/?pgtype=soplayanan` ada 10 judul SOP. | **Sesuai aturan scope prompt yang perlu dikonfirmasi klien:** Fase 1 menggunakan 10 kartu dari **10 judul SOP terverifikasi** dengan keterangan eksplisit *"diturunkan dari judul SOP"* serta `[DATA BELUM TERVERIFIKASI]` untuk syarat & estimasi, sambil meminta klarifikasi klien atas 9 nama layanan yang ditemukan di homepage. |
| 5 | **Direktori (Cuplikan)** | Tab `APLIKASI` (42 baris), `WEBSITE` (100 baris), `DESA.ID` (416 baris) via DataTables | Render **hanya agregat + sampel terverifikasi** dengan tab Alpine.js / fallback anchor + filter cuplikan ringan + keterangan *"Direktori lengkap fase berikutnya"*, tanpa merender 400+ baris sekaligus. |
| 6 | **SPBE** | `/?pgtype=spbe` (`4,34 MEMUASKAN`, `47` indikator, `8` aspek, perbandingan `2024: 4,1` -> `2025: 4,34`) | Tampilkan ringkasan capaian SPBE + tabel 8 aspek beserta nilai & tren 2024->2025 yang bersih dan mudah dibaca di mobile. |
| 7 | **Smart City** | `/?pgtype=smartcity` (`2022: 3,15`, `2023: 3,10`, `2024: 3,17`, 6 dimensi + Lainnya total `239` aplikasi) | Tampilkan ringkasan skor 3 tahun + tabel sebaran aplikasi per dimensi (`Smart Governance 187`, dst., total `239`). |
| 8 | **Lacak Tiket** | Teks sambutan menyebut *"perangkat Tiket online dalam hal Troubleshooting"*, tetapi tidak ada fitur lacak tiket publik di AS-IS. | Tampilkan section jujur berlabel **"Rencana Redesign"**: alur tiket belum terverifikasi, form dinonaktifkan disertai penjelasan transparan. |
| 9 | **Footer** | `footer` `#546d69` berisi link admin/dashboard & copyright `2022 - 2026` | Footer `#14532d` berisi identitas instansi, tautan anchor, catatan sumber data (`talas.bogorkab.go.id`, 13 Nov 2026), serta kontak Diskominfo `[DATA BELUM TERVERIFIKASI]`. |

---

## 6. Daftar `[TIDAK DIKETAHUI]` (UNKNOWN) dari Observasi REA

1. **Isi panel setelah login (`/?slogin=1` dan `/?pgtype=admin`)**: `[TIDAK DIKETAHUI]` — dilarang login/mencoba kredensial; alur pengajuan layanan, field form tiket, status tiket, serta daftar 9 layanan vs 10 SOP di balik login tidak dapat diamati dari sisi publik.
2. **Skema database & API internal**: `[TIDAK DIKETAHUI]` — nama tabel, relasi, dan struktur data asli di server PHP `talas.bogorkab.go.id` maupun sumber data `devlop.bogorkab.go.id/index-skp/` tidak terlihat dari observasi publik.
3. **Alasan perbedaan 9 nama layanan di homepage vs 10 SOP di `/?pgtype=soplayanan`**: `[TIDAK DIKETAHUI]` — perlu konfirmasi Diskominfo apakah 9 item di homepage adalah layanan aktif di portal tiket sementara 10 SOP mencakup hal yang sama/berbeda.
4. **Data detail halaman turunan di dalam `/dashboardlayanan/` (`website_kec`, `website_kel`, `assesment`) dan isi PDF 10 SOP (`upl/soplayanan/SOP_PA_01.pdf` s.d. `SOP_PA_10.pdf`)**: `[TIDAK DIKETAHUI]` — belum diinspeksi detail per dokumen pada tahap ini agar tidak agresif; syarat dan SLA tiap layanan berstatus `[DATA BELUM TERVERIFIKASI]`.
5. **Skor Lighthouse, ukuran aset video/gambar total, header keamanan HTTP lengkap, dan versi PHP server produksi**: `[TIDAK DIKETAHUI]` — tidak diukur menggunakan DevTools Lighthouse/audit server karena fokus pada struktur publik.
6. **Panduan identitas visual resmi Pemkab Bogor / Diskominfo & ketersediaan aset vektor/master logo TALAS**: `[TIDAK DIKETAHUI]` — butuh konfirmasi klien.

---

## 7. Rencana Implementasi (Menunggu Persetujuan Fase 0 & Fase 1)

1. **Stop di akhir Fase 0 (sekarang)**: Serahkan `docs/rea-talas.md` dan `docs/00-recon.md`, minta konfirmasi konflik 9 layanan vs 10 SOP serta pertanyaan terbuka sebelum masuk ke **Fase 1 (PRD `docs/01-PRD.md`)**.
2. **Fase 1 (PRD)**: Susun PRD lengkap (`docs/01-PRD.md`) setelah recon disetujui, lalu berhenti untuk konfirmasi sebelum implementasi.
3. **Fase Implementasi Landing Page (hanya setelah PRD disetujui)**: Bangun ulang 1 rute (`/` -> `BerandaController@index`), `config/talas.php` (snapshot terverifikasi 13 Nov 2026), dan 9 section Blade partials + Tailwind CSS + Alpine.js minimal, tanpa DigiDesa, tanpa database/migrasi dulu, dan lolos pemeriksaan `antislop-ui` + `superior-ui-audit`.


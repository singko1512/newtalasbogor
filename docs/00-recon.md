# FASE 0 — Laporan Reverse Engineering (Recon) Situs Publik TALAS BOGOR

Tanggal pengamatan live: **13 November 2026** (14:30–14:35 WIB)
Target tunggal: `https://talas.bogorkab.go.id/`
Metode: Satu kali HTTP request pasif per URL publik (jeda ~0,9 detik antar request) + observasi runtime & visual melalui REA MCP (`capture_browser_scenario` Chromium `157.0.8103.78` pada `1440x900` dan `375x812`). Laporan visual/design system REA tersedia di [docs/rea-talas.md](rea-talas.md).

**Konvensi Label Bukti (Wajib):**
- `[TERVERIFIKASI]` — Diamati langsung pada respons/tampilan live `https://talas.bogorkab.go.id/` tanggal 13 Nov 2026.
- `[INFERENSI]` — Disimpulkan dari bukti yang teramati (bukan pernyataan eksplisit server/dokumen).
- `[ASUMSI]` — Belum ada bukti publik; memerlukan konfirmasi klien/Diskominfo.
- `[TIDAK DIKETAHUI]` — Tidak dapat diamati secara publik tanpa akses internal/autentikasi.
- `[DATA BELUM TERVERIFIKASI]` — Placeholder untuk konten/syarat/SLA/kontak yang tidak tersedia di halaman publik.

---

## 1. Sitemap AS-IS & Status HTTP (13 Nov 2026)

```text
https://talas.bogorkab.go.id/ (200)
├── /?pgtype=spbe (200)
│   ├── index.php?pgtype=perbupspbe (tautan terlihat; belum di-fetch)
│   └── index.php?pgtype=stpaspbe (tautan terlihat; belum di-fetch)
├── /?pgtype=smartcity (200)
│   ├── talas/upl_doc/perbup_smartcity_2020.pdf (tautan terlihat)
│   └── talas/upl_doc/kepbup_dewan_smartcity_2020.pdf (tautan terlihat)
├── /?slogin=1 (200) ──▶ [POST] app.talas.php (tidak dikirim)
├── /?pgtype=admin (200) ──▶ [POST] admin.php (tidak dikirim)
├── /?pgtype=soplayanan (200)
│   └── upl/soplayanan/SOP_PA_01.pdf .. SOP_PA_10.pdf (10 iframe PDF)
├── /?pgtype=dashboardskp (200)
│   └── iframe -> https://devlop.bogorkab.go.id/index-skp/dashboard.php?page_code=D13k0m1nf0
├── /?pgtype=scoreweb&webtype=KECAMATAN (200)
├── /?pgtype=scoreweb&webtype=KELURAHAN (200)
├── /dashboardlayanan/ (200)
│   ├── index.php?xpage=dashboard&cdx=...
│   ├── index.php?xpage=website_kec&cdx=...
│   ├── index.php?xpage=website_kel&cdx=...
│   └── index.php?xpage=assesment&cdx=...
├── /chikiber/ (200)
├── /web/juknis_bankeu_digidesa_2026.pdf (200 HEAD) [DIKECUALIKAN DARI SCOPE]
├── /robots.txt (404)
└── /sitemap.xml (404)
```

| No | URL Target (13 Nov 2026) | Status HTTP | Content-Type | Ukuran Respons | Keterangan |
|---|---|---|---|---|---|
| 1 | `https://talas.bogorkab.go.id/` | `200` | `text/html; charset=UTF-8` | ~113.043 B | `[TERVERIFIKASI]` Homepage 5 tab (HOME, APLIKASI, WEBSITE, DESA.ID, DIGIDESA). |
| 2 | `https://talas.bogorkab.go.id/?pgtype=spbe` | `200` | `text/html; charset=UTF-8` | ~31.936 B | `[TERVERIFIKASI]` Indeks & 47 indikator SPBE. |
| 3 | `https://talas.bogorkab.go.id/?pgtype=smartcity` | `200` | `text/html; charset=UTF-8` | ~22.457 B | `[TERVERIFIKASI]` Smart City (skor 2022–2024 & 239 aplikasi per dimensi). |
| 4 | `https://talas.bogorkab.go.id/?slogin=1` | `200` | `text/html; charset=UTF-8` | ~42.297 B | `[TERVERIFIKASI]` Halaman login multi-peran (SKPD, KEC, DESA, ADMIN) + captcha. |
| 5 | `https://talas.bogorkab.go.id/?pgtype=admin` | `200` | `text/html; charset=UTF-8` | ~6.467 B | `[TERVERIFIKASI]` Form login admin tersendiri (`action="admin.php"`). |
| 6 | `https://talas.bogorkab.go.id/?pgtype=soplayanan` | `200` | `text/html; charset=UTF-8` | ~9.677 B | `[TERVERIFIKASI]` Daftar 10 SOP Layanan Digital beserta 10 `<iframe>` PDF. |
| 7 | `https://talas.bogorkab.go.id/?pgtype=dashboardskp` | `200` | `text/html; charset=UTF-8` | ~5.604 B | `[TERVERIFIKASI]` Wrapper memuat `<iframe>` eksternal SKM (`14.737` data responden). |
| 8 | `https://talas.bogorkab.go.id/?pgtype=scoreweb&webtype=KECAMATAN` | `200` | `text/html; charset=UTF-8` | ~15.666 B | `[TERVERIFIKASI]` Penilaian website 40 kecamatan. |
| 9 | `https://talas.bogorkab.go.id/?pgtype=scoreweb&webtype=KELURAHAN` | `200` | `text/html; charset=UTF-8` | ~11.142 B | `[TERVERIFIKASI]` Penilaian website 19 kelurahan. |
| 10 | `https://talas.bogorkab.go.id/dashboardlayanan/` | `200` | `text/html; charset=UTF-8` | ~16.863 B (HTML) | `[TERVERIFIKASI]` Sub-app statistik Tailwind + Chart.js (tabel diisi JS saat runtime). |
| 11 | `https://talas.bogorkab.go.id/chikiber/` | `200` | `text/html; charset=UTF-8` | ~31.114 B | `[TERVERIFIKASI]` Sub-app buletin/keamanan siber (Bootstrap 4.5 + OwlCarousel). |
| 12 | `https://talas.bogorkab.go.id/web/juknis_bankeu_digidesa_2026.pdf` | `200` (HEAD) | `application/pdf` | — | `[TERVERIFIKASI]` Catatan audit **Dikecualikan dari Scope** (tidak diunduh/diulas). |
| 13 | `https://talas.bogorkab.go.id/robots.txt` | `404` | — | 0 B | `[TERVERIFIKASI]` Tidak ada `robots.txt` pada 13 Nov 2026. |
| 14 | `https://talas.bogorkab.go.id/sitemap.xml` | `404` | — | 0 B | `[TERVERIFIKASI]` Tidak ada `sitemap.xml` pada 13 Nov 2026. |

---

## 2. Dikecualikan dari Scope (Catatan Audit Saja)

`[TERVERIFIKASI]` Pada situs AS-IS tanggal 13 Nov 2026, terdapat tab ke-5 di homepage berjudul **DIGIDESA** yang memuat tautan ke `/web/juknis_bankeu_digidesa_2026.pdf` (status HTTP `200`, `application/pdf`). Sesuai instruksi ruang lingkup project, seluruh konten DigiDesa **dikecualikan sepenuhnya**, tidak didokumentasikan isinya, dan tidak direplikasi ke dalam PRD MVP landing page, navigasi, footer, maupun kode Laravel.

---

## 3. Verifikasi Silang Data Awal (§0.3) & Laporan Konflik (§0.4)

### 3.1 Verifikasi Silang Angka & Fakta (§0.3)

| Item Cek (§0.3) | Hasil Pengamatan Live 13 Nov 2026 | Status Label |
|---|---|---|
| Rekap konsisten: Aplikasi `239`, Website bogorkab.go.id `100`, Website desa.id `416`, Total `755` | Sama persis pada tabel `#LAYANAN` homepage (`Table[1]`) dan terverifikasi lewat penjumlahan baris tabel serta grafik `/dashboardlayanan/`. | `[TERVERIFIKASI]` (13 Nov 2026) |
| Tab APLIKASI (`#maindatagrid2`): 42 baris instansi; terbesar DISKOMINFO `45`, BAPPERIDA `22`, BAPPENDA `15`, SETDA `15` | Sama persis: 42 baris data (`sum(Jumlah Aplikasi) = 239`). Top instansi: DISKOMINFO `45`, BAPPERIDA `22`, SETDA `15`, BAPPENDA `15`, DPMPTSP `12`, DISDIK `12`. | `[TERVERIFIKASI]` (13 Nov 2026) |
| Tab WEBSITE (`#maindatagrid`): 100 baris (KABUPATEN `1`, OPD/SKPD `38`, KECAMATAN `40`, KELURAHAN `19`, LAINNYA `2`, JUMLAH `100`) | Sama persis: 100 baris data (`PEMKAB: 1, SKPD: 38, KECAMATAN: 40, KELURAHAN: 19, LAINNYA: 2`). | `[TERVERIFIKASI]` (13 Nov 2026) |
| Tab DESA.ID (`#maindatagrid3`): 416 baris, pola `<desa>-<kecamatan>.desa.id`, semua `Sudah` & `SIDEKA-NG` | Sama persis: 416 baris data; `Register = {'Sudah': 416}`, `Platform = {'SIDEKA-NG': 416}`. | `[TERVERIFIKASI]` (13 Nov 2026) |
| SPBE (`/?pgtype=spbe`): Indeks `4,34 (MEMUASKAN)` tahun `2025`, `47` indikator, `8` aspek, indeks `2024 = 4,1` | Sama persis: Indeks `2024 = 4.1`, `2025 = 4.34 (+0.24, MEMUASKAN)`, mengacu Surat MenPAN-RB No. `B/76/M.PD.06/2025` & PermenPAN-RB No. `59/2020`. 8 aspek: Kebijakan Internal (`4.80`), Perencanaan Strategis (`4.25`), TIK (`4.00`), Penyelenggara (`4.00`), Penerapan Manajemen (`3.25`), Audit TIK (`3.00`/`2.997`), Layanan Administrasi (`4.60`), Layanan Publik (`5.00`/`5.01`). | `[TERVERIFIKASI]` (13 Nov 2026) |
| Smart City (`/?pgtype=smartcity`): Indeks `2022 = 3,15`, `2023 = 3,10`, `2024 = 3,17`; dimensi aplikasi total `239` (Smart Governance `187`) | Sama persis: `2022 = 3,15` (peringkat 35/99), `2023 = 3,10` (peringkat 43/141), `2024 = 3,17` (`+0,07`). Sebaran aplikasi: Smart Governance `187`, Smart Living `23`, Smart Economy `10`, Smart Society `8`, Smart Branding `4`, Smart Environment `3`, Lainnya `4` (Total `239`). Regulasi: Perbup `77/2020` & Kepbup `485/412/Kpts/Per-UU/2020`. | `[TERVERIFIKASI]` (13 Nov 2026) |
| SOP Layanan (`/?pgtype=soplayanan`): 10 judul SOP (`SOP 01`–`SOP 10`) | Sama persis (lihat §4.6 untuk judul verbatim, termasuk typo `PENGAKTIFKAN` pada SOP 10). Memuat 10 iframe PDF `upl/soplayanan/SOP_PA_01.pdf` s.d. `SOP_PA_10.pdf`. | `[TERVERIFIKASI]` (13 Nov 2026) |
| Scoreweb (`?pgtype=scoreweb`): Kecamatan `40` baris, Kelurahan `19` baris, rumus `Nilai1 + Nilai2` | Sama persis: Kecamatan `40` baris, Kelurahan `19` baris. Pada sampel baris 1 (`Konten=316`, `Inovasi=5`), `Nilai1 = 189.6` (`316 * 0,6`), `Nilai2 = 200` (`5 * 100 * 0,4`), `Total = 389.6`. | `[TERVERIFIKASI]` (13 Nov 2026) |
| Login (`/?slogin=1`): 4 peran `SKPD`, `KEC`, `DESA`, `ADMIN` + captcha (`/capc_resc.php`) + tautan `Reload` | Sama persis. Terverifikasi tambahan jumlah opsi dropdown: `talas_name1` (SKPD: 38 instansi + 1 placeholder), `talas_name2` (KEC: 40 + 1), `talas_name3` (DESA: 416 + 1), `talas_name4` (ADMIN: 3 unit bidang + 1 placeholder: `APLIKASI INFORMATIKA`, `INFRASTRUKTUR TEKNOLOGI`, `PERSANDIAN`). | `[TERVERIFIKASI]` (13 Nov 2026) |
| `robots.txt` (404) & `sitemap.xml` (404) | Keduanya mengembalikan HTTP `404` pada 13 Nov 2026. | `[TERVERIFIKASI]` (13 Nov 2026) |

### 3.2 Laporan Konflik Ekstraksi (§0.4 vs Hasil Live + REA)

> **KONFLIK PENTING #1 — 9 Nama Layanan di Homepage Ternyata Ada di Live Site!**
> - **Peringatan §0.4:** Menyatakan bahwa ke-9 nama layanan (*Permohonan Domain Bogorkab, Domain Desa.id, Domain & Hosting, Email Bogorkab, Reset Password Website, VA/Pentest, Pengajuan/Perubahan Operator, Perubahan Seting Domain, Pemulihan Eror Website*) **tidak muncul** pada ekstraksi teks homepage dan berstatus `[TIDAK TERVERIFIKASI]`.
> - **Fakta Live 13 Nov 2026:** Baik pada HTML mentah (`01_home.html`) maupun DOM Chromium REA (`home_desktop_1440_dom.html`, `Table[0]`) serta screenshot `home_desktop_1440.png` (di bawah `SELAMAT DATANG!`), **bagian `LAYANAN TALAS BOGOR` memang menampilkan tabel 3x3 berisi ke-9 layanan berikut secara verbatim** `[TERVERIFIKASI]`:
>   1. `Permohonan Domain Bogorkab`
>   2. `Permohonan Domain Desa.id`
>   3. `Permohonan Domain & Hosting`
>   4. `Permohonan Email Bogorkab`
>   5. `Permohonan Reset Password Website`
>   6. `Permohonan VA / Pentest`
>   7. `Pengajuan / Perubahan Operator`
>   8. `Perubahan Seting Domain`
>   9. `Pemulihan Eror Website`
> - **Mengapa parser sebelumnya melewatkannya?** Di HTML asli PHP, elemen `<tr>` dan `<td>` pada tabel itu **tidak memiliki tag penutup `</tr>`/`</td>`**, sehingga parser HTML ketat melaporkan 0 baris, sedangkan browser Chromium memperbaikinya secara otomatis.
> - **Batasan penting (Alasan tetap perlu konfirmasi klien):** Di homepage publik, ke-9 item itu **hanya teks statis dengan ikon centang (`<i class="fa fa-check">`)**, tanpa link pengajuan, tanpa deskripsi syarat, dan tanpa SLA. Sementara di `/?pgtype=soplayanan` terdapat **10 judul SOP**. Oleh karena itu, hubungan antara 9 daftar layanan di homepage dan 10 judul SOP tetap berstatus `[INFERENSI]` dan **wajib dikonfirmasi klien** sebelum menentukan katalog final (untuk Fase 1 landing page, tetap berpegang pada kesepakatan prompt atau menunggu persetujuan user di akhir fase ini).

> **KONFLIK / PENJELASAN #2 — Dashboard Layanan (`/dashboardlayanan/`)**
> - Dalam ekstraksi HTML statis, 5 tabel hanya memiliki baris `<thead>` kosong.
> - Observasi REA membuktikan bahwa data **dimuat/dirender via inline JavaScript** (`Chart.js` + `innerHTML` pada `webTable1`, `webTable2`, `laystatusTable`, `layhostingTable`, `layjenisTable`) `[TERVERIFIKASI]`:
>   - Web Pemerintah: `100` (Bogorkab `1`, Perangkat Daerah `38`, Kecamatan `40`, Kelurahan `19`, Lainnya `2`)
>   - Web Desa.id per Tahun Register: `2018: 120`, `2019: 127`, `2020: 48`, `2021: 41`, `2022: 38`, `2023: 19`, `2024: 11`, `2025: 12` (Total `416`)
>   - Status Aplikasi: Aktif `195`, Tidak Aktif `36`, Tidak Digunakan `8` (Total `239`)
>   - Hosting Aplikasi: Server Diskominfo `159`, Hosting Lainnya `37`, Server Dinas `36`, Colocation Luar `4`, PC/Localhost `3` (Total `239`)
>   - Jenis Layanan Aplikasi: Pelayanan Publik `83`, Administrasi Pemerintahan `61`, Publikasi/Informasi Digital `47`, Kepegawaian/Kinerja `17`, Aplikasi Khusus `8`, Perencanaan/Keuangan/Penganggaran `8`, Kearsipan `6`, Pengelolaan Barang/Jasa/Aset `6`, Pengaduan/Pengawasan `3` (Total `239`).

> **KONFLIK / PENJELASAN #3 — Dashboard SKM (`/?pgtype=dashboardskp`)**
> - Dalam HTML halaman utama tidak ada tabel data karena konten dimuat via `<iframe>` lintas-subdomain ke `https://devlop.bogorkab.go.id/index-skp/dashboard.php?page_code=D13k0m1nf0` `[TERVERIFIKASI]`. REA menampilkan pie chart 14.737 responden (Positif `9.318 / 63,2%`, Netral `3.164 / 21,5%`, Negatif `2.255 / 15,3%`).

> **KONFLIK / PENJELASAN #4 — Chikiber (`/chikiber/`)**
> - Pengulangan blok pengantar 5x (HTML statis) dan 11x (DOM runtime REA) disebabkan oleh struktur slide **OwlCarousel2** yang menaruh panel teks kiri + 12 tombol edisi bulan secara utuh di dalam *setiap* slide, lalu OwlCarousel menggandakan slide untuk efek loop `[TERVERIFIKASI]`.

---

## 4. Inventaris Halaman Publik (AS-IS)

1. **Homepage (`/`)** `[TERVERIFIKASI]`:
   - *Tujuan:* Pintu masuk portal, sambutan, daftar ringkas layanan, rekap angka, serta 3 tabel direktori utama (plus 1 tab DigiDesa yang dikecualikan).
   - *Konten & tabel:* Sambutan *(intinya: TALAS BOGOR adalah portal penyelenggaraan/pengelolaan layanan & aplikasi Diskominfo Kab. Bogor serta perangkat tiket online troubleshooting aplikasi/website untuk PD, Kecamatan, dan Desa)*; tabel `LAYANAN TALAS BOGOR` (9 item statis); tabel `#LAYANAN` (4 baris rekap: `239 / 100 / 416 / 755`); Tab `APLIKASI` (`#maindatagrid2`, 42 baris, 7 kolom); Tab `WEBSITE` (ringkasan 5 kategori + tautan Scoreweb + `#maindatagrid`, 100 baris, 4 kolom); Tab `DESA.ID` (`#maindatagrid3`, 416 baris, 6 kolom).
   - *Aksi pengguna:* Pindah tab (`#0` JS), cari/sort/ubah panjang halaman DataTables per tab, klik domain eksternal (`*.bogorkab.go.id` / `*.desa.id`), navigasi ke SPBE/SmartCity/Login/Scoreweb/Footer links.
2. **SPBE (`/?pgtype=spbe`)** `[TERVERIFIKASI]`:
   - *Tujuan:* Transparansi hasil evaluasi SPBE Kabupaten Bogor 2025 & perbandingan 2024.
   - *Konten:* Indeks `4,34 (MEMUASKAN)`, referensi PermenPAN-RB 59/2020 & Surat B/76/M.PD.06/2025, 4 domain / 8 aspek / 47 indikator (kolom: `INDIKATOR`, `URAIAN`, `KOORD.`, `KOLAB.`, `2025`, `2024`), tabel `RESUME PENILAIAN SPBE`, serta link ke `perbupspbe` dan `stpaspbe`.
3. **Smart City (`/?pgtype=smartcity`)** `[TERVERIFIKASI]`:
   - *Tujuan:* Publikasi capaian Smart City Kabupaten Bogor & peta aplikasi per dimensi.
   - *Konten:* Penjelasan Gerakan Menuju 100 Smart City, 6 dimensi (Governance, Branding, Economy, Living, Society, Environment), tabel indeks 2022 (`3,15`), 2023 (`3,10`), 2024 (`3,17`), tabel jumlah aplikasi per dimensi (total `239`), tautan PDF Perbup 77/2020 & Kepbup 485/412/Kpts/Per-UU/2020.
4. **Login Multi-Peran (`/?slogin=1`)** `[TERVERIFIKASI]`:
   - *Tujuan:* Gerbang masuk operator instansi & admin Diskominfo.
   - *Konten:* 4 tab peran (`SKPD` 38 pilihan, `KEC` 40 pilihan, `DESA` 416 pilihan, `ADMIN` 3 pilihan), input Password, gambar captcha (`capc_resc.php`), input Captcha, tombol submit `btnLoginTalas` -> `POST app.talas.php`, tautan `Reload`. (Tidak ada tautan lupa password atau registrasi akun).
5. **Login Admin (`/?pgtype=admin`)** `[TERVERIFIKASI]`:
   - *Tujuan:* Form login admin terpisah (`Please Sign In`, `action="admin.php"`, input `username`, `password`, `inp_captcha`, link `Reload`).
6. **SOP Layanan (`/?pgtype=soplayanan`)** `[TERVERIFIKASI]`:
   - *Tujuan:* Menyediakan 10 dokumen PDF Standar Operasional Prosedur Diskominfo:
     `SOP 01` Standar Teknis Siklus Pengembangan Aplikasi; `SOP 02` Permohonan Layanan Website dan Aplikasi; `SOP 03` Pengembangan dan Perubahan Layanan Website dan Aplikasi; `SOP 04` Penanganan Gangguan dan Pemulihan Layanan Website dan Aplikasi; `SOP 05` Pendaftaran dan Perubahan Domain Bogorkab; `SOP 06` Pendaftaran Domain Desa.id; `SOP 07` Pendaftaran dan Perubahan Operator Website; `SOP 08` Pendaftaran dan Perubahan Email Bogorkab; `SOP 09` Penutupan Domain Bogorkab; `SOP 10` Pengaktifkan Domain Bogorkab *(typo asli: PENGAKTIFKAN)*.
7. **Dashboard SKM (`/?pgtype=dashboardskp`)** `[TERVERIFIKASI]`:
   - Memuat `<iframe>` eksternal (`devlop.bogorkab.go.id`) berisi ringkasan SKM (`14.737` responden).
8. **Scoreweb Kecamatan & Kelurahan (`/?pgtype=scoreweb&webtype=KECAMATAN|KELURAHAN`)** `[TERVERIFIKASI]`:
   - Tabel peringkat pengelolaan website (40 kecamatan, 19 kelurahan), 9 kolom: `No`, `Instansi`, `Website`, `Konten`, `Update`, `Inovasi`, `Nilai1`, `Nilai2`, `Total`.
9. **Dashboard Layanan (`/dashboardlayanan/`)** `[TERVERIFIKASI]`:
   - Sub-app terpisah berisi 5 grafik & tabel ringkasan serta menu ke `Website Kecamatan`, `Website Kelurahan`, dan `Assesment` *(typo asli)*.
10. **Chikiber (`/chikiber/`)** `[TERVERIFIKASI]`:
    - Sub-app terpisah Check Informasi Keamanan Siber (poster infografis & 12 tombol edisi bulan).

---

## 5. Inventaris Komponen UI, Data Dinamis, & Alur Pengguna

### 5.1 Komponen UI Teramati & Absen
- **Yang ada `[TERVERIFIKASI]`:** Topbar 4 tautan (`HOME | SPBE | SMARTCITY | LOGIN`); slider tab ikon 5 buah (`#0`); hero video background MP4/OGG; tabel statis 3x3 layanan; DataTables client-side per tabel (search per-tabel + length 10/25/50/100 + pagination); accordion/collapse Bootstrap (`SPBE`, `Smart City`); 10 `<iframe>` PDF (`SOP`); `<iframe>` eksternal (`SKM`); form login Select2 + captcha PHP; sub-app Chart.js; carousel OwlCarousel2.
- **Yang TIDAK terlihat di halaman publik `[TERVERIFIKASI]`:** Pencarian global lintas entitas (Aplikasi + Website + Desa.id sekaligus); filter kategori/status pada tabel homepage; tombol "Ajukan Layanan" publik; fitur "Lacak Tiket" publik (meski sambutan menyebut fungsi tiket online); breadcrumb/navigasi konsisten kembali dari sub-app `/dashboardlayanan/` dan `/chikiber/` ke portal utama; halaman lupa password / registrasi operator.

### 5.2 Entitas Data Dinamis (Nama Tabel/Kolom DB AS-IS = `[TIDAK DIKETAHUI]`)
Berdasarkan kolom tabel & kontrol publik yang terlihat `[INFERENSI]`:
1. **Instansi / Perangkat Daerah** (38 SKPD di login vs 42 entitas di tabel aplikasi — ada perbedaan cakupan seperti `BOGORKAB`, `RSUD`, `KELURAHAN`, dll.).
2. **Aplikasi OPD** (agregat 239 aplikasi; rincian status, hosting, jenis layanan terlihat di `/dashboardlayanan/`, tetapi daftar nama aplikasi individualnya tidak tampil di homepage publik).
3. **Website `bogorkab.go.id`** (100 baris: instansi, domain, kategori `PEMKAB/SKPD/KECAMATAN/KELURAHAN/LAINNYA`).
4. **Website `desa.id`** (416 baris: domain, desa, kecamatan, status register, platform, tahun register 2018–2025).
5. **Penilaian Website / Scoreweb** (59 instansi: 40 kecamatan + 19 kelurahan; konten, tanggal update, inovasi, nilai1, nilai2, total).
6. **Indikator SPBE** (4 domain, 8 aspek, 47 indikator, nilai 2024 & 2025, koordinator, kolaborator).
7. **Dimensi & Indeks Smart City** (skor 2022–2024 + distribusi 239 aplikasi ke 6 dimensi + Lainnya).
8. **SOP Layanan** (10 dokumen PDF `SOP_PA_01..10`).
9. **Peran & Akun Login** (`SKPD`, `KEC`, `DESA`, `ADMIN` — detail hak akses & manajemennya `[TIDAK DIKETAHUI]`).
10. **Tiket Layanan / Troubleshooting** (disebut di sambutan homepage, namun skema dan alurnya di balik login `[TIDAK DIKETAHUI]`).

### 5.3 Alur Pengguna Terlihat vs Asumsi
- **Terlihat publik `[TERVERIFIKASI]`:** Pengunjung membuka beranda -> melihat sambutan & rekap -> berpindah tab untuk mencari instansi/website/desa -> atau membuka halaman informasi (SPBE, Smart City, SOP, Scoreweb, Dashboard Layanan, Dashboard SKM, Chikiber) -> atau masuk ke halaman login `/?slogin=1`.
- **Hanya `[ASUMSI]` (butuh konfirmasi klien):** Alur pengajuan permohonan layanan / tiket online, alur disposisi/penanganan tiket oleh admin Diskominfo, alur pelacakan status tiket oleh pemohon, dan alur input data penilaian website / aplikasi / SKM.

---

## 6. Pengamatan Teknis & Temuan Audit UX/UI

### 6.1 Pengamatan Teknis `[TERVERIFIKASI]` / `[INFERENSI]`
- **Routing campuran:** Portal utama memakai query string PHP tunggal (`index.php?pgtype=...`, `?slogin=1`), sedangkan 2 modul baru berada di subdirektori independen (`/dashboardlayanan/?xpage=...&cdx=...` dan `/chikiber/`) dengan tech stack & desain yang berbeda total (jQuery 1.11 + Bootstrap 3/AdminLTE di portal utama vs Tailwind CDN + Chart.js + jQuery 3.7 di `/dashboardlayanan/` vs Bootstrap 4.5 + OwlCarousel di `/chikiber/`).
- **Render campuran:** Konten utama (`APLIKASI`, `WEBSITE`, `DESA.ID`, `SPBE`, `Smart City`, `Scoreweb`) bersifat Server-Side Rendered (PHP mencetak seluruh 42 + 100 + 416 baris ke HTML awal `113 KB`, lalu DataTables memaginasinya di browser). Sementara `/dashboardlayanan/` mengisi tabel via inline JS dan `/?pgtype=dashboardskp` memakai `<iframe>` eksternal.
- **Stack versi PHP / server / header keamanan / skor Lighthouse:** `[TIDAK DIKETAHUI]` (tidak diukur melalui DevTools/audit server).

### 6.2 Temuan Audit UX/UI Terverifikasi (Ringkasan `/superior-ui-audit`)

| # | Masalah Teramati | Bukti & Keterhubungan | Dampak & Rekomendasi Perbaikan | Keyakinan |
|---|---|---|---|---|
| **1** | **Dua sistem navigasi terpisah & inkonsisten antar modul** | Topbar hanya memuat 4 link (`HOME \| SPBE \| SMARTCITY \| LOGIN`), tab ikon hanya switch slide `#0`, link penting (`ADMIN`, `SOP LAYANAN`, `DASHBOARD LAYANAN`, `DASHBOARD SKM`, `CHIKIBER`) tersembunyi di `<footer>`, sedangkan `/dashboardlayanan/` dan `/chikiber/` memakai navbar terpisah tanpa link kembali ke portal utama (`01_home.html`, `10_dashboardlayanan.html`). | Konsolidasikan menjadi **satu navigasi utama yang konsisten** di seluruh halaman. | Tinggi (`[TERVERIFIKASI]`) |
| **2** | **Navigasi tab mobile kehilangan seluruh label teks & gagal kontras** | Di `templatemo-style.css` `@media (max-width: 850px)` (`home_mobile_375.png`), `.cd-slider-nav ul li h6 { display: none; }` dan latar bar menjadi `#09efc5` sehingga pengguna mobile hanya melihat 5 ikon 25px berdempetan tanpa label dan kontras rendah. | Gunakan navigasi/tab responsif dengan label teks jelas dan rasio kontras WCAG AA (`>= 4,5:1`). | Tinggi (`[TERVERIFIKASI]`) |
| **3** | **Pengiriman 558 baris tabel sekaligus + video background berat** | HTML beranda berukuran `113 KB` karena mengirim 42 + 100 + 416 baris tabel dalam DOM awal plus `<video autoplay>` `video-back.mp4` (`01_home.html`, REA `steps/90`). | Hapus video background; terapkan cuplikan agregat di landing page (Fase 1) dan pagination server-side (`25`/halaman) untuk direktori lengkap (Fase 2). | Tinggi (`[TERVERIFIKASI]`) |
| **4** | **Banyak typo, teks KAPITAL SEMUA, & ketidaksesuaian nama fitur** | Ditemukan `"PENGAKTIFKAN"` (SOP 10), `"Assesment"` (Dashboard Layanan), `"Seting"`, `"Eror"`, `"disetiap"` (Homepage), `"Smarrt City"`, `"Inplementasi"`, `"Adaftif"` (`03_smartcity.html`), serta mayoritas judul/tabel memakai `UPPERCASE` penuh. | Terapkan Bahasa Indonesia formal-pemerintahan PUEBI yang konsisten (Sentence/Title Case). | Tinggi (`[TERVERIFIKASI]`) |
| **5** | **Markup HTML tabel rusak & duplikasi DOM 11x di carousel** | Tabel `LAYANAN TALAS BOGOR` di `01_home.html` tidak menutup tag `</tr>`/`</td>`; halaman `/chikiber/` mengulang blok kiri 5x di HTML dan 11x di DOM runtime OwlCarousel (`chikiber_1440_dom.html`). | Bangun ulang dengan Blade semantik HTML5 yang valid tanpa duplikasi DOM. | Tinggi (`[TERVERIFIKASI]`) |

---

## 7. Pertanyaan Terbuka untuk Klien / Diskominfo (14 Pertanyaan)

Pertanyaan berikut **tidak boleh dijawab/diasumsikan sendiri** dan perlu konfirmasi klien sebelum atau saat menyusun PRD & membangun fitur transaksional:

1. **Konflik Katalog Layanan (9 vs 10):** Di homepage publik saat ini ada 9 nama layanan statis (`LAYANAN TALAS BOGOR`), sedangkan di `/?pgtype=soplayanan` ada 10 dokumen SOP. Apakah 10 judul SOP = 10 layanan resmi, ataukah 9 item di homepage adalah layanan aktif di sistem tiket? Apa syarat, dokumen lampiran, dan SLA/estimasi waktu tiap layanan?
2. **Teks Sambutan Resmi:** Apakah teks sambutan di hero/beranda boleh diparafrasekan agar lebih ringkas dan jelas, atau wajib menggunakan redaksi resmi tertentu dari Diskominfo?
3. **Identitas Visual Pemkab:** Apakah ada pedoman warna/tipografi resmi Pemkab Bogor atau standar SPBE nasional yang wajib diikuti selain palet hijau-emas lambang Kabupaten Bogor?
4. **Aset & Lisensi Media:** Apakah Diskominfo menyediakan file master resmi logo `TALAS BOGOR`, lambang Kabupaten Bogor (SVG/PNG transparan), serta dokumen PDF 10 SOP, Perbup 77/2020, dan Kepbup Dewan Smart City untuk dihosting di portal baru?
5. **Kontak Resmi Footer:** Alamat kantor, nomor telepon, email resmi layanan/helpdesk, dan jam operasional Diskominfo apa saja yang wajib ditampilkan di footer?
6. **Sumber Data Migrasi:** Apakah Diskominfo menyediakan dump database / file CSV resmi untuk data 239 aplikasi, 100 website, 416 desa.id, dan penilaian scoreweb, atau data awal harus diambil dari halaman publik yang ada?
7. **Daftar Rinci 239 Aplikasi:** Pada homepage publik hanya tampil rekap per instansi (42 baris), bukan daftar nama 239 aplikasinya. Apakah direktori publik baru nantinya perlu menampilkan daftar aplikasi per OPD (nama, URL, status, hosting) atau cukup rekap per OPD?
8. **Alur Tiket End-to-End:** Bagaimana alur lengkap tiket online (*Troubleshooting* maupun permohonan layanan): siapa mengajukan, tahap verifikasi/disposisi internal, daftar status tiket, notifikasi (email/WA?), dan apakah publik/pemohon boleh melacak tiket tanpa login (memakai nomor tiket)?
9. **Mekanisme Akun & Autentikasi:** Bagaimana akun `SKPD` (38), `KEC` (40), `DESA` (416), dan `ADMIN` (3 unit) dibuat dan dikelola — registrasi mandiri, integrasi SSO Pemkab, atau dibuat oleh admin Diskominfo? Apakah ada fitur reset password mandiri?
10. **Peran `ADMIN` & Sub-Menu:** Di `/?slogin=1`, opsi `ADMIN` hanya menampilkan 3 unit (`APLIKASI INFORMATIKA`, `INFRASTRUKTUR TEKNOLOGI`, dan `PERSANDIAN`) sedangkan `/?pgtype=admin` memiliki form login terpisah. Apa perbedaan kedua jalur login admin tersebut dan apakah boleh disatukan?
11. **Integrasi Dashboard SKM (`devlop.bogorkab.go.id`):** Apakah widget SKM nantinya tetap di-embed atau ditarik datanya via API internal Diskominfo?
12. **Pembaruan Data Scoreweb & Dashboard Layanan:** Bagaimana mekanisme pembaruan skor konten/inovasi pada Scoreweb (`KECAMATAN`/`KELURAHAN`) serta data di `/dashboardlayanan/` (manual input admin, atau terhubung crawler/API)?
13. **Domain & Redirect URL Lama:** Apakah portal hasil redesign akan menggantikan langsung `talas.bogorkab.go.id` sehingga URL lama seperti `/?pgtype=spbe`, `/?pgtype=smartcity`, `/?pgtype=soplayanan`, `/?slogin=1` perlu dialihkan dengan HTTP `301` ke URL bersih Laravel?
14. **Ruang Lingkup Chikiber & Sub-aplikasi:** Apakah `/chikiber/` dan `/dashboardlayanan/` ikut digabungkan ke dalam satu aplikasi Laravel pada fase lanjutan (Fase 2+), atau tetap berdiri sebagai modul terpisah?

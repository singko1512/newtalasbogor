<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Snapshot Data Publik TALAS BOGOR
    |--------------------------------------------------------------------------
    | Sumber: https://talas.bogorkab.go.id/ (observasi langsung 13 Nov 2026).
    | Seluruh angka dan daftar layanan berasal dari data terverifikasi publik;
    | rincian kontak dan syarat teknis yang belum dipublikasikan ditandai
    | secara jujur tanpa klaim buatan.
    */
    'meta' => [
        'nama_portal' => 'TALAS BOGOR',
        'judul_brand' => 'Talas Bogor',
        'kepanjangan' => 'Portal Layanan & Aplikasi Kabupaten Bogor',
        'instansi' => 'Dinas Komunikasi dan Informatika Kabupaten Bogor',
        'sumber_url' => 'https://talas.bogorkab.go.id/',
        'login_url' => 'https://talas.bogorkab.go.id/?slogin=1',
        'admin_login_url' => 'https://talas.bogorkab.go.id/index.php?pgtype=admin',
        'sop_archive_url' => 'https://talas.bogorkab.go.id/index.php?pgtype=soplayanan',
        'sop_base_url' => 'https://talas.bogorkab.go.id/upl/soplayanan/',
        'dashboard_layanan_url' => 'https://talas.bogorkab.go.id/dashboardlayanan/',
        'assesment_url' => 'https://talas.bogorkab.go.id/dashboardlayanan/index.php?xpage=assesment&cdx=3cc5f84b04af9e19e8eeaeb6b1b8321a',
        'skm_url' => 'https://talas.bogorkab.go.id/?pgtype=dashboardskp',
        'spbe_url' => 'https://talas.bogorkab.go.id/index.php?pgtype=spbe',
        'smartcity_url' => 'https://talas.bogorkab.go.id/index.php?pgtype=smartcity',
        'chikiber_url' => 'https://talas.bogorkab.go.id/chikiber/',
        'scoreweb_kec_url' => 'https://talas.bogorkab.go.id/?pgtype=scoreweb&webtype=KECAMATAN',
        'scoreweb_kel_url' => 'https://talas.bogorkab.go.id/?pgtype=scoreweb&webtype=KELURAHAN',
        'tanggal_observasi' => '13 November 2026',
        'hak_cipta' => '2022 - 2026',
        'kontak' => [
            'alamat' => 'Jalan Tegar Beriman, Cibinong, Kabupaten Bogor',
            'telepon' => '(021) 8758605',
            'email' => 'diskominfo@bogorkab.go.id',
            'saluran' => 'Layanan daring & tiket operator melalui Portal Login resmi TALAS BOGOR',
            'jam_layanan' => 'Mengikuti jam kerja Pemerintah Kabupaten Bogor',
        ],
    ],

    'hero' => [
        'judul' => 'Portal Layanan & Aplikasi Digital Kabupaten Bogor',
        'sambutan_judul' => 'Selamat Datang di Portal TALAS BOGOR',
        'ringkasan' => 'Pusat layanan aplikasi, pengelolaan website instansi dan desa, serta tiket penanganan gangguan resmi Pemerintah Kabupaten Bogor.',
        'catatan_tiket' => 'Mencakup permohonan domain bogorkab.go.id dan desa.id, hosting, email dinas, audit keamanan VA/Pentest, hingga 10 SOP resmi.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rekapitulasi Jumlah Layanan (#rekap)
    |--------------------------------------------------------------------------
    */
    'rekap' => [
        [
            'kode' => 'aplikasi',
            'label' => 'Aplikasi',
            'judul_lengkap' => 'Aplikasi Perangkat Daerah',
            'jumlah' => 239,
            'max_referensi' => 416,
            'bar_color' => '#1e40af',
            'keterangan' => 'Tersebar pada 42 instansi dan perangkat daerah',
            'sumber' => 'Direktori Aplikasi',
        ],
        [
            'kode' => 'website',
            'label' => 'Website bogorkab.go.id',
            'judul_lengkap' => 'Website Resmi bogorkab.go.id',
            'jumlah' => 100,
            'max_referensi' => 416,
            'bar_color' => '#1d4ed8',
            'keterangan' => '1 Pemkab, 38 OPD/SKPD, 40 Kecamatan, 19 Kelurahan, 2 Lainnya',
            'sumber' => 'Direktori Website',
        ],
        [
            'kode' => 'desaid',
            'label' => 'Website desa.id',
            'judul_lengkap' => 'Website Desa (desa.id)',
            'jumlah' => 416,
            'max_referensi' => 416,
            'bar_color' => '#0e7490',
            'keterangan' => '416 desa terdaftar aktif menggunakan platform SIDEKA-NG',
            'sumber' => 'Direktori Desa.id',
        ],
        [
            'kode' => 'total',
            'label' => 'Total Layanan Tercatat',
            'judul_lengkap' => 'Total Layanan di Kabupaten Bogor',
            'jumlah' => 755,
            'max_referensi' => 755,
            'bar_color' => '#b45309',
            'keterangan' => 'Akumulasi aplikasi perangkat daerah, website bogorkab.go.id, dan website desa.id',
            'sumber' => 'Rekapitulasi Publik',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | 9 Layanan Utama TALAS BOGOR (Beranda Publik)
    |--------------------------------------------------------------------------
    */
    'layanan_utama' => [
        [
            'slug' => 'domain-bogorkab',
            'nama' => 'Permohonan Domain Bogorkab',
            'kategori' => 'Domain Resmi',
            'filter_group' => 'domain',
            'sasaran' => 'OPD, Kecamatan, dan Kelurahan',
            'ikon' => 'globe',
            'icon_path' => 'images/icons/layanan/domain-bogorkab.svg',
            'kode_sop' => 'SOP 05',
            'sop_refs' => ['SOP 05'],
            'has_dedicated_sop' => true,
            'mutu_baku' => '7 tahap · Konfigurasi DNS Webmin',
            'pelaksana' => 'Bidang Aplikasi Informatika (Tim Pengelola Domain)',
            'ringkasan' => 'Pendaftaran subdomain baru maupun penyesuaian nama domain resmi di bawah ekosistem bogorkab.go.id.',
            'rujukan_sop' => 'SOP 05: Pendaftaran dan Perubahan Domain Bogorkab',
            'syarat_catatan' => 'Kelengkapan formal pada SOP 05 berupa Surat Permohonan Pendaftaran/Perubahan Domain OPD; pengajuan DNS menyertakan nama kegiatan dinas, usulan subdomain bogorkab.go.id, dan IP public server tujuan untuk konfigurasi Webmin.',
            'kelengkapan' => [
                'Surat Permohonan Pendaftaran/Perubahan Domain resmi dari pimpinan Perangkat Daerah (SOP 05).',
                'Data teknis konfigurasi DNS: nama kegiatan dinas, usulan nama subdomain bogorkab.go.id, dan alamat IP public server aktif.',
            ],
            'alur' => [
                ['tahap' => 'Pengajuan permohonan domain beserta data IP public & subdomain oleh OPD', 'waktu' => '1 hari'],
                ['tahap' => 'Verifikasi berkas dan pencatatan pada aplikasi TALAS BOGOR', 'waktu' => '1 hari'],
                ['tahap' => 'Pemrosesan antrean pendaftaran / perubahan domain pada sistem layanan', 'waktu' => '1 hari'],
                ['tahap' => 'Konfigurasi record DNS subdomain bogorkab.go.id melalui Webmin', 'waktu' => '1 hari'],
                ['tahap' => 'Laporan progres ke OPD pemohon, pembaruan tiket selesai, & pengarsipan', 'waktu' => '3 x 1 hari'],
            ],
            'dasar_hukum' => 'Perpres 95/2018 (SPBE), Permenkominfo RI No. 5/2015, Perbup Bogor 37/2021 & 122/2021, serta Kepkadis Diskominfo No. 000.8/241/KPTS/II/2024.',
        ],
        [
            'slug' => 'domain-desaid',
            'nama' => 'Permohonan Domain Desa.id',
            'kategori' => 'Domain Desa',
            'filter_group' => 'domain',
            'sasaran' => 'Pemerintah Desa se-Kabupaten Bogor',
            'ikon' => 'building',
            'icon_path' => 'images/icons/layanan/domain-desaid.svg',
            'kode_sop' => 'SOP 06',
            'sop_refs' => ['SOP 06'],
            'has_dedicated_sop' => true,
            'mutu_baku' => '7 tahap · Persetujuan Kemenkominfo (7 hari)',
            'pelaksana' => 'Seksi Integrasi & Interoperabilitas Aplikasi dan Kemenkominfo',
            'ringkasan' => 'Fasilitasi pengajuan domain resmi desa.id sesuai regulasi Permenkominfo Nomor 5 Tahun 2015.',
            'rujukan_sop' => 'SOP 06: Pendaftaran Domain Desa.id',
            'syarat_catatan' => 'Memerlukan Surat Kuasa Pendaftaran Domain dari Kepala Desa kepada Diskominfo untuk pengajuan ke Kementerian Kominfo.',
            'kelengkapan' => [
                'Surat Kuasa Pendaftaran Domain desa.id yang ditandatangani Kepala Desa kepada Diskominfo Kabupaten Bogor (Seksi Integrasi & Interoperabilitas Aplikasi).',
                'Identitas resmi desa pemohon serta dokumen pendukung sesuai ketentuan registrasi nama domain desa.',
            ],
            'alur' => [
                ['tahap' => 'Pengajuan permohonan domain dan Surat Kuasa dari Pemerintah Desa', 'waktu' => '1 hari'],
                ['tahap' => 'Verifikasi berkas permohonan pada portal TALAS BOGOR', 'waktu' => '1 hari'],
                ['tahap' => 'Pengajuan registrasi domain desa.id kepada Kementerian Kominfo', 'waktu' => '1 hari'],
                ['tahap' => 'Proses verifikasi dan persetujuan domain resmi oleh Kemenkominfo', 'waktu' => '7 hari'],
                ['tahap' => 'Pemberitahuan aktivasi ke desa, pembaruan tiket selesai, & pencatatan database desa/SIEMON', 'waktu' => '3 x 1 hari'],
            ],
            'dasar_hukum' => 'Permenkominfo RI No. 5/2015 tentang Registrasi Nama Domain Instansi Penyelenggara Negara & Kepkadis Diskominfo No. 000.8/241/KPTS/II/2024.',
        ],
        [
            'slug' => 'domain-hosting',
            'nama' => 'Permohonan Domain & Hosting',
            'kategori' => 'Infrastruktur Web',
            'filter_group' => 'domain',
            'sasaran' => 'Perangkat Daerah & Unit Kerja',
            'ikon' => 'server',
            'icon_path' => 'images/icons/layanan/domain-hosting.svg',
            'kode_sop' => 'SOP 02 / 03 / 01',
            'sop_refs' => ['SOP 02', 'SOP 03', 'SOP 01'],
            'has_dedicated_sop' => true,
            'mutu_baku' => '9-10 tahap · Coding 14 hari, CSIRT 2 hari, Hosting Pusat Data',
            'pelaksana' => 'Bidang Aptika, Tim CSIRT, & Bidang Infrastruktur (Pusat Data)',
            'ringkasan' => 'Pengajuan paket domain dan alokasi server Pusat Data untuk rilis layanan baru (SOP 02), perubahan fitur (SOP 03), mengikuti standar SDLC (SOP 01).',
            'rujukan_sop' => 'SOP 02, SOP 03 & SOP 01: Layanan Website, Aplikasi, Perubahan Fitur, & SDLC',
            'syarat_catatan' => 'Permohonan baru (SOP 02) melampirkan Nota Dinas/Surat Permohonan dan KAK; pengembangan atau perubahan fitur (SOP 03) mencakup pembukaan akses source code & database di Pusat Data serta peluncuran cPanel; seluruh siklus teknis mengacu standar dokumen SOP 01.',
            'kelengkapan' => [
                'Nota Dinas (internal) atau Surat Permohonan resmi OPD kepada Kepala Diskominfo Kabupaten Bogor (SOP 02 / SOP 03).',
                'Kerangka Acuan Kerja (KAK) serta dokumen siklus pengembangan aplikasi bila membangun sistem baru (SKPL, Design System, & User Manual pada SOP 01).',
                'Koordinasi pembukaan akses source code dan database di Pusat Data apabila merupakan perubahan fitur aplikasi eksisting (SOP 03).',
            ],
            'alur' => [
                ['tahap' => 'Pengajuan Nota Dinas / Surat Permohonan OPD beserta KAK (SOP 02 / SOP 03)', 'waktu' => '1 hari'],
                ['tahap' => 'Verifikasi berkas portal & rekomendasi teknis Kabid Aplikasi Informatika', 'waktu' => '2 x 1 hari'],
                ['tahap' => 'Pembukaan akses source code dan database Pusat Data untuk perubahan fitur (khusus SOP 03)', 'waktu' => '1 hari'],
                ['tahap' => 'Proses pembangunan / perubahan fitur aplikasi & kelengkapan dokumen teknis (SOP 01)', 'waktu' => '14 hari'],
                ['tahap' => 'Pengujian kelaikan fungsi & keamanan aplikasi bersama Tim CSIRT Diskominfo', 'waktu' => '2 hari'],
                ['tahap' => 'Penyediaan server hosting di Pusat Data / peluncuran cPanel, laporan progres, update tiket, & arsip', 'waktu' => '4 x 1 hari'],
            ],
            'dasar_hukum' => 'Perpres 95/2018 (SPBE), Perbup Bogor 37/2021 & 122/2021, serta Kepkadis Diskominfo No. 000.8/241/KPTS/II/2024.',
        ],
        [
            'slug' => 'email-bogorkab',
            'nama' => 'Permohonan Email Bogorkab',
            'kategori' => 'Email Kedinasan',
            'filter_group' => 'akses',
            'sasaran' => 'OPD, Kecamatan, dan Aparatur Terkait',
            'ikon' => 'mail',
            'icon_path' => 'images/icons/layanan/email-bogorkab.svg',
            'kode_sop' => 'SOP 08',
            'sop_refs' => ['SOP 08'],
            'has_dedicated_sop' => true,
            'mutu_baku' => '7 tahap · Pembuatan akun iRedAdmin',
            'pelaksana' => 'Bidang Aplikasi Informatika (Tim Administrator Email Dinas)',
            'ringkasan' => 'Pembuatan atau penyesuaian akun surat elektronik resmi berdomain bogorkab.go.id untuk komunikasi kedinasan.',
            'rujukan_sop' => 'SOP 08: Pendaftaran dan Perubahan Email Bogorkab',
            'syarat_catatan' => 'Kelengkapan formal pada SOP 08 berupa Surat Permohonan Pendaftaran/Perubahan Email instansi disertai rincian daftar akun untuk diproses pada server iRedAdmin.',
            'kelengkapan' => [
                'Surat Permohonan Pendaftaran atau Perubahan Email Kedinasan berdomain bogorkab.go.id (SOP 08).',
                'Daftar nama pemohon, jabatan/unit kerja, dan usulan alamat email kedinasan terkait.',
            ],
            'alur' => [
                ['tahap' => 'Pengajuan Surat Permohonan dan data lampiran oleh instansi pemohon', 'waktu' => '1 hari'],
                ['tahap' => 'Verifikasi berkas dan pemrosesan antrean melalui sistem layanan TALAS', 'waktu' => '2 x 1 hari'],
                ['tahap' => 'Pembuatan / penyesuaian akun resmi pada server email iRedAdmin (@bogorkab.go.id)', 'waktu' => '1 hari'],
                ['tahap' => 'Penyampaian informasi akun ke pemohon, update tiket selesai, & pengarsipan', 'waktu' => '3 x 1 hari'],
            ],
            'dasar_hukum' => 'Perpres 95/2018 (SPBE), Perbup Bogor 122/2021, dan Kepkadis Diskominfo No. 000.8/241/KPTS/II/2024.',
        ],
        [
            'slug' => 'reset-password',
            'nama' => 'Permohonan Reset Password Website',
            'kategori' => 'Dukungan Akses',
            'filter_group' => 'akses',
            'sasaran' => 'Operator Website OPD, Kecamatan, dan Desa',
            'ikon' => 'key',
            'icon_path' => 'images/icons/layanan/reset-password.svg',
            'kode_sop' => 'Portal / SOP 07',
            'sop_refs' => ['SOP 07'],
            'has_dedicated_sop' => false,
            'mutu_baku' => 'Verifikasi operator via login resmi & Berita Acara SOP 07',
            'pelaksana' => 'Bidang Aplikasi Informatika (Tim Pengelola Operator)',
            'ringkasan' => 'Pemulihan akses masuk pengelola website resmi ketika operator mengalami kendala kata sandi atau pergantian pengelola.',
            'rujukan_sop' => 'Login Portal TALAS BOGOR & Berita Acara Akun (SOP 07)',
            'syarat_catatan' => 'Arsip SOP publik tidak menerbitkan PDF terpisah berjudul Reset Password; pemulihan akses dilakukan lewat verifikasi akun operator resmi pada portal login TALAS (?slogin=1) atau prosedur penetapan/perubahan operator dengan Berita Acara User ID & Password pada SOP 07.',
            'kelengkapan' => [
                'Identitas operator website aktif (Nama, NIP, No. Telepon, dan Email aktif) yang tercatat pada instansi terkait.',
                'Surat pengantar pendaftaran/perubahan operator dari Kepala Desa atau SKPD apabila disertai pergantian penanggung jawab (SOP 07).',
            ],
            'alur' => [
                ['tahap' => 'Operator mengakses portal login resmi TALAS BOGOR (?slogin=1) untuk verifikasi identitas', 'waktu' => 'Portal Login'],
                ['tahap' => 'Jika terjadi kehilangan akses penuh atau mutasi pengelola, ajukan pemutakhiran operator via SOP 07', 'waktu' => 'Acuan SOP 07'],
                ['tahap' => 'Penyerahan ulang User ID dan Password oleh pengelola Diskominfo disertai Berita Acara resmi', 'waktu' => 'Verifikasi Aptika'],
            ],
            'dasar_hukum' => 'Pelayanan akses terverifikasi melalui portal resmi talas.bogorkab.go.id dengan pencatatan akun mengikuti mekanisme Berita Acara SOP 07.',
        ],
        [
            'slug' => 'va-pentest',
            'nama' => 'Permohonan VA / Pentest',
            'kategori' => 'Keamanan Informasi',
            'filter_group' => 'keamanan',
            'sasaran' => 'Pengelola Aplikasi Perangkat Daerah',
            'ikon' => 'shield',
            'icon_path' => 'images/icons/layanan/va-pentest.svg',
            'kode_sop' => 'CSIRT · SOP 01 / 10',
            'sop_refs' => ['SOP 01', 'SOP 10', 'SOP 02', 'SOP 03', 'SOP 04', 'SOP 09'],
            'has_dedicated_sop' => false,
            'mutu_baku' => 'Uji Kelaikan SOP 01 · CSIRT 2 hari (SOP 02-04) & Pentest SOP 10',
            'pelaksana' => 'Tim CSIRT, Bidang Persandian & Keamanan Informasi, & Bidang Aptika',
            'ringkasan' => 'Permohonan Vulnerability Assessment dan Penetration Testing bersama Tim CSIRT sebelum aplikasi dipublikasikan ke domain bogorkab.go.id maupun saat pengaktifan ulang domain.',
            'rujukan_sop' => 'SOP 01 (Uji Kelaikan & Pentest) dan Pengujian Tim CSIRT (SOP 02, 03, 04, 09, 10)',
            'syarat_catatan' => 'Arsip publik tidak menerbitkan PDF tunggal berlabel VA/Pentest; kewajiban uji fungsional & uji keamanan sistem (pentest) sebelum rilis tercantum pada SOP 01 Kegiatan No. 4 (output Dokumen Pengujian Fungsional / Assessment Test), dijalankan 2 hari bersama Tim CSIRT dalam SOP 02, 03, dan 04, serta menjadi syarat lolos Pentest untuk re-aktivasi domain pada SOP 10 pasca-penutupan kerentanan (SOP 09).',
            'kelengkapan' => [
                'Pengajuan permohonan rilis aplikasi baru (SOP 02), perubahan fitur (SOP 03), pemulihan insiden (SOP 04), atau pengaktifan ulang domain pasca-suspend (SOP 10).',
                'Informasi URL target/staging aplikasi serta narahubung teknis pengelola sistem Perangkat Daerah.',
                'Bukti perbaikan celah kerentanan apabila domain sebelumnya ditutup sementara berdasarkan Monitoring Cyber CSIRT (SOP 09 & SOP 10).',
            ],
            'alur' => [
                ['tahap' => 'Pengajuan tiket layanan aplikasi (SOP 02/03/04) atau permohonan pengaktifan ulang domain OPD (SOP 10)', 'waktu' => '1 hari'],
                ['tahap' => 'Koordinasi pengujian fungsional & keamanan sistem (Pentest) bersama Tim CSIRT sebelum rilis (SOP 01 Tahap 4)', 'waktu' => '2 hari (SOP 02/03/04)'],
                ['tahap' => 'Evaluasi hasil Pentest untuk persetujuan tayang Pusat Data / unsuspend domain, atau pengembalian daftar celah guna perbaikan OPD', 'waktu' => '1 hari (SOP 10)'],
            ],
            'dasar_hukum' => 'Standar Uji Kelaikan & Pentest SOP 01 serta prosedur Mutu Baku SOP 02, 03, 04, 09, dan 10 berdasarkan Kepkadis Diskominfo No. 000.8/241/KPTS/II/2024.',
        ],
        [
            'slug' => 'perubahan-operator',
            'nama' => 'Pengajuan / Perubahan Operator',
            'kategori' => 'Manajemen Operator',
            'filter_group' => 'akses',
            'sasaran' => 'SKPD, Kecamatan, dan Desa',
            'ikon' => 'users',
            'icon_path' => 'images/icons/layanan/perubahan-operator.svg',
            'kode_sop' => 'SOP 07',
            'sop_refs' => ['SOP 07'],
            'has_dedicated_sop' => true,
            'mutu_baku' => '6 tahap · Berita Acara User ID & Password',
            'pelaksana' => 'Bidang Aplikasi Informatika (Tim Pengelola Operator)',
            'ringkasan' => 'Penetapan operator baru maupun pemutakhiran data penanggung jawab pengelola website dan tiket instansi.',
            'rujukan_sop' => 'SOP 07: Pendaftaran dan Perubahan Operator Website',
            'syarat_catatan' => 'Pengajuan memuat Nama, NIP, No. Telepon, dan Email aktif operator resmi disertai penerbitan Berita Acara Penyerahan User ID & Password.',
            'kelengkapan' => [
                'Informasi resmi / surat pengantar penugasan operator dari Kepala Desa atau pimpinan Perangkat Daerah (SOP 07).',
                'Data wajib pengelola website: Nama Lengkap, NIP, Nomor Telepon aktif, dan Alamat Email resmi/aktif.',
            ],
            'alur' => [
                ['tahap' => 'Pengajuan data pendaftaran / perubahan operator dari Kepala Desa atau SKPD', 'waktu' => '1 hari'],
                ['tahap' => 'Verifikasi kelengkapan data pengelola pada aplikasi TALAS BOGOR', 'waktu' => '1 hari'],
                ['tahap' => 'Pemrosesan pembaruan kredensial pengelola website instansi', 'waktu' => '1 hari'],
                ['tahap' => 'Penerbitan Berita Acara Penyerahan User ID dan Password operator resmi', 'waktu' => '1 hari'],
                ['tahap' => 'Pembaruan status tiket selesai dan pelaporan arsip', 'waktu' => '2 x 1 hari'],
            ],
            'dasar_hukum' => 'Perpres 95/2018 (SPBE), Perbup Bogor 122/2021, dan Kepkadis Diskominfo No. 000.8/241/KPTS/II/2024.',
        ],
        [
            'slug' => 'setting-domain',
            'nama' => 'Perubahan Setting Domain',
            'kategori' => 'Konfigurasi Teknis',
            'filter_group' => 'domain',
            'sasaran' => 'Pengelola Website & Aplikasi',
            'ikon' => 'sliders',
            'icon_path' => 'images/icons/layanan/setting-domain.svg',
            'kode_sop' => 'SOP 05 / 09 / 10',
            'sop_refs' => ['SOP 05', 'SOP 09', 'SOP 10'],
            'has_dedicated_sop' => true,
            'mutu_baku' => 'Konfigurasi DNS (SOP 05), suspend (SOP 09), & re-aktivasi (SOP 10)',
            'pelaksana' => 'Bidang Aplikasi Informatika & Tim CSIRT Diskominfo',
            'ringkasan' => 'Penyesuaian konfigurasi teknis domain termasuk pengaturan DNS (SOP 05), penutupan sementara/permanen (SOP 09), hingga pengaktifan ulang domain (SOP 10).',
            'rujukan_sop' => 'SOP 05, SOP 09 & SOP 10: Pengelolaan Siklus Domain Bogorkab',
            'syarat_catatan' => 'Pengaturan DNS mengacu SOP 05, penutupan atas permohonan OPD atau laporan celah keamanan Monitoring Cyber CSIRT mengikuti SOP 09, dan pengaktifan kembali wajib lolos uji Pentest Tim CSIRT sesuai SOP 10.',
            'kelengkapan' => [
                'Perubahan DNS (SOP 05): Surat Permohonan OPD mencantumkan nama kegiatan, subdomain, dan IP public terbaru.',
                'Penutupan / suspend (SOP 09): Surat Permohonan OPD atau Laporan Kerentanan hasil Monitoring Cyber Tim CSIRT.',
                'Pengaktifan ulang / unsuspend (SOP 10): Surat Permohonan OPD disertai bukti perbaikan celah kerentanan yang lolos uji Pentest Tim CSIRT.',
            ],
            'alur' => [
                ['tahap' => 'Pengajuan permohonan perubahan DNS (SOP 05), penutupan / laporan kerentanan CSIRT (SOP 09), atau aktifasi ulang (SOP 10)', 'waktu' => '1 hari'],
                ['tahap' => 'Validasi pengajuan & koordinasi uji Pentest Tim CSIRT jika re-aktivasi domain (SOP 10)', 'waktu' => '2 x 1 hari'],
                ['tahap' => 'Pemrosesan perubahan record DNS pada Webmin atau status suspend/unsuspend domain', 'waktu' => '1 hari'],
                ['tahap' => 'Laporan status ke OPD & Tim CSIRT, pembaruan tiket selesai, & pengarsipan', 'waktu' => '3 x 1 hari'],
            ],
            'dasar_hukum' => 'Permenkominfo RI No. 5/2015, Perbup Bogor 37/2021, serta Kepkadis Diskominfo No. 000.8/241/KPTS/II/2024.',
        ],
        [
            'slug' => 'pemulihan-website',
            'nama' => 'Pemulihan Error Website',
            'kategori' => 'Penanganan Gangguan',
            'filter_group' => 'keamanan',
            'sasaran' => 'OPD, Kecamatan, dan Desa',
            'ikon' => 'wrench',
            'icon_path' => 'images/icons/layanan/pemulihan-website.svg',
            'kode_sop' => 'SOP 04',
            'sop_refs' => ['SOP 04'],
            'has_dedicated_sop' => true,
            'mutu_baku' => '10 tahap · Perbaikan s.d. 14 hari + CSIRT 2 hari',
            'pelaksana' => 'Bidang Aptika, Tim CSIRT, & Bidang Infrastruktur (Pusat Data)',
            'ringkasan' => 'Pelaporan dan pemulihan website maupun aplikasi yang mengalami gangguan operasional lewat tiket daring TALAS BOGOR.',
            'rujukan_sop' => 'SOP 04: Penanganan Gangguan dan Pemulihan Layanan',
            'syarat_catatan' => 'Memerlukan Nota Dinas (internal) atau Surat Permohonan (eksternal) penanganan gangguan beserta pencatatan tiket pada portal TALAS BOGOR.',
            'kelengkapan' => [
                'Nota Dinas (internal) atau Surat Permohonan resmi (eksternal) penanganan gangguan website/aplikasi (SOP 04).',
                'Laporan atau kronologi gangguan operasional serta pencatatan tiket gangguan di portal TALAS BOGOR.',
            ],
            'sorotan_alur' => [
                ['judul' => '01. Tiket & Pusat Data', 'ringkas' => 'Nota Dinas, kronologi insiden, & akses source code (1 hari/tahap)'],
                ['judul' => '02. Pemulihan Sistem', 'ringkas' => 'Penelusuran akar error & perbaikan aplikasi (s.d. 14 hari)'],
                ['judul' => '03. CSIRT & cPanel', 'ringkas' => 'Uji keamanan ulang (2 hari) & peluncuran produksi (1 hari)'],
            ],
            'alur' => [
                ['tahap' => 'Pelaporan tiket gangguan + Nota Dinas beserta kronologi kejadian', 'waktu' => '1 hari'],
                ['tahap' => 'Verifikasi laporan gangguan & rekomendasi Kabid Aplikasi Informatika', 'waktu' => '2 x 1 hari'],
                ['tahap' => 'Pembukaan akses source code dan database bersama Bidang Infrastruktur (Pusat Data)', 'waktu' => '1 hari'],
                ['tahap' => 'Penelusuran akar gangguan, pemulihan sistem, dan perbaikan kode', 'waktu' => '14 hari'],
                ['tahap' => 'Pengujian keamanan ulang bersama Tim CSIRT & peluncuran ulang cPanel', 'waktu' => '2 hari + 1 hari'],
                ['tahap' => 'Laporan hasil pemulihan, pembaruan tiket selesai, & pengarsipan dokumen', 'waktu' => '3 x 1 hari'],
            ],
            'dasar_hukum' => 'Perpres 95/2018 (SPBE), Perbup Bogor 37/2021 & 122/2021, serta Kepkadis Diskominfo No. 000.8/241/KPTS/II/2024.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Daftar 10 Dokumen SOP Resmi Diskominfo
    |--------------------------------------------------------------------------
    */
    'sop' => [
        [
            'kode' => 'SOP 01',
            'nama' => 'Standar Teknis Siklus Pengembangan Aplikasi',
            'kategori' => 'Tata Kelola Aplikasi',
            'dokumen' => 'SOP_PA_01.pdf',
        ],
        [
            'kode' => 'SOP 02',
            'nama' => 'Permohonan Layanan Website dan Aplikasi',
            'kategori' => 'Permohonan Baru',
            'dokumen' => 'SOP_PA_02.pdf',
        ],
        [
            'kode' => 'SOP 03',
            'nama' => 'Pengembangan dan Perubahan Layanan Website dan Aplikasi',
            'kategori' => 'Perubahan Layanan',
            'dokumen' => 'SOP_PA_03.pdf',
        ],
        [
            'kode' => 'SOP 04',
            'nama' => 'Penanganan Gangguan dan Pemulihan Layanan Website dan Aplikasi',
            'kategori' => 'Pemulihan & Gangguan',
            'dokumen' => 'SOP_PA_04.pdf',
        ],
        [
            'kode' => 'SOP 05',
            'nama' => 'Pendaftaran dan Perubahan Domain Bogorkab',
            'kategori' => 'Domain bogorkab.go.id',
            'dokumen' => 'SOP_PA_05.pdf',
        ],
        [
            'kode' => 'SOP 06',
            'nama' => 'Pendaftaran Domain Desa.id',
            'kategori' => 'Domain desa.id',
            'dokumen' => 'SOP_PA_06.pdf',
        ],
        [
            'kode' => 'SOP 07',
            'nama' => 'Pendaftaran dan Perubahan Operator Website',
            'kategori' => 'Pengelolaan Operator',
            'dokumen' => 'SOP_PA_07.pdf',
        ],
        [
            'kode' => 'SOP 08',
            'nama' => 'Pendaftaran dan Perubahan Email Bogorkab',
            'kategori' => 'Layanan Email Dinas',
            'dokumen' => 'SOP_PA_08.pdf',
        ],
        [
            'kode' => 'SOP 09',
            'nama' => 'Penutupan Domain Bogorkab',
            'kategori' => 'Domain bogorkab.go.id',
            'dokumen' => 'SOP_PA_09.pdf',
        ],
        [
            'kode' => 'SOP 10',
            'nama' => 'Pengaktifan Domain Bogorkab',
            'kategori' => 'Domain bogorkab.go.id',
            'dokumen' => 'SOP_PA_10.pdf',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Ekosistem Tautan Terverifikasi (Situs Resmi Diskominfo)
    |--------------------------------------------------------------------------
    */
    'ekosistem' => [
        [
            'kode' => 'login',
            'label' => 'Portal Login & Admin',
            'metrik' => '497 Akun Peran',
            'url' => 'https://talas.bogorkab.go.id/?slogin=1',
            'keterangan' => 'Akses operator SKPD (38), Kecamatan (40), Desa (416), dan Admin Diskominfo (3)',
            'tautan_sekunder' => [
                'label' => 'Login Admin Diskominfo',
                'url' => 'https://talas.bogorkab.go.id/index.php?pgtype=admin',
            ],
        ],
        [
            'kode' => 'sop',
            'label' => 'SOP Layanan (PDF)',
            'metrik' => '10 Dokumen Resmi',
            'url' => 'https://talas.bogorkab.go.id/index.php?pgtype=soplayanan',
            'keterangan' => 'Repositori standar operasional layanan website, domain, dan penanganan insiden',
        ],
        [
            'kode' => 'dashboard',
            'label' => 'Dashboard Layanan',
            'metrik' => '195 Aplikasi Aktif',
            'url' => 'https://talas.bogorkab.go.id/dashboardlayanan/',
            'keterangan' => 'Sebaran 239 aplikasi (159 Server Diskominfo, 36 Server Dinas) serta asesmen 57 layanan',
            'tautan_sekunder' => [
                'label' => 'Asesmen 57 Layanan',
                'url' => 'https://talas.bogorkab.go.id/dashboardlayanan/index.php?xpage=assesment&cdx=3cc5f84b04af9e19e8eeaeb6b1b8321a',
            ],
        ],
        [
            'kode' => 'skm',
            'label' => 'Dashboard SKM',
            'metrik' => '14.737 Responden',
            'positif_persen' => '63,2%',
            'url' => 'https://talas.bogorkab.go.id/?pgtype=dashboardskp',
            'keterangan' => 'Survei 78 PD: Positif 9.318 (63,2%), Netral 3.164 (21,5%), Negatif 2.255 (15,3%)',
        ],
        [
            'kode' => 'scoreweb-kec',
            'label' => 'Scoreweb Wilayah',
            'metrik' => '40 Kec & 19 Kel',
            'url' => 'https://talas.bogorkab.go.id/?pgtype=scoreweb&webtype=KECAMATAN',
            'keterangan' => 'Pemeringkatan kualitas pengelolaan website resmi 40 Kecamatan dan 19 Kelurahan',
            'tautan_sekunder' => [
                'label' => 'Scoreweb Kelurahan (19)',
                'url' => 'https://talas.bogorkab.go.id/?pgtype=scoreweb&webtype=KELURAHAN',
            ],
        ],
        [
            'kode' => 'chikiber',
            'label' => 'Chikiber',
            'metrik' => '12 Edisi Bulanan',
            'url' => 'https://talas.bogorkab.go.id/chikiber/',
            'keterangan' => 'Buletin infografis keamanan siber Januari-Desember (48 materi kewaspadaan digital)',
        ],
    ],

    'portal_roles' => [
        [
            'key' => 'skpd',
            'peran' => 'Operator SKPD',
            'tab_label' => 'SKPD / OPD',
            'jumlah' => 38,
            'ikon' => 'landmark',
            'pengguna' => 'Admin atau operator resmi dinas dan badan daerah.',
            'keterangan' => 'Pengelola website dan aplikasi perangkat daerah',
            'layanan' => [
                'Domain bogorkab.go.id dan hosting',
                'Email kedinasan',
                'VA/Pentest',
                'Tiket gangguan aplikasi',
            ],
            'rujukan' => 'SOP 02, SOP 04, SOP 05, SOP 07, dan SOP 08',
        ],
        [
            'key' => 'kec',
            'peran' => 'Operator Kecamatan',
            'tab_label' => 'Kecamatan',
            'jumlah' => 40,
            'ikon' => 'building',
            'pengguna' => 'Operator resmi pemerintah kecamatan.',
            'keterangan' => 'Pengelola domain dan pelaporan tiket kecamatan',
            'layanan' => [
                'Pengelolaan website resmi kecamatan',
                'Perubahan penanggung jawab operator wilayah',
                'Reset kata sandi operator',
                'Eskalasi kendala situs kelurahan/kecamatan',
            ],
            'rujukan' => 'SOP 04, SOP 05, dan SOP 07',
        ],
        [
            'key' => 'desa',
            'peran' => 'Operator Desa',
            'tab_label' => 'Desa (desa.id)',
            'jumlah' => 416,
            'ikon' => 'house',
            'pengguna' => 'Operator resmi pemerintah desa.',
            'keterangan' => 'Pengelola domain desa.id berbasis SIDEKA-NG',
            'layanan' => [
                'Pengajuan domain desa.id',
                'Sinkronisasi operator desa',
                'Pemulihan layanan situs desa',
            ],
            'rujukan' => 'SOP 04, SOP 06, SOP 07, dan Permenkominfo Nomor 5 Tahun 2015',
        ],
        [
            'key' => 'admin',
            'peran' => 'Admin Diskominfo',
            'tab_label' => 'Admin Diskominfo',
            'jumlah' => 3,
            'ikon' => 'users',
            'pengguna' => 'Verifikator dan tim teknis Diskominfo (Aplikasi Informatika, Infrastruktur Teknologi, dan Persandian).',
            'keterangan' => 'Koordinator teknis dan verifikator pusat layanan',
            'layanan' => [
                'Tindak lanjut permohonan layanan',
                'Verifikasi berkas SOP',
                'Pengelolaan tiket gangguan',
                'Pemutakhiran direktori Kabupaten Bogor',
            ],
            'unit_bidang' => ['Aplikasi Informatika', 'Infrastruktur Teknologi', 'Persandian'],
            'alt_login_url' => 'https://talas.bogorkab.go.id/index.php?pgtype=admin',
            'alt_login_label' => 'Login Admin Diskominfo',
            'rujukan' => 'Portal Internal Pengelola TALAS BOGOR (Aplikasi Informatika, Infrastruktur Teknologi, Persandian)',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Ringkasan Direktori (#direktori) - Metadata Agregat Terverifikasi
    |--------------------------------------------------------------------------
    */
    'direktori' => [
        'aplikasi' => [
            'judul' => 'Aplikasi Perangkat Daerah',
            'judul_singkat' => 'Aplikasi',
            'subjudul' => 'Rekapitulasi jumlah aplikasi domain bogorkab.go.id pada 42 instansi perangkat daerah',
            'total_baris_asli' => 42,
            'total_item' => 239,
            'hosting_ringkas' => 'Hosting Server Diskominfo: 159 · Hosting Lainnya: 37 · Server Dinas: 36 · Colocation Luar: 4 · PC/Localhost: 3',
            'assesment_ringkas' => [
                'total_dinilai' => 57,
                'total_aplikasi' => 239,
                'aspek' => 'Resiko (54), Relasi (51), BCP (48), Perubahan (47), SKM (46), Pengetahuan (45), API (39), SLA (33)',
            ],
            'jenis_ringkas' => 'Pelayanan Publik (83) · Administrasi Pemerintahan (61) · Publikasi/Informasi Digital (47) · Kepegawaian/Kinerja (17) · Aplikasi Khusus (8) · Perencanaan/Keuangan/Penganggaran (8) · Kearsipan (6) · Pengelolaan Barang/Jasa/Aset (6) · Pengaduan/Pengawasan (3)',
            'kartu_kpi' => [
                ['kode' => 'total', 'label' => 'Total Aplikasi', 'nilai' => '239', 'nada' => 'primary'],
                ['kode' => 'aktif', 'label' => 'Aplikasi Aktif', 'nilai' => '195', 'nada' => 'emerald'],
                ['kode' => 'nonaktif', 'label' => 'Tidak Aktif', 'nilai' => '36', 'nada' => 'amber'],
                ['kode' => 'unused', 'label' => 'Tidak Digunakan', 'nilai' => '8', 'nada' => 'neutral'],
            ],
        ],
        'website' => [
            'judul' => 'Website Resmi bogorkab.go.id',
            'judul_singkat' => 'Website',
            'subjudul' => 'Website resmi instansi Pemerintah Kabupaten Bogor dengan domain bogorkab.go.id',
            'total_baris_asli' => 100,
            'total_item' => 100,
            'wilayah_ringkas' => '1 Pemkab · 38 SKPD · 40 Kecamatan · 19 Kelurahan · 2 Lainnya',
            'scoreweb_formula' => 'Nilai1 = Jumlah Konten x 60% · Nilai2 = Jumlah Inovasi x 100 x 40% · Total = Nilai1 + Nilai2',
            'kartu_kpi' => [
                ['kode' => 'total', 'label' => 'Total Website', 'nilai' => '100', 'nada' => 'primary'],
                ['kode' => 'skpd', 'label' => 'OPD / SKPD', 'nilai' => '38', 'nada' => 'emerald'],
                ['kode' => 'kecamatan', 'label' => 'Kecamatan', 'nilai' => '40', 'nada' => 'emerald'],
                ['kode' => 'lainnya', 'label' => 'Pemkab, Kel. & Lainnya', 'nilai' => '22', 'nada' => 'neutral'],
            ],
            'scoreweb_links' => [
                ['label' => 'Scoreweb Kecamatan (40)', 'url' => 'https://talas.bogorkab.go.id/?pgtype=scoreweb&webtype=KECAMATAN'],
                ['label' => 'Scoreweb Kelurahan (19)', 'url' => 'https://talas.bogorkab.go.id/?pgtype=scoreweb&webtype=KELURAHAN'],
            ],
        ],
        'desaid' => [
            'judul' => 'Registrasi Domain Desa.id',
            'judul_singkat' => 'Desa.id',
            'subjudul' => 'Database registrasi domain desa.id sesuai Permenkominfo Nomor 5 Tahun 2015',
            'total_baris_asli' => 416,
            'total_item' => 416,
            'riwayat_tahunan' => '2018 (120) · 2019 (127) · 2020 (48) · 2021 (41) · 2022 (38) · 2023 (19) · 2024 (11) · 2025 (12)',
            'kartu_kpi' => [
                ['kode' => 'total', 'label' => 'Jumlah Desa', 'nilai' => '416', 'nada' => 'primary'],
                ['kode' => 'sudah', 'label' => 'Sudah Registrasi', 'nilai' => '416', 'nada' => 'emerald'],
                ['kode' => 'belum', 'label' => 'Belum Registrasi', 'nilai' => '0', 'nada' => 'neutral'],
                ['kode' => 'platform', 'label' => 'Platform Aktif', 'nilai' => 'SIDEKA-NG', 'nada' => 'amber'],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Ringkasan SPBE (#spbe)
    |--------------------------------------------------------------------------
    */
    'spbe' => [
        'tahun' => '2025',
        'indeks_2025' => '4,34',
        'predikat_2025' => 'MEMUASKAN',
        'indeks_2024' => '4,1',
        'kenaikan' => '+0,24',
        'total_indikator' => 47,
        'total_aspek' => 8,
        'referensi' => 'Surat MenPAN-RB Nomor B/76/M.PD.06/2025 dan PermenPAN-RB Nomor 59 Tahun 2020',
        'url' => 'https://talas.bogorkab.go.id/index.php?pgtype=spbe',
        'domain_ringkas' => [
            ['domain' => 'Kebijakan Internal', 'bobot' => '13%', 'nilai_2024' => '4,00', 'nilai_2025' => '4,80', 'selisih' => '+0,80'],
            ['domain' => 'Tata Kelola SPBE', 'bobot' => '25%', 'nilai_2024' => '3,90', 'nilai_2025' => '4,10', 'selisih' => '+0,20'],
            ['domain' => 'Manajemen SPBE', 'bobot' => '16,5%', 'nilai_2024' => '2,999', 'nilai_2025' => '3,181', 'selisih' => '+0,182'],
            ['domain' => 'Layanan SPBE', 'bobot' => '45,5%', 'nilai_2024' => '4,641', 'nilai_2025' => '4,762', 'selisih' => '+0,121'],
        ],
        'aspek' => [
            ['no' => 1, 'domain' => 'Kebijakan Internal SPBE', 'nama' => 'Kebijakan Internal Tata Kelola SPBE', 'bobot' => '13%', 'nilai_2024' => '4,00', 'nilai_2025' => '4,80', 'selisih' => '+0,80'],
            ['no' => 2, 'domain' => 'Tata Kelola SPBE', 'nama' => 'Perencanaan Strategis SPBE', 'bobot' => '10%', 'nilai_2024' => '3,75', 'nilai_2025' => '4,25', 'selisih' => '+0,50'],
            ['no' => 3, 'domain' => 'Tata Kelola SPBE', 'nama' => 'Teknologi Informasi dan Komunikasi', 'bobot' => '10%', 'nilai_2024' => '4,00', 'nilai_2025' => '4,00', 'selisih' => '0,00'],
            ['no' => 4, 'domain' => 'Tata Kelola SPBE', 'nama' => 'Penyelenggara SPBE', 'bobot' => '5%', 'nilai_2024' => '4,00', 'nilai_2025' => '4,00', 'selisih' => '0,00'],
            ['no' => 5, 'domain' => 'Manajemen SPBE', 'nama' => 'Penerapan Manajemen SPBE', 'bobot' => '12%', 'nilai_2024' => '3,125', 'nilai_2025' => '3,25', 'selisih' => '+0,125'],
            ['no' => 6, 'domain' => 'Manajemen SPBE', 'nama' => 'Pelaksanaan Audit TIK', 'bobot' => '4,5%', 'nilai_2024' => '2,664', 'nilai_2025' => '2,997', 'selisih' => '+0,333'],
            ['no' => 7, 'domain' => 'Layanan SPBE', 'nama' => 'Layanan Administrasi Pemerintahan Berbasis Elektronik', 'bobot' => '27,5%', 'nilai_2024' => '4,40', 'nilai_2025' => '4,60', 'selisih' => '+0,20'],
            ['no' => 8, 'domain' => 'Layanan SPBE', 'nama' => 'Layanan Publik Berbasis Elektronik', 'bobot' => '18%', 'nilai_2024' => '5,01', 'nilai_2025' => '5,01', 'selisih' => '0,00'],
        ],
        'regulasi_tautan' => [
            ['label' => 'Rincian 47 Indikator SPBE', 'url' => 'https://talas.bogorkab.go.id/index.php?pgtype=spbe'],
            ['label' => 'Perbup Bogor 63/2020 (SPBE)', 'url' => 'https://talas.bogorkab.go.id/index.php?pgtype=perbupspbe'],
            ['label' => 'Permenkomdigi 6/2025 (STPA)', 'url' => 'https://talas.bogorkab.go.id/index.php?pgtype=stpaspbe'],
            ['label' => 'Lampiran I Permenkomdigi 6/2025 (PDF)', 'url' => 'https://talas.bogorkab.go.id/upl/permen6/lampiran1_permen6_2025.pdf'],
            ['label' => 'Lampiran II Permenkomdigi 6/2025 (PDF)', 'url' => 'https://talas.bogorkab.go.id/upl/permen6/lampiran2_permen6_2025.pdf'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Ringkasan Smart City (#smartcity)
    |--------------------------------------------------------------------------
    */
    'smart_city' => [
        'url' => 'https://talas.bogorkab.go.id/index.php?pgtype=smartcity',
        'regulasi' => [
            [
                'judul' => 'Peraturan Bupati Bogor Nomor 77 Tahun 2020 tentang Masterplan Smart City Kabupaten Bogor',
                'dokumen_label' => 'Perbup 77/2020 (PDF)',
                'url' => 'https://talas.bogorkab.go.id/talas/upl_doc/perbup_smartcity_2020.pdf',
            ],
            [
                'judul' => 'Keputusan Bupati Bogor Nomor 485/412/Kpts/Per-UU/2020 tentang Dewan Smart City Kabupaten Bogor',
                'dokumen_label' => 'Kepbup Dewan Smart City (PDF)',
                'url' => 'https://talas.bogorkab.go.id/talas/upl_doc/kepbup_dewan_smartcity_2020.pdf',
            ],
        ],
        'indeks_tahunan' => [
            ['tahun' => '2022', 'nilai' => '3,15', 'catatan' => 'Peringkat 35 dari 99 Kabupaten/Kota (+0,40) · Surat B-1003/DJAI/AI.01.04/12/2022'],
            ['tahun' => '2023', 'nilai' => '3,10', 'catatan' => 'Peringkat 43 dari 141 Kabupaten/Kota (-0,04) · Surat B-1384/DJAI/AI.01.04/12/2023'],
            ['tahun' => '2024', 'nilai' => '3,17', 'catatan' => 'Evaluasi Tahap II Tahun 2024 (+0,07) · Surat B-1478/DJAI/AI.01.02/11/2024'],
        ],
        'komponen_2024' => 'Evaluasi Tahap II 2024 (B-1478/DJAI/AI.01.02/11/2024): Baseline 3,96 · Output 3,15 · Outcome 3,22 · Impact 3,04 · Quick Wins 2,85.',
        'dimensi_aplikasi' => [
            ['dimensi' => 'Smart Governance', 'jumlah' => 187, 'persen' => '78,2%'],
            ['dimensi' => 'Smart Living', 'jumlah' => 23, 'persen' => '9,6%'],
            ['dimensi' => 'Smart Economy', 'jumlah' => 10, 'persen' => '4,2%'],
            ['dimensi' => 'Smart Society', 'jumlah' => 8, 'persen' => '3,3%'],
            ['dimensi' => 'Smart Branding', 'jumlah' => 4, 'persen' => '1,7%'],
            ['dimensi' => 'Lainnya', 'jumlah' => 4, 'persen' => '1,7%'],
            ['dimensi' => 'Smart Environment', 'jumlah' => 3, 'persen' => '1,3%'],
        ],
        'total_aplikasi' => 239,
    ],
];

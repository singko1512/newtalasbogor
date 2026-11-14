<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /** @var array<int, string> */
    private const ALLOWED_TABS = ['aplikasi', 'website', 'desaid'];

    /** @var array<int, string> */
    private const ALLOWED_WEB_CATEGORIES = ['SEMUA', 'PEMKAB', 'SKPD', 'KECAMATAN', 'KELURAHAN', 'LAINNYA'];

    /** @var array<string, string> */
    private const WEB_CATEGORY_LABELS = [
        'SEMUA' => 'Semua',
        'PEMKAB' => 'Pemkab',
        'SKPD' => 'SKPD',
        'KECAMATAN' => 'Kecamatan',
        'KELURAHAN' => 'Kelurahan',
        'LAINNYA' => 'Lainnya',
    ];

    /** @var array<string, string> */
    private const SERVICE_FILTER_LABELS = [
        'semua' => 'Semua Layanan',
        'domain' => 'Domain & Hosting',
        'akses' => 'Email & Operator',
        'keamanan' => 'Keamanan & Gangguan',
    ];

    private const PER_PAGE = 10;

    /**
     * Tampilkan halaman beranda TALAS BOGOR dengan direktori lengkap terverifikasi,
     * penyaringan sisi server, serta paginasi progresif yang tetap bekerja tanpa JavaScript.
     */
    public function index(Request $request): View
    {
        /** @var array<string, mixed> $talas */
        $talas = config('talas');

        /** @var array<string, array<int, array<string, mixed>>> $rawDirectory */
        $rawDirectory = config('talas_directory', []);

        $rawTab = $request->query('tab');
        $activeTab = is_string($rawTab) && in_array($rawTab, self::ALLOWED_TABS, true)
            ? $rawTab
            : 'aplikasi';

        $rawQuery = $request->query('q');
        $searchQuery = is_string($rawQuery)
            ? mb_substr(trim($rawQuery), 0, 80)
            : '';

        $rawWebCat = $request->query('web_cat');
        $requestedWebCategory = is_string($rawWebCat) && in_array(strtoupper($rawWebCat), self::ALLOWED_WEB_CATEGORIES, true)
            ? strtoupper($rawWebCat)
            : 'SEMUA';
        $activeWebCategory = $activeTab === 'website' ? $requestedWebCategory : 'SEMUA';

        $rawPage = $request->query('page');
        $requestedPage = is_string($rawPage) && preg_match('/^\d+$/', $rawPage) === 1
            ? max(1, min(10000, (int) $rawPage))
            : 1;

        $direktori = $this->buildDirectoryState(
            $talas['direktori'],
            $rawDirectory,
            $activeTab,
            $searchQuery,
            $activeWebCategory,
            $requestedPage,
        );

        $sopArchiveUrl = (string) ($talas['meta']['sop_archive_url'] ?? 'https://talas.bogorkab.go.id/index.php?pgtype=soplayanan');
        $sopBaseUrl = (string) ($talas['meta']['sop_base_url'] ?? 'https://talas.bogorkab.go.id/upl/soplayanan/');
        $sopList = $this->buildSopCatalog($talas['sop'] ?? [], $sopBaseUrl);
        $layananUtama = $this->buildServicesCatalog($talas['layanan_utama'] ?? [], $sopList);
        $serviceFilters = $this->buildServiceFilters($layananUtama);
        $heroSummary = $this->buildHeroSummary($talas);
        $direktoriSummary = $this->buildDirektoriSummary($talas['direktori'] ?? [], $heroSummary);
        $webCategories = $this->buildWebCategories($rawDirectory['website'] ?? []);
        $hasActiveFilter = $searchQuery !== '' || ($activeTab === 'website' && $activeWebCategory !== 'SEMUA');

        return view('beranda', [
            'meta' => $talas['meta'],
            'hero' => $talas['hero'],
            'rekap' => $talas['rekap'],
            'heroSummary' => $heroSummary,
            'layananUtama' => $layananUtama,
            'sopList' => $sopList,
            'serviceFilters' => $serviceFilters,
            'sopArchiveUrl' => $sopArchiveUrl,
            'direktori' => $direktori,
            'direktoriSummary' => $direktoriSummary,
            'webCategories' => $webCategories,
            'hasActiveFilter' => $hasActiveFilter,
            'directoryDataset' => $rawDirectory,
            'spbe' => $talas['spbe'],
            'smartCity' => $talas['smart_city'],
            'ekosistem' => $talas['ekosistem'],
            'portalRoles' => $talas['portal_roles'] ?? [],
            'activeTab' => $activeTab,
            'activeWebCategory' => $activeWebCategory,
            'searchQuery' => $searchQuery,
            'perPage' => self::PER_PAGE,
        ]);
    }

    /**
     * Bangun state direktori per tab (total terfilter, halaman aktif, dan irisan baris).
     *
     * @param  array<string, array<string, mixed>>  $direktoriMeta
     * @param  array<string, array<int, array<string, mixed>>>  $rawDirectory
     * @return array<string, array<string, mixed>>
     */
    private function buildDirectoryState(
        array $direktoriMeta,
        array $rawDirectory,
        string $activeTab,
        string $query,
        string $webCategory,
        int $requestedPage,
    ): array {
        $needle = mb_strtolower($query);
        $state = [];

        foreach (self::ALLOWED_TABS as $tabKey) {
            $meta = $direktoriMeta[$tabKey] ?? [];
            $rows = $rawDirectory[$tabKey] ?? [];

            if ($tabKey === 'website' && $webCategory !== 'SEMUA') {
                $rows = array_values(array_filter(
                    $rows,
                    static fn (array $row): bool => ($row['kategori'] ?? '') === $webCategory
                ));
            }

            if ($needle !== '') {
                $rows = array_values(array_filter(
                    $rows,
                    fn (array $row): bool => str_contains(
                        $this->searchableRowText($tabKey, $row),
                        $needle
                    )
                ));
            }

            $totalMatches = count($rows);
            $totalPages = max(1, (int) ceil($totalMatches / self::PER_PAGE));
            $currentPage = $tabKey === $activeTab
                ? min($requestedPage, $totalPages)
                : 1;
            $offset = ($currentPage - 1) * self::PER_PAGE;

            $meta['filtered_total'] = $totalMatches;
            $meta['current_page'] = $currentPage;
            $meta['total_pages'] = $totalPages;
            $meta['rows'] = array_slice($rows, $offset, self::PER_PAGE);

            $state[$tabKey] = $meta;
        }

        return $state;
    }

    /**
     * Turunkan metrik & segmen ringkasan hero secara konsisten dari satu sumber data config/talas.
     *
     * @param  array<string, mixed>  $talas
     * @return array<string, mixed>
     */
    private function buildHeroSummary(array $talas): array
    {
        $rekapByCode = [];
        foreach ($talas['rekap'] ?? [] as $item) {
            if (is_array($item) && isset($item['kode'])) {
                $rekapByCode[(string) $item['kode']] = $item;
            }
        }

        $totalLayanan = max(1, (int) ($rekapByCode['total']['jumlah'] ?? 755));

        $segmentPalette = [
            'desaid' => ['tab' => 'desaid', 'color' => '#1b4332', 'fallback_label' => 'Website Desa (desa.id)', 'fallback_count' => 416],
            'aplikasi' => ['tab' => 'aplikasi', 'color' => '#2d6a4f', 'fallback_label' => 'Aplikasi Perangkat Daerah', 'fallback_count' => 239],
            'website' => ['tab' => 'website', 'color' => '#926018', 'fallback_label' => 'Website Resmi bogorkab.go.id', 'fallback_count' => 100],
        ];

        $segments = [];
        foreach ($segmentPalette as $kode => $cfg) {
            $source = $rekapByCode[$kode] ?? [];
            $count = (int) ($source['jumlah'] ?? $cfg['fallback_count']);
            $ratio = ($count / $totalLayanan) * 100;

            $segments[] = [
                'tab' => $cfg['tab'],
                'label' => (string) ($source['judul_lengkap'] ?? $cfg['fallback_label']),
                'jumlah' => $count,
                'keterangan' => (string) ($source['keterangan'] ?? ''),
                'color' => $cfg['color'],
                'share_css' => number_format($ratio, 1, '.', ''),
                'share_label' => number_format($ratio, 1, ',', '.').'%',
            ];
        }

        $appMeta = $talas['direktori']['aplikasi'] ?? [];
        $appAktif = '195';
        foreach ($appMeta['kartu_kpi'] ?? [] as $kpi) {
            if (($kpi['kode'] ?? '') === 'aktif' && isset($kpi['nilai'])) {
                $appAktif = (string) $kpi['nilai'];
                break;
            }
        }
        $appTotal = (string) ($appMeta['total_item'] ?? 239);
        $appOpd = (string) ($appMeta['total_baris_asli'] ?? 42);

        $spbe = $talas['spbe'] ?? [];
        $skmMeta = [];
        foreach ($talas['ekosistem'] ?? [] as $eco) {
            if (($eco['kode'] ?? '') === 'skm') {
                $skmMeta = $eco;
                break;
            }
        }
        $skmPositif = (string) ($skmMeta['positif_persen'] ?? '63,2%');

        $compositionLabel = sprintf(
            'Komposisi %d layanan: %d Website desa.id (%s), %d Aplikasi OPD (%s), dan %d Website bogorkab.go.id (%s)',
            $totalLayanan,
            $segments[0]['jumlah'],
            $segments[0]['share_label'],
            $segments[1]['jumlah'],
            $segments[1]['share_label'],
            $segments[2]['jumlah'],
            $segments[2]['share_label'],
        );

        return [
            'katalog_count' => count($talas['layanan_utama'] ?? []),
            'total_layanan' => $totalLayanan,
            'composition_label' => $compositionLabel,
            'highlights' => [
                [
                    'label' => 'Aplikasi Aktif',
                    'angka' => $appAktif,
                    'konteks' => sprintf('dari %s aplikasi · %s OPD', $appTotal, $appOpd),
                    'nilai' => sprintf('%s dari %s (%s OPD)', $appAktif, $appTotal, $appOpd),
                ],
                [
                    'label' => 'Indeks SPBE 2025',
                    'angka' => (string) ($spbe['indeks_2025'] ?? '4,34'),
                    'konteks' => sprintf('Predikat %s', $spbe['predikat_2025'] ?? 'MEMUASKAN'),
                    'nilai' => sprintf('%s (%s)', $spbe['indeks_2025'] ?? '4,34', $spbe['predikat_2025'] ?? 'MEMUASKAN'),
                ],
                [
                    'label' => 'Kepuasan Masyarakat',
                    'angka' => $skmPositif,
                    'konteks' => sprintf('Positif · %s', $skmMeta['metrik'] ?? '14.737 Responden'),
                    'nilai' => sprintf('%s (%s)', $skmMeta['metrik'] ?? '14.737 Responden', $skmPositif),
                ],
            ],
            'segments' => $segments,
        ];
    }

    /**
     * Ekstrak teks kolom yang tampil pada tabel direktori agar pencarian tidak mencocokkan protokol URL.
     *
     * @param  array<string, mixed>  $row
     */
    private function searchableRowText(string $tabKey, array $row): string
    {
        $fields = match ($tabKey) {
            'aplikasi' => [
                $row['instansi'] ?? '',
                $row['jumlah'] ?? '',
                $row['prioritas'] ?? '',
                $row['tematik'] ?? '',
                $row['instansional'] ?? '',
                $row['lainnya'] ?? '',
            ],
            'website' => [
                $row['instansi'] ?? '',
                $row['domain'] ?? '',
                $row['kategori'] ?? '',
            ],
            default => [
                $row['domain'] ?? '',
                $row['desa'] ?? '',
                $row['kecamatan'] ?? '',
                $row['register'] ?? $row['status'] ?? '',
                $row['platform'] ?? '',
            ],
        };

        return mb_strtolower(implode(' ', array_map(strval(...), $fields)));
    }

    /**
     * Turunkan ringkasan angka direktori secara konsisten untuk judul bagian dan penunjuk agregat.
     *
     * @param  array<string, array<string, mixed>>  $direktoriMeta
     * @param  array<string, mixed>  $heroSummary
     * @return array<string, int>
     */
    private function buildDirektoriSummary(array $direktoriMeta, array $heroSummary): array
    {
        $appRows = (int) ($direktoriMeta['aplikasi']['total_baris_asli'] ?? 42);
        $appItems = (int) ($direktoriMeta['aplikasi']['total_item'] ?? 239);
        $webRows = (int) ($direktoriMeta['website']['total_baris_asli'] ?? 100);
        $webItems = (int) ($direktoriMeta['website']['total_item'] ?? 100);
        $desaRows = (int) ($direktoriMeta['desaid']['total_baris_asli'] ?? 416);
        $desaItems = (int) ($direktoriMeta['desaid']['total_item'] ?? 416);

        return [
            'app_rows' => $appRows,
            'app_items' => $appItems,
            'web_items' => $webItems,
            'desa_items' => $desaItems,
            'total_entries' => (int) ($heroSummary['total_layanan'] ?? ($appItems + $webItems + $desaItems)),
            'total_rows' => $appRows + $webRows + $desaRows,
        ];
    }

    /**
     * Hitung label dan jumlah kategori website resmi langsung dari baris direktori website.
     *
     * @param  array<int, array<string, mixed>>  $websiteRows
     * @return array<string, string>
     */
    private function buildWebCategories(array $websiteRows): array
    {
        $counts = [];
        foreach ($websiteRows as $row) {
            $category = strtoupper((string) ($row['kategori'] ?? 'LAINNYA'));
            $counts[$category] = ($counts[$category] ?? 0) + 1;
        }

        $total = count($websiteRows);
        $categories = [];
        foreach (self::WEB_CATEGORY_LABELS as $code => $label) {
            $count = $code === 'SEMUA' ? $total : ($counts[$code] ?? 0);
            $categories[$code] = sprintf('%s (%d)', $label, $count);
        }

        return $categories;
    }

    /**
     * Bangun katalog 10 dokumen SOP beserta URL PDF kanonis dari satu sumber basis URL.
     *
     * @param  array<int, array<string, mixed>>  $rawSop
     * @return array<int, array<string, string>>
     */
    private function buildSopCatalog(array $rawSop, string $sopBaseUrl): array
    {
        $normalizedBase = rtrim($sopBaseUrl, '/').'/';
        $catalog = [];

        foreach ($rawSop as $sop) {
            if (! is_array($sop)) {
                continue;
            }

            $dokumen = ltrim((string) ($sop['dokumen'] ?? ''), '/');

            $catalog[] = [
                'kode' => (string) ($sop['kode'] ?? ''),
                'nama' => (string) ($sop['nama'] ?? ''),
                'kategori' => (string) ($sop['kategori'] ?? ''),
                'dokumen' => $dokumen,
                'url' => $dokumen !== '' ? $normalizedBase.$dokumen : '',
            ];
        }

        return $catalog;
    }

    /**
     * Tautkan setiap layanan utama ke dokumen SOP resminya agar tidak menduplikasi URL PDF.
     *
     * @param  array<int, array<string, mixed>>  $rawServices
     * @param  array<int, array<string, string>>  $sopList
     * @return array<int, array<string, mixed>>
     */
    private function buildServicesCatalog(array $rawServices, array $sopList): array
    {
        $sopByCode = [];
        foreach ($sopList as $sop) {
            if ($sop['kode'] !== '') {
                $sopByCode[$sop['kode']] = $sop;
            }
        }

        $resolvedServices = [];
        foreach ($rawServices as $service) {
            if (! is_array($service)) {
                continue;
            }

            $refs = is_array($service['sop_refs'] ?? null) ? $service['sop_refs'] : [];
            $dokumenSop = [];

            foreach ($refs as $code) {
                $kode = (string) $code;
                if (! isset($sopByCode[$kode])) {
                    throw new \InvalidArgumentException("Referensi SOP tidak ditemukan pada katalog resmi: {$kode}");
                }

                $doc = $sopByCode[$kode];
                $dokumenSop[] = [
                    'kode' => $doc['kode'],
                    'nama' => $doc['nama'],
                    'dokumen' => $doc['dokumen'],
                    'url' => $doc['url'],
                ];
            }

            $service['dokumen_sop'] = $dokumenSop;
            $service['has_dedicated_sop'] = (bool) ($service['has_dedicated_sop'] ?? ! empty($dokumenSop));
            $service['spans_two_cols'] = false;

            $resolvedServices[] = $service;
        }

        // Jaga kartu spotlight & sel tunggal terakhir pada grid 2 kolom agar selaras antara SSR dan filter JS
        $openColumn = 0;
        $serviceCount = count($resolvedServices);
        foreach ($resolvedServices as $index => $serviceItem) {
            $isSpotlight = ! empty($serviceItem['sorotan_alur']);
            if ($isSpotlight) {
                if ($openColumn === 1 && $index > 0) {
                    $resolvedServices[$index - 1]['spans_two_cols'] = true;
                }
                $resolvedServices[$index]['spans_two_cols'] = true;
                $openColumn = 0;
            } else {
                $openColumn = ($openColumn + 1) % 2;
            }
        }
        if ($openColumn === 1 && $serviceCount > 0) {
            $resolvedServices[$serviceCount - 1]['spans_two_cols'] = true;
        }

        return $resolvedServices;
    }

    /**
     * Turunkan jumlah layanan tiap tombol filter langsung dari koleksi layanan terkonfigurasi.
     *
     * @param  array<int, array<string, mixed>>  $services
     * @return array<int, array{key: string, label: string, count: int}>
     */
    private function buildServiceFilters(array $services): array
    {
        $groupCounts = [];
        foreach ($services as $service) {
            $group = (string) ($service['filter_group'] ?? 'domain');
            $groupCounts[$group] = ($groupCounts[$group] ?? 0) + 1;
        }

        $filters = [];
        foreach (self::SERVICE_FILTER_LABELS as $key => $label) {
            $filters[] = [
                'key' => $key,
                'label' => $label,
                'count' => $key === 'semua' ? count($services) : ($groupCounts[$key] ?? 0),
            ];
        }

        return $filters;
    }
}

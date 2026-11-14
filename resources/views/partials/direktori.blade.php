<section id="direktori" aria-labelledby="direktori-judul" class="border-b border-[#d6ded7] bg-[#f6f5f0] py-14 lg:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
         data-directory-root
         data-scroll-section
         data-scroll-fade-only
         data-active-tab="{{ $activeTab }}"
         data-web-category="{{ $activeWebCategory }}"
         data-per-page="{{ $perPage }}">
        <div class="max-w-3xl">
            <h2 id="direktori-judul" class="font-display text-2xl font-bold tracking-[-0.02em] text-[#10231b] sm:text-[1.875rem] sm:leading-[1.15]">
                Direktori Aplikasi, Website &amp; Desa.id
            </h2>
            <p class="mt-2.5 text-sm leading-relaxed text-[#3f5249]">
                Penelusuran lengkap {{ $direktoriSummary['app_rows'] }} perangkat daerah ({{ $direktoriSummary['app_items'] }} aplikasi), {{ $direktoriSummary['web_items'] }} situs resmi bogorkab.go.id, dan {{ $direktoriSummary['desa_items'] }} website desa.id sesuai basis data TALAS BOGOR.
            </p>
            <div class="mt-4 inline-flex flex-wrap items-center gap-x-3 gap-y-1.5 rounded-lg border border-[#d6ded7] bg-white px-3.5 py-2 text-xs text-[#3f5249] shadow-2xs">
                <span class="font-semibold text-[#784f14]">Rekapitulasi Basis Data</span>
                <span class="text-[#cfd9d2]" aria-hidden="true">/</span>
                <span>
                    Total teregistrasi: <strong class="font-display font-bold tabular-nums text-[#10231b]">{{ number_format($direktoriSummary['total_entries'], 0, ',', '.') }}</strong> entri ({{ number_format($direktoriSummary['total_rows'], 0, ',', '.') }} baris tabel)
                </span>
                <span class="hidden text-[#cfd9d2] sm:inline" aria-hidden="true">/</span>
                <span class="text-[#3f5249]">Data {{ $meta['tanggal_observasi'] }}</span>
            </div>
        </div>

        <div class="mt-7 overflow-hidden rounded-2xl border border-[#cfd9d2] bg-white shadow-[0_16px_40px_-24px_rgba(16,35,27,0.16)]">
            <div aria-hidden="true" class="h-[3px] w-full bg-[#1b4332]"></div>

            {{-- Dek Kontrol Utama: Tab Direktori Berindikator Geser + Pencarian --}}
            <div class="border-b border-[#d6ded7] bg-[#f8faf8] p-3.5 sm:px-5 sm:py-4">
                <div class="flex flex-col gap-3.5 xl:flex-row xl:items-center xl:justify-between">
                    <div role="tablist"
                         aria-label="Kategori Direktori TALAS BOGOR"
                         data-glide-dir-tabs
                         class="relative flex flex-col gap-1 rounded-xl border border-[#cfd9d2] bg-[#eaefe9] p-1 sm:inline-flex sm:flex-row sm:flex-wrap lg:flex-nowrap">
                        @foreach ($direktori as $tabKey => $tabData)
                            @php
                                $isSelected = $activeTab === $tabKey;
                            @endphp
                            <a id="tab-{{ $tabKey }}"
                               href="{{ route('beranda', array_filter(['tab' => $tabKey, 'q' => $searchQuery !== '' ? $searchQuery : null])) }}#direktori"
                               role="tab"
                               aria-selected="{{ $isSelected ? 'true' : 'false' }}"
                               aria-controls="panel-{{ $tabKey }}"
                               tabindex="{{ $isSelected ? '0' : '-1' }}"
                               data-dir-tab="{{ $tabKey }}"
                               class="talas-transition relative z-10 inline-flex min-h-[44px] w-full items-center justify-between gap-2.5 whitespace-nowrap rounded-lg border px-3.5 py-2 text-sm font-bold sm:w-auto sm:justify-start {{ $isSelected ? 'border-[#1b4332] bg-[#1b4332] text-white' : 'border-transparent bg-transparent text-[#3f5249] hover:text-[#10231b]' }}">
                                <span>{{ $tabData['judul'] }}</span>
                                <span data-dir-tab-badge
                                      class="rounded-md px-2 py-0.5 font-mono text-xs font-bold tabular-nums {{ $isSelected ? 'bg-white/20 text-white' : 'bg-white/90 text-[#10231b]' }}">
                                    {{ number_format($tabData['total_item'], 0, ',', '.') }}
                                </span>
                            </a>
                        @endforeach
                    </div>

                    <form method="GET"
                          action="{{ route('beranda') }}#direktori"
                          class="flex w-full flex-wrap items-center gap-2 sm:w-auto sm:flex-nowrap">
                        <input type="hidden" name="tab" value="{{ $activeTab }}" data-dir-active-input>
                        <input type="hidden" name="web_cat" value="{{ $activeWebCategory }}" data-dir-webcat-input>
                        <label for="direktori-cari" class="sr-only">Cari direktori perangkat daerah, website, atau desa</label>
                        <div class="relative flex-1 sm:w-68 sm:flex-none">
                            <i data-lucide="search" class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2 text-[#3f5249]" aria-hidden="true"></i>
                            <input id="direktori-cari"
                                   type="search"
                                   name="q"
                                   value="{{ $searchQuery }}"
                                   maxlength="80"
                                   placeholder="Cari OPD, domain, atau desa..."
                                   data-dir-search
                                   class="min-h-[44px] w-full rounded-lg border border-[#cfd9d2] bg-white py-2 pr-3.5 pl-9.5 text-sm text-[#10231b] shadow-2xs transition-colors placeholder:text-[#3f5249]/75 focus:border-[#1b4332]">
                        </div>
                        <button type="submit"
                                class="talas-transition inline-flex min-h-[44px] shrink-0 cursor-pointer items-center justify-center rounded-lg bg-[#1b4332] px-4 py-2 text-sm font-bold text-white hover:bg-[#143325] active:scale-[0.98]">
                            Cari
                        </button>
                        <a href="{{ route('beranda', ['tab' => $activeTab]) }}#direktori"
                           data-dir-reset
                           class="{{ $hasActiveFilter ? 'inline-flex' : 'hidden' }} talas-transition min-h-[44px] shrink-0 items-center justify-center rounded-lg border border-[#cfd9d2] bg-white px-3.5 py-2 text-sm font-semibold text-[#3f5249] hover:border-[#1b4332] hover:text-[#10231b]">
                            Reset
                        </a>
                    </form>
                </div>
            </div>

            <div class="relative overflow-hidden" data-dir-stage>
                @foreach ($direktori as $tabKey => $tabData)
                    @php
                        $isActivePanel = $activeTab === $tabKey;
                        $rows = $tabData['rows'] ?? [];
                        $filteredTotal = (int) ($tabData['filtered_total'] ?? count($rows));
                        $currentPage = (int) ($tabData['current_page'] ?? 1);
                        $totalPages = (int) ($tabData['total_pages'] ?? 1);
                        $kpiCards = $tabData['kartu_kpi'] ?? [];
                    @endphp
                    <div id="panel-{{ $tabKey }}"
                         role="tabpanel"
                         aria-labelledby="tab-{{ $tabKey }}"
                         data-dir-panel="{{ $tabKey }}"
                         data-current-page="{{ $currentPage }}"
                         class="{{ $isActivePanel ? '' : 'hidden' }}">
                        {{-- Strip Telemetri 4 Kolom Terbagi Garis Halus --}}
                        <dl class="grid grid-cols-2 border-b border-[#d6ded7] bg-white sm:grid-cols-4">
                            @foreach ($kpiCards as $kpi)
                                @php
                                    $nada = $kpi['nada'] ?? 'neutral';
                                    $cellBg = match ($nada) {
                                        'primary' => 'bg-[#f2f6f3] shadow-[inset_0_3px_0_#1b4332]',
                                        'amber' => 'bg-[#fdfaf2] shadow-[inset_0_3px_0_#d49b35]',
                                        default => 'bg-white',
                                    };
                                    $valueTone = match ($nada) {
                                        'primary' => 'text-[#1b4332]',
                                        'emerald' => 'text-[#166534]',
                                        'amber' => 'text-[#926018]',
                                        default => 'text-[#10231b]',
                                    };
                                    $cellBorder = ($loop->odd ? 'border-r ' : '')
                                        . ($loop->index < 2 ? 'border-b sm:border-b-0 ' : '')
                                        . ($loop->last ? 'sm:border-r-0 ' : 'sm:border-r ')
                                        . 'border-[#e4ebe6]';
                                @endphp
                                <div class="{{ $cellBorder }} px-4 py-3 sm:px-5 sm:py-3.5 {{ $cellBg }}">
                                    <dt class="text-[11px] font-bold tracking-wide text-[#3f5249] uppercase">{{ $kpi['label'] }}</dt>
                                    <dd class="font-display mt-1 text-xl font-bold tracking-tight tabular-nums sm:text-2xl {{ $valueTone }}">{{ $kpi['nilai'] }}</dd>
                                </div>
                            @endforeach
                        </dl>

                        {{-- Baris Konteks & Tautan Sub-Dashboard Resmi --}}
                        <div class="border-b border-[#dce4de] bg-[#f8faf8] px-4 py-3.5 sm:px-5 sm:py-4">
                            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                                <div class="min-w-0 space-y-1">
                                    <p class="text-sm font-bold text-[#10231b]">{{ $tabData['subjudul'] ?? $tabData['judul'] }}</p>
                                    @if ($tabKey === 'aplikasi')
                                        <p class="text-xs leading-relaxed text-[#3f5249]">{{ $tabData['hosting_ringkas'] ?? '' }}</p>
                                        @if (! empty($tabData['jenis_ringkas']))
                                            <p class="text-xs leading-relaxed text-[#3f5249]"><strong class="font-semibold text-[#10231b]">Sifat Layanan:</strong> {{ $tabData['jenis_ringkas'] }}</p>
                                        @endif
                                        @if (! empty($tabData['assesment_ringkas']))
                                            <p class="text-xs leading-relaxed text-[#3f5249]">
                                                <strong class="font-semibold text-[#10231b]">Asesmen Layanan ({{ $tabData['assesment_ringkas']['total_dinilai'] }}/{{ $tabData['assesment_ringkas']['total_aplikasi'] }}):</strong>
                                                {{ $tabData['assesment_ringkas']['aspek'] }}
                                            </p>
                                        @endif
                                    @elseif ($tabKey === 'desaid')
                                        <p class="text-xs leading-relaxed text-[#3f5249]">Sesuai <strong class="font-semibold text-[#10231b]">Permenkominfo Nomor 5 Tahun 2015</strong> &middot; Riwayat registrasi: {{ $tabData['riwayat_tahunan'] ?? '' }}</p>
                                    @else
                                        <p class="text-xs leading-relaxed text-[#3f5249]">{{ $tabData['wilayah_ringkas'] ?? '' }}</p>
                                        @if (! empty($tabData['scoreweb_formula']))
                                            <p class="text-xs leading-relaxed text-[#3f5249]">
                                                <strong class="font-semibold text-[#10231b]">Rumus Scoreweb:</strong> {{ $tabData['scoreweb_formula'] }}
                                            </p>
                                        @endif
                                    @endif
                                </div>

                                @if ($tabKey === 'aplikasi')
                                    <div class="flex shrink-0 flex-wrap items-center gap-2">
                                        <a href="{{ $meta['dashboard_layanan_url'] }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="talas-transition inline-flex min-h-[44px] items-center gap-1.5 rounded-lg border border-[#c5d3c9] bg-white px-3.5 py-2 text-xs font-bold text-[#1b4332] shadow-2xs hover:border-[#1b4332] hover:bg-[#1b4332] hover:text-white">
                                            <i data-lucide="server" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                            <span>Sebaran Server &amp; Layanan</span>
                                            <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{ $meta['assesment_url'] }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="talas-transition inline-flex min-h-[44px] items-center gap-1.5 rounded-lg border border-[#c5d3c9] bg-white px-3.5 py-2 text-xs font-bold text-[#1b4332] shadow-2xs hover:border-[#1b4332] hover:bg-[#1b4332] hover:text-white">
                                            <i data-lucide="clipboard-check" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                            <span>Asesmen 57 Layanan</span>
                                            <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                @elseif ($tabKey === 'website' && ! empty($tabData['scoreweb_links']))
                                    <div class="flex shrink-0 flex-wrap items-center gap-2">
                                        @foreach ($tabData['scoreweb_links'] as $scoreLink)
                                            <a href="{{ $scoreLink['url'] }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="talas-transition inline-flex min-h-[44px] items-center gap-1.5 rounded-lg border border-[#c5d3c9] bg-white px-3.5 py-2 text-xs font-bold text-[#1b4332] shadow-2xs hover:border-[#1b4332] hover:bg-[#1b4332] hover:text-white">
                                                <i data-lucide="bar-chart-3" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                                <span>{{ $scoreLink['label'] }}</span>
                                                <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($tabKey === 'website')
                            <div class="flex flex-wrap items-center justify-between gap-2.5 border-b border-[#dce4de] bg-[#f2f6f3] px-4 py-2.5 sm:px-5">
                                <span class="font-mono text-[11px] font-bold tracking-wide text-[#3f5249] uppercase">
                                    Filter Kategori Website
                                </span>
                                <div data-glide-web-cat
                                     class="relative flex flex-wrap items-center gap-1 rounded-xl border border-[#cfd9d2] bg-white p-1 shadow-2xs"
                                     role="group"
                                     aria-label="Filter kategori website bogorkab.go.id">
                                    @foreach ($webCategories as $catCode => $catLabel)
                                        @php
                                            $isCatActive = $activeWebCategory === $catCode;
                                        @endphp
                                        <a href="{{ route('beranda', array_filter(['tab' => 'website', 'web_cat' => $catCode !== 'SEMUA' ? $catCode : null, 'q' => $searchQuery !== '' ? $searchQuery : null])) }}#direktori"
                                           data-web-cat="{{ $catCode }}"
                                           aria-pressed="{{ $isCatActive ? 'true' : 'false' }}"
                                           class="talas-transition relative z-10 inline-flex min-h-[44px] items-center rounded-lg border px-3 py-1.5 text-xs font-bold {{ $isCatActive ? 'border-[#1b4332] bg-[#1b4332] text-white' : 'border-transparent bg-transparent text-[#3f5249] hover:text-[#10231b]' }}">
                                            {{ $catLabel }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Panggung Tabel & Kartu Seluler dengan Transisi Geser Kiri/Kanan --}}
                        <div data-dir-table-stage="{{ $tabKey }}" class="relative overflow-hidden bg-white">
                            {{-- Tampilan Terstruktur pada Layar Kecil (< 768px) --}}
                            <div data-dir-mobile-body="{{ $tabKey }}" class="divide-y divide-[#e5ebe6] md:hidden">
                                @foreach ($rows as $row)
                                    <div data-dir-row class="p-4">
                                        @if ($tabKey === 'aplikasi')
                                            <div class="flex items-center justify-between gap-2">
                                                <span class="text-sm font-bold text-[#10231b]">{{ $row['instansi'] }}</span>
                                                <span class="rounded-md border border-[#c8d6cc] bg-[#f2f6f3] px-2.5 py-0.5 font-mono text-xs font-bold tabular-nums text-[#1b4332]">
                                                    {{ $row['jumlah'] }} aplikasi
                                                </span>
                                            </div>
                                            <dl class="mt-2.5 grid grid-cols-2 gap-x-4 gap-y-1 text-xs text-[#3f5249]">
                                                <div>Prioritas: <strong class="font-mono tabular-nums text-[#10231b]">{{ $row['prioritas'] }}</strong></div>
                                                <div>Tematik: <strong class="font-mono tabular-nums text-[#10231b]">{{ $row['tematik'] }}</strong></div>
                                                <div>Instansional: <strong class="font-mono tabular-nums text-[#10231b]">{{ $row['instansional'] }}</strong></div>
                                                <div>Lainnya: <strong class="font-mono tabular-nums text-[#10231b]">{{ $row['lainnya'] }}</strong></div>
                                            </dl>
                                        @elseif ($tabKey === 'website')
                                            <div class="flex items-start justify-between gap-2">
                                                <span class="text-sm font-bold text-[#10231b]">{{ $row['instansi'] }}</span>
                                                <span class="rounded-md border border-[#c8d6cc] bg-[#f2f6f3] px-2 py-0.5 font-mono text-[11px] font-bold text-[#1b4332]">
                                                    {{ $row['kategori'] }}
                                                </span>
                                            </div>
                                            <a href="{{ $row['url'] ?? 'https://' . $row['domain'] }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="mt-1.5 inline-flex items-center gap-1 break-all font-mono text-xs font-semibold text-[#1b4332] hover:underline">
                                                <span>{{ $row['domain'] }}</span>
                                            </a>
                                        @else
                                            <div class="flex items-start justify-between gap-2">
                                                <span class="text-sm font-bold text-[#10231b]">Desa {{ $row['desa'] }}</span>
                                                <span class="rounded-md border border-[#b9d4c2] bg-[#edf6f0] px-2 py-0.5 text-[11px] font-bold text-[#166534]">
                                                    {{ $row['register'] ?? $row['status'] ?? 'Sudah' }}
                                                </span>
                                            </div>
                                            <a href="{{ $row['url'] ?? 'http://' . $row['domain'] }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="mt-1.5 inline-flex items-center gap-1 break-all font-mono text-xs font-semibold text-[#1b4332] hover:underline">
                                                <span>{{ $row['domain'] }}</span>
                                            </a>
                                            <p class="mt-1 text-xs text-[#3f5249]">Kecamatan {{ $row['kecamatan'] }} &middot; <span class="font-mono font-semibold">{{ $row['platform'] }}</span></p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            {{-- Tampilan Tabel Desktop (>= 768px) --}}
                            <div class="hidden overflow-x-auto md:block">
                                @if ($tabKey === 'aplikasi')
                                    <table class="min-w-full divide-y divide-[#dfe7e1] text-left text-sm">
                                        <caption class="sr-only">Daftar 42 instansi dan jumlah aplikasi perangkat daerah Kabupaten Bogor</caption>
                                        <thead class="bg-[#f4f7f4] text-[11px] font-bold tracking-[0.04em] text-[#3f5249] uppercase">
                                            <tr>
                                                <th scope="col" class="w-16 px-5 py-3.5">No</th>
                                                <th scope="col" class="px-5 py-3.5">Perangkat Daerah / Instansi</th>
                                                <th scope="col" class="w-28 bg-[#ebf1ec]/75 px-5 py-3.5 text-right text-[#1b4332]">Total</th>
                                                <th scope="col" class="w-28 px-5 py-3.5 text-right">Prioritas</th>
                                                <th scope="col" class="w-28 px-5 py-3.5 text-right">Tematik</th>
                                                <th scope="col" class="w-28 px-5 py-3.5 text-right">Instansional</th>
                                                <th scope="col" class="w-28 px-5 py-3.5 text-right">Lainnya</th>
                                            </tr>
                                        </thead>
                                        <tbody data-dir-table-body="aplikasi" class="divide-y divide-[#e6ece8] text-[#10231b]">
                                            @foreach ($rows as $row)
                                                <tr data-dir-row class="transition-colors duration-150 even:bg-[#fafbf9] hover:bg-[#edf2ed]/65">
                                                    <td class="px-5 py-3.5 font-mono text-xs font-semibold tabular-nums text-[#3f5249]">{{ $row['no'] }}</td>
                                                    <td class="px-5 py-3.5 font-bold text-[#10231b]">{{ $row['instansi'] }}</td>
                                                    <td class="bg-[#f4f8f5] px-5 py-3.5 text-right font-mono text-sm font-bold tabular-nums text-[#1b4332]">{{ $row['jumlah'] }}</td>
                                                    <td class="px-5 py-3.5 text-right font-mono text-xs tabular-nums {{ (int) $row['prioritas'] > 0 ? 'font-bold text-[#10231b]' : 'text-[#54665d]' }}">{{ $row['prioritas'] }}</td>
                                                    <td class="px-5 py-3.5 text-right font-mono text-xs tabular-nums {{ (int) $row['tematik'] > 0 ? 'font-bold text-[#10231b]' : 'text-[#54665d]' }}">{{ $row['tematik'] }}</td>
                                                    <td class="px-5 py-3.5 text-right font-mono text-xs tabular-nums {{ (int) $row['instansional'] > 0 ? 'font-bold text-[#10231b]' : 'text-[#54665d]' }}">{{ $row['instansional'] }}</td>
                                                    <td class="px-5 py-3.5 text-right font-mono text-xs tabular-nums {{ (int) $row['lainnya'] > 0 ? 'font-bold text-[#10231b]' : 'text-[#54665d]' }}">{{ $row['lainnya'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @elseif ($tabKey === 'website')
                                    <table class="min-w-full divide-y divide-[#dfe7e1] text-left text-sm">
                                        <caption class="sr-only">Daftar 100 website resmi domain bogorkab.go.id Kabupaten Bogor</caption>
                                        <thead class="bg-[#f4f7f4] text-[11px] font-bold tracking-[0.04em] text-[#3f5249] uppercase">
                                            <tr>
                                                <th scope="col" class="w-16 px-5 py-3.5">No</th>
                                                <th scope="col" class="w-[42%] px-5 py-3.5">Instansi / Wilayah</th>
                                                <th scope="col" class="px-5 py-3.5">Domain Resmi</th>
                                                <th scope="col" class="w-40 px-5 py-3.5">Kategori</th>
                                            </tr>
                                        </thead>
                                        <tbody data-dir-table-body="website" class="divide-y divide-[#e6ece8] text-[#10231b]">
                                            @foreach ($rows as $row)
                                                <tr data-dir-row class="transition-colors duration-150 even:bg-[#fafbf9] hover:bg-[#edf2ed]/65">
                                                    <td class="px-5 py-3.5 font-mono text-xs font-semibold tabular-nums text-[#3f5249]">{{ $row['no'] }}</td>
                                                    <td class="px-5 py-3.5 font-bold text-[#10231b]">{{ $row['instansi'] }}</td>
                                                    <td class="px-5 py-3.5 font-mono text-xs font-semibold">
                                                        <a href="{{ $row['url'] ?? 'https://' . $row['domain'] }}"
                                                           target="_blank"
                                                           rel="noopener noreferrer"
                                                           class="text-[#1b4332] hover:text-[#0b2017] hover:underline">{{ $row['domain'] }}</a>
                                                    </td>
                                                    <td class="px-5 py-3.5">
                                                        <span class="inline-flex items-center rounded-md border border-[#c8d6cc] bg-[#f2f6f3] px-2.5 py-0.5 font-mono text-[11px] font-bold text-[#1b4332]">
                                                            {{ $row['kategori'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <table class="min-w-full divide-y divide-[#dfe7e1] text-left text-sm">
                                        <caption class="sr-only">Daftar 416 domain website desa desa.id Kabupaten Bogor</caption>
                                        <thead class="bg-[#f4f7f4] text-[11px] font-bold tracking-[0.04em] text-[#3f5249] uppercase">
                                            <tr>
                                                <th scope="col" class="w-16 px-5 py-3.5">No</th>
                                                <th scope="col" class="px-5 py-3.5">Domain desa.id</th>
                                                <th scope="col" class="px-5 py-3.5">Desa</th>
                                                <th scope="col" class="px-5 py-3.5">Kecamatan</th>
                                                <th scope="col" class="w-28 px-5 py-3.5">Status</th>
                                                <th scope="col" class="w-32 px-5 py-3.5">Platform</th>
                                            </tr>
                                        </thead>
                                        <tbody data-dir-table-body="desaid" class="divide-y divide-[#e6ece8] text-[#10231b]">
                                            @foreach ($rows as $row)
                                                <tr data-dir-row class="transition-colors duration-150 even:bg-[#fafbf9] hover:bg-[#edf2ed]/65">
                                                    <td class="px-5 py-3.5 font-mono text-xs font-semibold tabular-nums text-[#3f5249]">{{ $row['no'] }}</td>
                                                    <td class="px-5 py-3.5 font-mono text-xs font-semibold">
                                                        <a href="{{ $row['url'] ?? 'http://' . $row['domain'] }}"
                                                           target="_blank"
                                                           rel="noopener noreferrer"
                                                           class="text-[#1b4332] hover:text-[#0b2017] hover:underline">{{ $row['domain'] }}</a>
                                                    </td>
                                                    <td class="px-5 py-3.5 font-bold text-[#10231b]">{{ $row['desa'] }}</td>
                                                    <td class="px-5 py-3.5 text-[#3f5249]">{{ $row['kecamatan'] }}</td>
                                                    <td class="px-5 py-3.5">
                                                        <span class="inline-flex items-center rounded-md border border-[#b9d4c2] bg-[#edf6f0] px-2.5 py-0.5 text-xs font-bold text-[#166534]">
                                                            {{ $row['register'] ?? $row['status'] ?? 'Sudah' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-5 py-3.5 font-mono text-xs font-semibold text-[#3f5249]">{{ $row['platform'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>

                            <div data-dir-empty="{{ $tabKey }}" class="{{ $filteredTotal > 0 ? 'hidden' : '' }} border-t border-[#e5ebe6] bg-[#f6f5f0] px-4 py-8 text-center">
                                <p class="text-sm font-bold text-[#10231b]">
                                    Tidak ditemukan data yang cocok pada direktori {{ $tabData['judul'] }}.
                                </p>
                                <p class="mt-1 text-xs text-[#3f5249]">
                                    Coba kata kunci lain seperti nama instansi, kecamatan, atau domain, atau reset pencarian untuk melihat seluruh daftar.
                                </p>
                            </div>
                        </div>

                        {{-- Footer Tabel: Paginasi 10 Baris + Tautan Dashboard Resmi --}}
                        <div class="flex flex-col justify-between gap-3 border-t border-[#d6ded7] bg-[#f8faf8] px-5 py-3.5 text-xs text-[#3f5249] sm:flex-row sm:items-center">
                            <span data-dir-summary="{{ $tabKey }}">
                                Menampilkan <strong class="tabular-nums text-[#10231b]">{{ count($rows) }}</strong> dari <strong class="tabular-nums text-[#10231b]">{{ number_format($filteredTotal, 0, ',', '.') }}</strong> baris data {{ $tabData['judul_singkat'] ?? '' }}
                            </span>

                            <div class="flex flex-wrap items-center gap-2">
                                <nav aria-label="Paginasi {{ $tabData['judul'] }}" class="inline-flex items-center gap-1.5" data-dir-pagination="{{ $tabKey }}">
                                    @php
                                        $prevPage = max(1, $currentPage - 1);
                                        $nextPage = min($totalPages, $currentPage + 1);
                                    @endphp
                                    <a href="{{ route('beranda', array_filter(['tab' => $tabKey, 'q' => $searchQuery !== '' ? $searchQuery : null, 'web_cat' => $tabKey === 'website' && $activeWebCategory !== 'SEMUA' ? $activeWebCategory : null, 'page' => $prevPage])) }}#direktori"
                                       data-dir-page-btn="prev"
                                       aria-disabled="{{ $currentPage <= 1 ? 'true' : 'false' }}"
                                       class="talas-transition inline-flex min-h-[44px] items-center gap-1 rounded-lg border border-[#cfd9d2] bg-white px-3 font-bold text-[#10231b] shadow-2xs hover:border-[#1b4332] {{ $currentPage <= 1 ? 'pointer-events-none opacity-45' : '' }}">
                                        <i data-lucide="chevron-left" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                        <span>Sebelumnya</span>
                                    </a>

                                    <span data-dir-page-info="{{ $tabKey }}" class="inline-flex min-h-[44px] items-center rounded-md border border-[#dce4de] bg-white px-3 font-mono font-bold tabular-nums text-[#10231b]">
                                        Hal. {{ $currentPage }} / {{ $totalPages }}
                                    </span>

                                    <a href="{{ route('beranda', array_filter(['tab' => $tabKey, 'q' => $searchQuery !== '' ? $searchQuery : null, 'web_cat' => $tabKey === 'website' && $activeWebCategory !== 'SEMUA' ? $activeWebCategory : null, 'page' => $nextPage])) }}#direktori"
                                       data-dir-page-btn="next"
                                       aria-disabled="{{ $currentPage >= $totalPages ? 'true' : 'false' }}"
                                       class="talas-transition inline-flex min-h-[44px] items-center gap-1 rounded-lg border border-[#cfd9d2] bg-white px-3 font-bold text-[#10231b] shadow-2xs hover:border-[#1b4332] {{ $currentPage >= $totalPages ? 'pointer-events-none opacity-45' : '' }}">
                                        <span>Berikutnya</span>
                                        <i data-lucide="chevron-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                    </a>
                                </nav>

                                <a href="{{ $meta['dashboard_layanan_url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex min-h-[44px] items-center gap-1 px-1.5 font-bold text-[#1b4332] hover:underline sm:ml-1">
                                    <span>Dashboard Layanan</span>
                                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script type="application/json" id="talas-directory-data">@json($directoryDataset)</script>
    </div>
</section>

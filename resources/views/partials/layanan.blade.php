@php
    $portalLoginUrl = $loginUrl ?? 'https://talas.bogorkab.go.id/?slogin=1';
    $servicesJson = collect($layananUtama)->keyBy('slug')->map(function (array $item) use ($sopArchiveUrl) {
        return [
            'slug' => $item['slug'],
            'nama' => $item['nama'],
            'kategori' => $item['kategori'],
            'sasaran' => $item['sasaran'],
            'kode_sop' => $item['kode_sop'],
            'has_dedicated_sop' => (bool) ($item['has_dedicated_sop'] ?? ! empty($item['dokumen_sop'])),
            'mutu_baku' => $item['mutu_baku'],
            'pelaksana' => $item['pelaksana'],
            'ringkasan' => $item['ringkasan'],
            'rujukan_sop' => $item['rujukan_sop'],
            'syarat_catatan' => $item['syarat_catatan'] ?? '',
            'kelengkapan' => $item['kelengkapan'],
            'alur' => $item['alur'] ?? [],
            'dasar_hukum' => $item['dasar_hukum'],
            'dokumen_sop' => $item['dokumen_sop'] ?? [],
            'sop_archive_url' => $sopArchiveUrl,
        ];
    })->all();
@endphp

<script id="talas-services-json" type="application/json">@json($servicesJson)</script>

<section id="layanan" aria-labelledby="layanan-judul" class="border-b border-[#d6ded7] bg-[#f8faf8] py-14 lg:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-12 lg:gap-10">
            {{-- Panel Kiri Sticky: Indeks Kategori & Desk Layanan --}}
            <div data-scroll-section class="lg:col-span-4 lg:sticky lg:top-24 lg:self-start">
                <h2 id="layanan-judul" class="font-display text-2xl font-bold tracking-[-0.02em] text-[#10231b] sm:text-[1.875rem] sm:leading-[1.15]">
                    Layanan TALAS BOGOR
                </h2>
                <p class="mt-2.5 text-sm leading-relaxed text-[#3f5249]">
                    9 layanan digital resmi Diskominfo Kabupaten Bogor untuk permohonan domain, hosting, email dinas, otorisasi operator, pengujian keamanan, dan pemulihan gangguan website.
                </p>

                <div class="mt-6 overflow-hidden rounded-xl border border-[#d6ded7] bg-white shadow-2xs">
                    <div data-glide-service-filter
                         class="relative"
                         role="group"
                         aria-label="Filter kategori layanan">
                        @foreach ($serviceFilters as $filter)
                            @php
                                $isDefault = $filter['key'] === 'semua';
                            @endphp
                            <button type="button"
                                    data-service-filter="{{ $filter['key'] }}"
                                    aria-pressed="{{ $isDefault ? 'true' : 'false' }}"
                                    class="talas-transition relative z-10 flex min-h-[46px] w-full cursor-pointer items-center justify-between gap-3 border-b border-[#e6ece8] px-4 py-2.5 text-left text-sm last:border-b-0 {{ $isDefault ? 'bg-[#edf2ed] font-bold text-[#10231b] shadow-[inset_3.5px_0_0_#1b4332]' : 'bg-white font-medium text-[#3f5249] hover:bg-[#f6f5f0]/70 hover:text-[#10231b]' }}">
                                <span>{{ $filter['label'] }}</span>
                                <span data-service-filter-badge
                                      class="rounded-md px-2 py-0.5 font-mono text-xs tabular-nums {{ $isDefault ? 'bg-[#1b4332] font-bold text-white' : 'bg-[#edf2ed] font-semibold text-[#3f5249]' }}">
                                    {{ $filter['count'] }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                    <p data-service-status
                       aria-live="polite"
                       class="border-t border-[#e5ebe6] bg-[#f8faf8] px-4 py-2.5 text-xs font-medium text-[#3f5249]">
                        Menampilkan {{ count($layananUtama) }} layanan utama portal
                    </p>
                </div>

                <aside aria-label="Dokumentasi SOP dan akses tiket resmi"
                       class="mt-5 overflow-hidden rounded-xl border border-[#d6ded7] bg-white shadow-2xs">
                    <div class="bg-[#f6f5f0]/80 p-4 sm:p-5">
                        <div class="flex items-start gap-3.5">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-[#d6ded7] bg-white p-1.5 shadow-2xs" aria-hidden="true">
                                <img src="{{ asset('images/icons/layanan/sop-document.svg') }}"
                                     alt=""
                                     width="32"
                                     height="32"
                                     class="h-full w-full object-contain"
                                     aria-hidden="true">
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-[#784f14]">
                                    Panduan Prosedur &amp; SOP
                                </p>
                                <h3 class="mt-0.5 text-sm font-bold text-[#10231b]">
                                    Arsip {{ count($sopList) }} SOP &amp; Portal Tiket
                                </h3>
                            </div>
                        </div>

                        <p class="mt-3 text-xs leading-relaxed text-[#3f5249]">
                            Pengajuan layanan dan penanganan gangguan diproses terpusat setelah operator SKPD, Kecamatan, atau Desa masuk ke portal resmi.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 divide-x divide-[#dce4de] border-t border-[#dce4de] bg-white">
                        <a href="#layanan-sop"
                           data-sop-jump
                           class="talas-transition inline-flex min-h-[44px] items-center justify-center gap-1.5 px-3 py-2.5 text-xs font-bold text-[#1b4332] hover:bg-[#edf2ed]">
                            <span>Lihat {{ count($sopList) }} SOP</span>
                            <i data-lucide="chevron-down" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                        </a>

                        <a href="{{ $portalLoginUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="talas-transition inline-flex min-h-[44px] items-center justify-center gap-1.5 bg-[#1b4332] px-3 py-2.5 text-xs font-bold text-white hover:bg-[#143325]">
                            <span>Portal Tiket</span>
                            <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                        </a>
                    </div>
                </aside>
            </div>

            {{-- Panel Kanan: Lembar Katalog Dua-Zona + Sorotan Pemulihan Insiden --}}
            <div class="min-w-0 overflow-x-clip lg:col-span-8">
                <div data-service-list class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    @foreach ($layananUtama as $index => $item)
                        @php
                            $filterGroup = $item['filter_group'] ?? 'domain';
                            $hasHighlights = ! empty($item['sorotan_alur']);
                            $spansTwoCols = ! empty($item['spans_two_cols']);
                            $itemNumber = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                        @endphp

                        @if ($hasHighlights)
                            <article data-service-card
                                     data-service-group="{{ $filterGroup }}"
                                     data-service-spotlight="true"
                                     data-service-slug="{{ $item['slug'] }}"
                                     class="{{ $spansTwoCols ? 'md:col-span-2 ' : '' }}overflow-hidden rounded-xl border border-[#b8c9be] bg-white shadow-[0_14px_30px_-18px_rgba(16,35,27,0.16)]">
                                <div aria-hidden="true" class="h-[3.5px] w-full bg-[#d49b35]"></div>

                                <div class="p-5 sm:p-6">
                                    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-start gap-3.5">
                                                <span class="mt-0.5 flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#d6ded7] bg-[#f8faf8] p-2" aria-hidden="true">
                                                    <img src="{{ asset($item['icon_path']) }}"
                                                         alt=""
                                                         width="36"
                                                         height="36"
                                                         class="h-full w-full object-contain"
                                                         aria-hidden="true">
                                                </span>
                                                <div class="min-w-0 flex-1">
                                                    <p class="font-mono text-xs font-bold tracking-tight text-[#784f14]">
                                                        {{ $itemNumber }} &middot; Penanganan Gangguan ({{ $item['kode_sop'] }})
                                                    </p>
                                                    <h3 class="mt-0.5 text-lg font-bold leading-snug text-[#10231b] sm:text-xl">
                                                        {{ $item['nama'] }}
                                                    </h3>
                                                </div>
                                            </div>
                                            <p class="mt-3 max-w-[62ch] text-[13.5px] leading-relaxed text-[#3f5249]">
                                                {{ $item['ringkasan'] }} Insiden ditangani berurutan dari pencatatan tiket portal hingga audit ulang Tim CSIRT sebelum tayang kembali.
                                            </p>
                                        </div>

                                        <div class="flex w-full shrink-0 flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
                                            <button type="button"
                                                    data-open-service-modal
                                                    data-service-slug="{{ $item['slug'] }}"
                                                    class="talas-transition group/btn inline-flex min-h-[44px] w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-[#1b4332] px-4 py-2 text-xs font-bold whitespace-nowrap text-white hover:bg-[#143325] active:scale-[0.98] sm:w-auto">
                                                <span>Syarat &amp; Alur</span>
                                                <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 transition-transform duration-200 group-hover/btn:translate-x-0.5" aria-hidden="true"></i>
                                            </button>
                                            <a href="{{ $portalLoginUrl }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="talas-transition inline-flex min-h-[44px] w-full items-center justify-center gap-1.5 rounded-lg border border-[#d6ded7] bg-[#f8faf8] px-4 py-2 text-xs font-bold whitespace-nowrap text-[#1b4332] hover:border-[#1b4332] hover:bg-white active:scale-[0.98] sm:w-auto">
                                                <span>Portal Tiket</span>
                                                <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="talas-incident-steps border-t border-[#e5ebe6] bg-[#f6f5f0]/85 px-5 py-4 text-xs sm:px-6">
                                    @foreach ($item['sorotan_alur'] as $langkah)
                                        <div class="border-t border-[#dde5df] pt-2.5 first:border-t-0 first:pt-0 md:border-t-0 md:border-l md:pt-0 md:pl-4 md:first:border-l-0 md:first:pl-0">
                                            <p class="font-bold text-[#1b4332]">{{ $langkah['judul'] }}</p>
                                            <p class="mt-0.5 leading-relaxed text-[#3f5249]">{{ $langkah['ringkas'] }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex flex-wrap items-center justify-between gap-x-6 gap-y-1.5 border-t border-[#dce4de] bg-[#edf2ed]/60 px-5 py-3 text-xs text-[#3f5249] sm:px-6">
                                    <span>Sasaran: <strong class="font-semibold text-[#10231b]">{{ $item['sasaran'] }}</strong></span>
                                    <span class="tabular-nums">Mutu Baku: <strong class="font-semibold text-[#10231b]">{{ $item['mutu_baku'] }}</strong></span>
                                    <span>Pelaksana: <strong class="font-semibold text-[#10231b]">{{ $item['pelaksana'] }}</strong></span>
                                </div>
                            </article>
                        @else
                            <article data-service-card
                                     data-service-group="{{ $filterGroup }}"
                                     data-service-spotlight="false"
                                     data-service-slug="{{ $item['slug'] }}"
                                     class="{{ $spansTwoCols ? 'md:col-span-2 ' : '' }}group flex cursor-pointer flex-col justify-between overflow-hidden rounded-xl border border-[#d6ded7] bg-white shadow-2xs transition-all duration-200 hover:border-[#1b4332]/65 hover:shadow-[0_12px_26px_-18px_rgba(16,35,27,0.18)]">
                                <div class="p-5">
                                    <div class="flex items-start gap-3.5">
                                        <span class="mt-0.5 flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-[#e5ebe6] bg-[#f8faf8] p-2 transition-colors group-hover:border-[#cfd9d2] group-hover:bg-[#edf2ed]/75" aria-hidden="true">
                                            <img src="{{ asset($item['icon_path']) }}"
                                                 alt=""
                                                 width="36"
                                                 height="36"
                                                 class="h-full w-full object-contain"
                                                 aria-hidden="true">
                                        </span>

                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center justify-between gap-x-2 gap-y-1">
                                                <span class="min-w-0 text-xs font-bold text-[#784f14]">
                                                    <span class="font-mono tabular-nums">{{ $itemNumber }}</span> &middot; {{ $item['kategori'] }}
                                                </span>
                                                <span class="shrink-0 rounded-md border border-[#e5ebe6] bg-[#f8faf8] px-2 py-0.5 font-mono text-[11px] font-bold tracking-tight tabular-nums text-[#1b4332]">
                                                    {{ $item['kode_sop'] }}
                                                </span>
                                            </div>

                                            <h3 class="mt-1 text-[17px] font-bold leading-snug tracking-[-0.015em] text-[#10231b] transition-colors group-hover:text-[#1b4332]">
                                                {{ $item['nama'] }}
                                            </h3>

                                            <p class="mt-0.5 text-xs font-medium text-[#3f5249]">
                                                {{ $item['sasaran'] }}
                                            </p>
                                        </div>
                                    </div>

                                    <p class="mt-3.5 max-w-[60ch] text-[13.5px] leading-relaxed text-[#3f5249]">
                                        {{ $item['ringkasan'] }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between gap-3 border-t border-[#e5ebe6] bg-[#f8faf8] px-5 py-3 transition-colors group-hover:bg-[#eff5f0]">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold leading-snug tabular-nums text-[#10231b]">
                                            {{ $item['mutu_baku'] }}
                                        </p>
                                        <p class="mt-0.5 text-[11.5px] leading-snug text-[#3f5249]">
                                            {{ $item['pelaksana'] }}
                                        </p>
                                    </div>

                                    <button type="button"
                                            data-open-service-modal
                                            data-service-slug="{{ $item['slug'] }}"
                                            class="talas-transition group/btn -my-1 -mr-1.5 inline-flex min-h-[44px] shrink-0 cursor-pointer items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-bold whitespace-nowrap text-[#1b4332] hover:bg-[#dce8df] active:scale-[0.98]">
                                        <span>Syarat &amp; alur</span>
                                        <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 transition-transform duration-200 group-hover/btn:translate-x-0.5" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Arsip Ringkas 10 Dokumen SOP Resmi --}}
        <div id="layanan-sop" class="mt-10 overflow-hidden rounded-xl border border-[#d6ded7] bg-white shadow-2xs">
            <div class="flex flex-col gap-4 bg-[#f6f5f0]/75 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex min-w-0 items-start gap-3.5">
                    <img src="{{ asset('images/icons/layanan/sop-document.svg') }}"
                         alt=""
                         width="36"
                         height="36"
                         class="mt-0.5 h-9 w-9 shrink-0 object-contain"
                         aria-hidden="true">
                    <div class="min-w-0">
                        <h3 class="text-base font-bold text-[#10231b]">
                            {{ count($sopList) }} Dokumen SOP Pelayanan Resmi
                        </h3>
                        <p class="mt-0.5 text-xs leading-relaxed text-[#3f5249]">
                            Standar Operasional Prosedur Bidang Aplikasi Informatika Diskominfo (terdaftar pada portal resmi talas.bogorkab.go.id).
                        </p>
                    </div>
                </div>

                <div class="flex w-full shrink-0 flex-col gap-2.5 sm:w-auto sm:flex-row sm:items-center">
                    <a href="{{ $sopArchiveUrl }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="talas-transition inline-flex min-h-[44px] w-full items-center justify-center gap-1.5 rounded-lg border border-[#d6ded7] bg-white px-4 py-2 text-xs font-semibold whitespace-nowrap text-[#1b4332] hover:border-[#1b4332] sm:w-auto">
                        <span>Buka di Situs Asli</span>
                        <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                    </a>
                    <button type="button"
                            data-sop-toggle
                            aria-expanded="false"
                            aria-controls="daftar-sop-panel"
                            class="talas-transition inline-flex min-h-[44px] w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#1b4332] px-4 py-2 text-xs font-bold whitespace-nowrap text-white hover:bg-[#143325] active:scale-[0.98] sm:w-auto">
                        <span data-sop-toggle-label data-sop-count="{{ count($sopList) }}">Lihat {{ count($sopList) }} SOP</span>
                        <i data-lucide="chevron-down" data-sop-chevron class="h-4 w-4 shrink-0 transition-transform duration-200" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div id="daftar-sop-panel"
                 data-sop-panel
                 class="hidden border-t border-[#d6ded7] bg-white">
                <ol class="grid grid-cols-1 md:grid-cols-2">
                    @foreach ($sopList as $sop)
                        <li class="{{ $loop->first ? '' : 'border-t border-[#e5ebe6]' }} {{ $loop->index === 1 ? 'md:border-t-0' : '' }} md:odd:border-r md:odd:border-[#e5ebe6]">
                            <a href="{{ $sop['url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="talas-transition group flex min-h-[54px] items-center justify-between gap-4 px-5 py-3.5 hover:bg-[#f8faf8] sm:px-6">
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2 text-xs">
                                        <span class="font-mono font-bold tabular-nums text-[#1b4332]">{{ $sop['kode'] }}</span>
                                        <span class="text-[#c5d1c8]" aria-hidden="true">/</span>
                                        <span class="font-medium text-[#3f5249]">{{ $sop['kategori'] }}</span>
                                    </div>
                                    <p class="mt-0.5 text-sm font-semibold leading-snug text-[#10231b] group-hover:text-[#1b4332]">
                                        {{ $sop['nama'] }}
                                    </p>
                                </div>
                                <span class="inline-flex shrink-0 items-center gap-1 font-mono text-xs font-bold text-[#1b4332]">
                                    <span>PDF</span>
                                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true"></i>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>

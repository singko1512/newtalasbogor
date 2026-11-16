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

<section id="layanan" data-scroll-section aria-labelledby="layanan-judul" class="relative z-10 mt-6 rounded-t-2xl border-t border-b border-[#cfd9d2] bg-[#f8faf8] py-14 shadow-[0_-28px_68px_-14px_rgba(7,21,15,0.52)] sm:mt-8 sm:rounded-t-[1.75rem] lg:py-20">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-12 lg:gap-12">
            {{-- Panel Kiri Sticky: Ringkasan, Filter Kategori, & Tautan Operasional --}}
            <div data-scroll-reveal="fade" class="lg:col-span-4 lg:sticky lg:top-24 lg:self-start">
                <p class="text-xs font-semibold text-[#784f14]">
                    Katalog Layanan Resmi
                </p>
                <h2 id="layanan-judul" class="font-display mt-1.5 text-2xl font-bold tracking-[-0.025em] text-[#10231b] sm:text-[1.875rem] sm:leading-[1.15]">
                    Layanan TALAS BOGOR
                </h2>
                <p class="mt-2.5 text-sm leading-relaxed text-[#3f5249]">
                    9 layanan digital Diskominfo Kabupaten Bogor untuk domain, hosting, email dinas, otorisasi operator, pengujian keamanan, dan pemulihan website.
                </p>

                <div class="mt-6 overflow-hidden rounded-xl border border-[#cfd9d2] bg-white">
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
                       class="border-t border-[#e5ebe6] bg-[#fafaf7] px-4 py-2.5 text-xs font-medium text-[#3f5249]">
                        Menampilkan {{ count($layananUtama) }} layanan utama portal
                    </p>
                </div>

                <div class="mt-6 border-t border-[#d6ded7] pt-4">
                    <p class="text-xs leading-relaxed text-[#3f5249]">
                        Seluruh permohonan layanan dan tiket gangguan diproses terpusat melalui akun operator SKPD, Kecamatan, atau Desa.
                    </p>
                    <div class="mt-2.5 flex flex-wrap items-center gap-x-5 gap-y-1">
                        <a href="#layanan-sop"
                           data-sop-jump
                           class="inline-flex min-h-[44px] items-center text-xs font-bold text-[#1b4332] underline decoration-[#1b4332]/35 underline-offset-4 hover:decoration-[#1b4332]">
                            Lihat {{ count($sopList) }} dokumen SOP
                        </a>
                        <a href="{{ $portalLoginUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex min-h-[44px] items-center text-xs font-semibold text-[#784f14] underline decoration-[#784f14]/35 underline-offset-4 hover:text-[#10231b] hover:decoration-[#10231b]">
                            Portal Tiket Resmi
                            <span class="sr-only"> (buka di tab baru)</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Panel Kanan: Ledger Katalog Layanan + Sorotan Pemulihan Insiden --}}
            <div class="min-w-0 overflow-x-clip lg:col-span-8">
                <div class="overflow-hidden rounded-xl border border-[#cfd9d2] bg-white">
                    <div data-service-list data-scroll-stagger class="-mt-px -ml-px grid grid-cols-1 md:grid-cols-2">
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
                                         class="{{ $spansTwoCols ? 'md:col-span-2 ' : '' }}border-t border-l border-[#e2e9e4] bg-[#faf8f2] p-5 shadow-[inset_4px_0_0_#d49b35] sm:p-6">
                                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                        <div class="min-w-0">
                                            <div class="flex items-start gap-3.5">
                                                <img src="{{ asset($item['icon_path']) }}"
                                                     alt=""
                                                     width="36"
                                                     height="36"
                                                     class="mt-0.5 h-9 w-9 shrink-0 object-contain"
                                                     aria-hidden="true">
                                                <div class="min-w-0">
                                                    <div class="flex flex-wrap items-center gap-x-2.5 gap-y-1 text-xs">
                                                        <span class="font-mono font-bold tracking-tight text-[#784f14]">
                                                            {{ $itemNumber }} / Penanganan Gangguan
                                                        </span>
                                                        <span class="text-[#c5d1c8]" aria-hidden="true">&middot;</span>
                                                        <span class="font-mono font-bold text-[#1b4332]">{{ $item['kode_sop'] }}</span>
                                                    </div>
                                                    <h3 class="font-display mt-1 text-lg font-bold leading-snug tracking-[-0.015em] text-[#10231b] sm:text-xl">
                                                        {{ $item['nama'] }}
                                                    </h3>
                                                </div>
                                            </div>
                                            <p class="mt-3 max-w-[62ch] text-[13.5px] leading-[1.6] text-[#3f5249]">
                                                {{ $item['ringkasan'] }} Insiden ditangani berurutan dari pencatatan tiket portal hingga audit ulang Tim CSIRT sebelum tayang kembali.
                                            </p>
                                        </div>

                                        <div class="flex w-full shrink-0 flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
                                            <button type="button"
                                                    data-open-service-modal
                                                    data-service-slug="{{ $item['slug'] }}"
                                                    class="talas-transition inline-flex min-h-[44px] w-full cursor-pointer items-center justify-center rounded-lg bg-[#1b4332] px-4 py-2 text-xs font-bold whitespace-nowrap text-white hover:bg-[#143325] active:scale-[0.98] sm:w-auto">
                                                Syarat &amp; Alur
                                            </button>
                                            <a href="{{ $portalLoginUrl }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="talas-transition inline-flex min-h-[44px] w-full items-center justify-center rounded-lg border border-[#cfd9d2] bg-white px-4 py-2 text-xs font-bold whitespace-nowrap text-[#1b4332] hover:border-[#1b4332] active:scale-[0.98] sm:w-auto">
                                                Portal Tiket
                                                <span class="sr-only"> (buka di tab baru)</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="talas-incident-steps mt-5 rounded-lg border border-[#e3e5dc] bg-white p-4 text-xs">
                                        @foreach ($item['sorotan_alur'] as $langkah)
                                            <div class="border-t border-[#e8ebe3] pt-2.5 first:border-t-0 first:pt-0 md:border-t-0 md:border-l md:pt-0 md:pl-4 md:first:border-l-0 md:first:pl-0">
                                                <p class="font-bold text-[#1b4332]">{{ $langkah['judul'] }}</p>
                                                <p class="mt-0.5 leading-relaxed text-[#3f5249]">{{ $langkah['ringkas'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <dl class="mt-4 grid gap-3 border-t border-[#e3e5dc] pt-3.5 text-xs sm:grid-cols-3">
                                        <div>
                                            <dt class="font-medium text-[#3f5249]">Sasaran</dt>
                                            <dd class="mt-0.5 font-semibold text-[#10231b]">{{ $item['sasaran'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-[#3f5249]">Mutu Baku</dt>
                                            <dd class="mt-0.5 font-semibold tabular-nums text-[#10231b]">{{ $item['mutu_baku'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="font-medium text-[#3f5249]">Pelaksana</dt>
                                            <dd class="mt-0.5 font-semibold text-[#10231b]">{{ $item['pelaksana'] }}</dd>
                                        </div>
                                    </dl>
                                </article>
                            @else
                                <article data-service-card
                                         data-service-group="{{ $filterGroup }}"
                                         data-service-spotlight="false"
                                         data-service-slug="{{ $item['slug'] }}"
                                         class="{{ $spansTwoCols ? 'md:col-span-2 ' : '' }}group flex cursor-pointer flex-col justify-between border-t border-l border-[#e2e9e4] bg-white p-5 transition-colors duration-200 hover:bg-[#fafaf7] sm:p-6">
                                    <div>
                                        <div class="flex items-start gap-3.5">
                                            <img src="{{ asset($item['icon_path']) }}"
                                                 alt=""
                                                 width="36"
                                                 height="36"
                                                 class="mt-0.5 h-9 w-9 shrink-0 object-contain"
                                                 aria-hidden="true">

                                            <div class="min-w-0 flex-1">
                                                <div class="flex flex-wrap items-baseline justify-between gap-x-3 gap-y-1">
                                                    <span class="text-xs font-semibold text-[#784f14]">
                                                        <span class="font-mono tabular-nums">{{ $itemNumber }}</span> / {{ $item['kategori'] }}
                                                    </span>
                                                    <span class="font-mono text-[11px] font-bold tracking-tight tabular-nums text-[#1b4332]">
                                                        {{ $item['kode_sop'] }}
                                                    </span>
                                                </div>

                                                <h3 class="font-display mt-1 text-base font-bold leading-snug tracking-[-0.015em] text-[#10231b] transition-colors group-hover:text-[#1b4332] sm:text-[17px]">
                                                    {{ $item['nama'] }}
                                                </h3>
                                            </div>
                                        </div>

                                        <p class="mt-3 max-w-[58ch] text-[13.5px] leading-[1.6] text-[#3f5249]">
                                            {{ $item['ringkasan'] }}
                                        </p>
                                    </div>

                                    <div class="mt-5 flex items-end justify-between gap-4 border-t border-[#e8eeea] pt-3.5">
                                        <div class="min-w-0 space-y-0.5 text-xs">
                                            <p class="font-semibold text-[#10231b]">
                                                {{ $item['sasaran'] }}
                                            </p>
                                            <p class="leading-snug tabular-nums text-[#3f5249]">
                                                {{ $item['mutu_baku'] }}
                                            </p>
                                        </div>

                                        <button type="button"
                                                data-open-service-modal
                                                data-service-slug="{{ $item['slug'] }}"
                                                class="talas-transition -my-2 -mr-1 inline-flex min-h-[44px] shrink-0 cursor-pointer items-center px-1.5 text-xs font-bold whitespace-nowrap text-[#1b4332] underline decoration-[#1b4332]/30 underline-offset-4 group-hover:decoration-[#1b4332] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                            Syarat &amp; alur
                                        </button>
                                    </div>
                                </article>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Arsip Ringkas 10 Dokumen SOP Resmi --}}
        <div id="layanan-sop" class="mt-10 overflow-hidden rounded-xl border border-[#cfd9d2] bg-white">
            <div class="flex flex-col gap-4 bg-[#fafaf7] px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex min-w-0 items-start gap-3.5">
                    <img src="{{ asset('images/icons/layanan/sop-document.svg') }}"
                         alt=""
                         width="36"
                         height="36"
                         class="mt-0.5 h-9 w-9 shrink-0 object-contain"
                         aria-hidden="true">
                    <div class="min-w-0">
                        <h3 class="font-display text-base font-bold text-[#10231b]">
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
                       class="talas-transition inline-flex min-h-[44px] w-full items-center justify-center rounded-lg border border-[#cfd9d2] bg-white px-4 py-2 text-xs font-semibold whitespace-nowrap text-[#1b4332] hover:border-[#1b4332] sm:w-auto">
                        Arsip Resmi TALAS
                        <span class="sr-only"> (buka di tab baru)</span>
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
                 class="hidden border-t border-[#cfd9d2] bg-white">
                <ol class="grid grid-cols-1 md:grid-cols-2">
                    @foreach ($sopList as $sop)
                        <li class="{{ $loop->first ? '' : 'border-t border-[#e5ebe6]' }} {{ $loop->index === 1 ? 'md:border-t-0' : '' }} md:odd:border-r md:odd:border-[#e5ebe6]">
                            <a href="{{ $sop['url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="talas-transition group flex min-h-[54px] items-center justify-between gap-4 px-5 py-3.5 hover:bg-[#fafaf7] sm:px-6">
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
                                <span class="shrink-0 font-mono text-xs font-bold text-[#1b4332]">
                                    PDF
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</section>

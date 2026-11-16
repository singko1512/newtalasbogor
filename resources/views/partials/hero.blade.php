<section id="hero"
         data-hero-section
         aria-labelledby="hero-judul"
         class="sticky top-[4rem] z-0 flex flex-col justify-center overflow-hidden bg-[#0b2017] py-8 sm:py-11 lg:min-h-[calc(100dvh-4rem)] lg:py-14">
    {{-- Foto Latar Arsitektural Penuh Hero --}}
    <img data-hero-bg
         src="{{ asset('images/hero-bogor.webp') }}"
         alt=""
         aria-hidden="true"
         fetchpriority="high"
         class="pointer-events-none absolute inset-0 h-full w-full object-cover object-center opacity-95 will-change-transform">
    <div aria-hidden="true" class="talas-hero-scrim pointer-events-none absolute inset-0"></div>
    <div data-hero-curtain-veil aria-hidden="true" class="pointer-events-none absolute inset-0 z-[5] bg-[#07150f] opacity-0"></div>

    <div data-hero-stage class="relative z-10 mx-auto w-full max-w-7xl px-4 will-change-[transform,opacity] sm:px-6 lg:px-8">
        <div class="grid items-center gap-8 lg:grid-cols-[minmax(0,1.25fr)_minmax(0,1fr)] lg:gap-10 xl:gap-12">
            {{-- Kolom Kiri: Identitas Instansi, Judul Utama, Ringkasan, & Aksi Utama --}}
            <div class="min-w-0 text-left text-white">
                <div data-hero-stagger class="inline-flex flex-wrap items-center gap-x-3.5 gap-y-2">
                    <img src="{{ asset('images/logo-diskominfo-bogorkab.png') }}"
                         alt="Diskominfo Kabupaten Bogor"
                         width="160"
                         height="40"
                         class="h-7 sm:h-8 w-auto shrink-0 object-contain drop-shadow-sm">
                    <span class="hidden h-4 w-px bg-white/30 sm:inline-block" aria-hidden="true"></span>
                    <span class="text-xs font-medium leading-snug text-[#d9e5dd] sm:text-[13px]">
                        {{ $meta['instansi'] }}
                    </span>
                </div>

                <h1 id="hero-judul"
                    data-hero-stagger
                    class="font-display mt-5 tracking-[-0.03em] text-white">
                    <span class="block text-[1.625rem] font-bold leading-[1.15] sm:text-[2.125rem] lg:text-[1.875rem] xl:text-[2.375rem]">
                        {{ $hero['judul'] }}
                    </span>
                    <span class="mt-1.5 block text-[2.25rem] font-bold leading-[1.04] text-[#f3cf7a] sm:text-[2.875rem] lg:text-[2.875rem] xl:text-[3.375rem]">
                        {{ $meta['nama_portal'] }}
                    </span>
                </h1>

                <p data-hero-stagger class="mt-4 max-w-[52ch] text-[15px] leading-[1.65] text-[#dce7e0] sm:text-base">
                    {{ $hero['ringkasan'] }}
                </p>

                <div data-hero-stagger class="mt-7 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                    <a href="#layanan"
                       class="talas-transition inline-flex min-h-[46px] w-full items-center justify-center rounded-lg border border-[#e8bc66]/55 bg-[#d49b35] px-5 py-2.5 text-sm font-bold text-[#0b2017] shadow-[0_8px_22px_-6px_rgba(212,155,53,0.42)] hover:-translate-y-px hover:bg-[#e1aa44] hover:shadow-[0_12px_28px_-6px_rgba(212,155,53,0.55)] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f2c66d] active:translate-y-0 active:scale-[0.98] sm:w-auto sm:whitespace-nowrap">
                        Lihat Katalog {{ $heroSummary['katalog_count'] }} Layanan
                    </a>
                    <a href="#direktori"
                       class="talas-transition inline-flex min-h-[46px] w-full items-center justify-center gap-2 rounded-lg border border-white/30 bg-[#0b2017]/80 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur-xs hover:-translate-y-px hover:border-white/55 hover:bg-[#143325]/95 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white active:translate-y-0 active:scale-[0.98] sm:w-auto sm:whitespace-nowrap">
                        <i data-lucide="search" class="h-4 w-4 shrink-0 text-[#f3cf7a]" aria-hidden="true"></i>
                        <span>Telusuri Direktori ({{ number_format($heroSummary['total_layanan'], 0, ',', '.') }})</span>
                    </a>
                </div>
            </div>

            {{-- Kolom Kanan: Panel Rekapitulasi Layanan Kabupaten Bogor --}}
            <aside id="rekap"
                   data-hero-stagger
                   aria-labelledby="rekap-judul"
                   class="talas-hero-sheet min-w-0 overflow-hidden rounded-2xl border border-white/25 bg-[#f6f5f0] text-[#10231b]">
                <div class="border-b border-[#e5ebe6] bg-white px-5 pt-5 pb-4 sm:px-6 sm:pt-6 sm:pb-5">
                    <h2 id="rekap-judul" class="font-display text-sm font-bold tracking-[-0.01em] text-[#10231b]">
                        Rekapitulasi Layanan Kabupaten Bogor
                    </h2>

                    <div class="mt-3 flex flex-wrap items-end justify-between gap-x-4 gap-y-1.5">
                        <div class="flex items-baseline gap-2.5">
                            <span data-countup="{{ $heroSummary['total_layanan'] }}"
                                  class="font-display text-[2.75rem] font-bold leading-none tracking-[-0.04em] tabular-nums text-[#10231b] sm:text-[3rem]">
                                {{ number_format($heroSummary['total_layanan'], 0, ',', '.') }}
                            </span>
                            <span class="text-xs font-medium text-[#3f5249]">
                                Layanan digital terdata
                            </span>
                        </div>
                        <span class="text-xs font-medium tabular-nums text-[#3f5249]">
                            Data {{ $meta['tanggal_observasi'] }}
                        </span>
                    </div>

                    {{-- Batang proporsi aktual berbanding total layanan --}}
                    <div data-rekap-bar
                         class="mt-4 flex h-3 w-full gap-[2px] overflow-hidden rounded-xs bg-[#e3e8e4] p-[2px]"
                         role="img"
                         aria-label="{{ $heroSummary['composition_label'] }}">
                        @foreach ($heroSummary['segments'] as $seg)
                            <div data-rekap-seg="{{ $seg['tab'] }}"
                                 style="width: {{ $seg['share_css'] }}%; background-color: {{ $seg['color'] }};"
                                 class="talas-rekap-seg h-full rounded-[1px]"></div>
                        @endforeach
                    </div>
                </div>

                <div class="divide-y divide-[#e5ebe6]">
                    @foreach ($heroSummary['segments'] as $seg)
                        <a href="{{ route('beranda', ['tab' => $seg['tab']]) }}#direktori"
                           data-hero-dir-tab="{{ $seg['tab'] }}"
                           class="talas-rekap-row talas-transition group flex min-h-[68px] items-center justify-between gap-3.5 px-5 py-3.5 hover:bg-white focus-visible:bg-white sm:px-6">
                            <div class="flex min-w-0 items-start gap-3">
                                <span aria-hidden="true" class="mt-[0.3125rem] h-2.5 w-2.5 shrink-0 rounded-[2px]" style="background-color: {{ $seg['color'] }};"></span>
                                <div class="min-w-0">
                                    <span class="block text-sm font-semibold leading-snug text-[#10231b] group-hover:text-[#1b4332]">
                                        {{ $seg['label'] }}
                                    </span>
                                    <p class="mt-0.5 text-xs leading-relaxed text-pretty text-[#3f5249]">
                                        {{ $seg['keterangan'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="shrink-0 text-right">
                                <span data-countup="{{ $seg['jumlah'] }}"
                                      class="font-display block text-lg font-bold leading-none tabular-nums text-[#10231b] group-hover:text-[#1b4332] sm:text-[1.25rem]">
                                    {{ number_format($seg['jumlah'], 0, ',', '.') }}
                                </span>
                                <span class="mt-1 block text-xs font-semibold tabular-nums text-[#3f5249]">
                                    {{ $seg['share_label'] }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </div>
</section>

<section aria-labelledby="hero-judul"
         class="relative flex flex-col justify-center overflow-hidden border-b border-[#0b2017] bg-[#0b2017] py-6 sm:py-9 lg:min-h-[calc(100dvh-4.25rem)] lg:py-10">
    {{-- Foto Latar Arsitektural Penuh Satu Layar Hero (Full-Bleed Viewport Hero) --}}
    <img src="{{ asset('images/hero-bogor.webp') }}"
         alt=""
         aria-hidden="true"
         fetchpriority="high"
         class="pointer-events-none absolute inset-0 h-full w-full object-cover object-center opacity-95">
    <div aria-hidden="true" class="talas-hero-scrim pointer-events-none absolute inset-0"></div>

    {{-- Panggung Atas Hero: Identitas Instansi & Judul Portal Terpusat --}}
    <div class="relative z-10 mx-auto w-full max-w-4xl px-4 text-center text-white sm:px-6 lg:px-8">
        <div data-hero-stagger
             class="inline-flex max-w-full flex-wrap items-center justify-center gap-2 rounded-lg border border-white/85 bg-white/96 px-3 py-1.5 shadow-[0_4px_18px_rgba(7,21,15,0.34)] sm:gap-3 sm:px-4">
            <img src="{{ asset('images/logo-diskominfo-bogorkab.png') }}"
                 alt="Diskominfo Kabupaten Bogor"
                 width="148"
                 height="35"
                 class="h-5 w-auto object-contain sm:h-[26px]">
            <span class="hidden h-4 w-px bg-[#cfd9d2] sm:inline-block" aria-hidden="true"></span>
            <span class="text-[11px] font-semibold tracking-[0.01em] text-[#10231b] sm:text-xs">
                {{ $meta['instansi'] }}
            </span>
        </div>

        <h1 id="hero-judul"
            data-hero-stagger
            class="mt-4 sm:mt-5">
            <span class="block text-sm font-semibold tracking-[0.04em] text-white/95 drop-shadow-[0_1px_10px_rgba(7,21,15,0.7)] sm:text-base lg:text-[1.0625rem]">
                Portal Layanan &amp; Aplikasi Digital
            </span>
            <span class="font-display mt-1.5 block text-[2.25rem] font-bold leading-[1.02] tracking-[-0.03em] text-[#f3cf7a] drop-shadow-[0_3px_20px_rgba(7,21,15,0.72)] sm:text-[3rem] lg:text-[3.5rem]">
                TALAS BOGOR
            </span>
        </h1>
    </div>

    {{-- Kartu Utama Sambutan & Rekapitulasi di Depan Latar Gambar Penuh --}}
    <div class="relative z-10 mx-auto mt-6 w-full max-w-7xl px-4 sm:mt-7 sm:px-6 lg:mt-8 lg:px-8">
        <div data-hero-stagger
             class="talas-hero-sheet overflow-hidden rounded-2xl border border-white/30 bg-white/98 text-[#10231b] backdrop-blur-xs">
            <div aria-hidden="true" class="h-[4px] w-full bg-[#d49b35]"></div>
            <div class="grid lg:grid-cols-12">
                {{-- Kolom Kiri: Sambutan Resmi, Aksi Utama, & 3 Sorotan Ekosistem --}}
                <div class="min-w-0 flex flex-col justify-between p-5 sm:p-7 lg:col-span-7 lg:px-9 lg:py-8">
                    <div>
                        <h2 class="font-display text-[1.35rem] font-bold leading-[1.2] tracking-[-0.02em] text-[#10231b] sm:text-[1.6rem]">
                            {{ $hero['sambutan_judul'] }}
                        </h2>

                        <p class="mt-3 max-w-[56ch] text-[14.5px] leading-[1.65] text-[#2c3f37] sm:text-[15px]">
                            {{ $hero['ringkasan'] }} {{ $hero['catatan_tiket'] }}
                        </p>

                        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center">
                            <a href="#layanan"
                               class="talas-transition group inline-flex min-h-[46px] w-full items-center justify-center gap-2 rounded-lg bg-[#1b4332] px-5 py-2.5 text-sm font-bold text-white shadow-xs hover:bg-[#143325] active:scale-[0.98] sm:w-auto sm:whitespace-nowrap">
                                <span>Lihat Katalog {{ $heroSummary['katalog_count'] }} Layanan</span>
                                <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 transition-transform duration-200 group-hover:translate-x-0.5" aria-hidden="true"></i>
                            </a>
                            <a href="#direktori"
                               class="talas-transition inline-flex min-h-[46px] w-full items-center justify-center gap-2 rounded-lg border border-[#c5d1c8] bg-[#f8faf8] px-5 py-2.5 text-sm font-semibold text-[#10231b] hover:border-[#1b4332] hover:bg-[#edf2ed] active:scale-[0.98] sm:w-auto sm:whitespace-nowrap">
                                <i data-lucide="search" class="h-4 w-4 shrink-0 text-[#1b4332]" aria-hidden="true"></i>
                                <span>Telusuri Direktori ({{ number_format($heroSummary['total_layanan'], 0, ',', '.') }})</span>
                            </a>
                        </div>
                    </div>

                    <div class="mt-7 grid grid-cols-2 gap-x-4 gap-y-4 border-t border-[#e5ebe6] pt-5 sm:grid-cols-3 sm:gap-x-0 sm:divide-x sm:divide-[#e5ebe6]">
                        @foreach ($heroSummary['highlights'] as $index => $sorotan)
                            <div class="{{ $index === 2 ? 'col-span-2 flex items-center justify-between gap-3 border-t border-[#e5ebe6] pt-3.5 sm:col-span-1 sm:block sm:border-t-0 sm:pt-0' : '' }} sm:px-5 first:sm:pl-0 last:sm:pr-0">
                                <div class="{{ $index === 2 ? 'sm:contents' : '' }}">
                                    <span class="block text-xs font-semibold text-[#784f14]">{{ $sorotan['label'] }}</span>
                                    <span class="font-display mt-1 block text-xl font-bold leading-none tracking-[-0.02em] tabular-nums text-[#10231b] sm:text-[1.35rem]">
                                        {{ $sorotan['angka'] ?? $sorotan['nilai'] }}
                                    </span>
                                </div>
                                @if (! empty($sorotan['konteks']))
                                    <span class="{{ $index === 2 ? 'text-right sm:mt-1.5 sm:text-left' : 'mt-1.5' }} block text-xs font-medium leading-snug text-[#3f5249]">
                                        {{ $sorotan['konteks'] }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Kolom Kanan: Panel Rekapitulasi Layanan Kabupaten Bogor --}}
                <aside id="rekap"
                       aria-labelledby="rekap-judul"
                       class="min-w-0 flex flex-col justify-between border-t border-[#d6ded7] bg-[#f6f5f0]/95 lg:col-span-5 lg:border-t-0 lg:border-l">
                    <div class="border-b border-[#e5ebe6] px-5 pt-5 pb-4 sm:px-7 sm:pt-6 sm:pb-5">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h2 id="rekap-judul" class="font-display text-sm font-bold tracking-[-0.01em] text-[#10231b]">
                                Rekapitulasi Layanan Kabupaten Bogor
                            </h2>
                            <span class="rounded border border-[#d6ded7] bg-white px-2.5 py-0.5 text-xs font-medium text-[#3f5249]">
                                Data {{ $meta['tanggal_observasi'] }}
                            </span>
                        </div>

                        <div class="mt-3.5 flex items-baseline gap-3.5">
                            <span data-countup="{{ $heroSummary['total_layanan'] }}"
                                  class="font-display text-[2.65rem] font-bold leading-none tracking-[-0.04em] tabular-nums text-[#10231b] sm:text-[3rem]">
                                {{ number_format($heroSummary['total_layanan'], 0, ',', '.') }}
                            </span>
                            <span class="text-xs font-medium leading-snug text-[#3f5249]">
                                Total layanan digital terdata<br>
                                (Aplikasi, Website, dan Desa.id)
                            </span>
                        </div>

                        {{-- Batang proporsi aktual berbanding total layanan --}}
                        <div data-rekap-bar
                             class="mt-4 flex h-2.5 w-full gap-[2px] overflow-hidden rounded-xs bg-[#e1e7e2] p-[2px]"
                             role="img"
                             aria-label="{{ $heroSummary['composition_label'] }}">
                            @foreach ($heroSummary['segments'] as $seg)
                                <div data-rekap-seg="{{ $seg['tab'] }}"
                                     style="width: {{ $seg['share_css'] }}%; background-color: {{ $seg['color'] }};"
                                     class="talas-rekap-seg h-full rounded-[1px]"></div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex-1 divide-y divide-[#e5ebe6]">
                        @foreach ($heroSummary['segments'] as $seg)
                            <a href="{{ route('beranda', ['tab' => $seg['tab']]) }}#direktori"
                               data-hero-dir-tab="{{ $seg['tab'] }}"
                               class="talas-rekap-row talas-transition group flex min-h-[64px] items-center justify-between gap-4 px-5 py-3 hover:bg-white focus-visible:bg-white sm:px-7">
                                <div class="flex min-w-0 items-start gap-3">
                                    <span aria-hidden="true" class="mt-[0.3125rem] h-2.5 w-2.5 shrink-0 rounded-[2px]" style="background-color: {{ $seg['color'] }};"></span>
                                    <div class="min-w-0">
                                        <span class="block text-sm font-semibold leading-snug text-[#10231b] group-hover:text-[#1b4332]">
                                            {{ $seg['label'] }}
                                        </span>
                                        <p class="mt-0.5 text-xs leading-snug text-[#3f5249]">
                                            {{ $seg['keterangan'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex shrink-0 items-center gap-2.5">
                                    <div class="text-right">
                                        <span data-countup="{{ $seg['jumlah'] }}"
                                              class="font-display block text-lg font-bold leading-none tabular-nums text-[#10231b] group-hover:text-[#1b4332] sm:text-[1.25rem]">
                                            {{ number_format($seg['jumlah'], 0, ',', '.') }}
                                        </span>
                                        <span class="mt-1 block text-xs font-semibold tabular-nums text-[#3f5249]">
                                            {{ $seg['share_label'] }}
                                        </span>
                                    </div>
                                    <i data-lucide="chevron-right"
                                       class="h-4 w-4 shrink-0 text-[#3f5249] transition-transform duration-200 group-hover:translate-x-0.5 group-hover:text-[#1b4332]"
                                       aria-hidden="true"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>

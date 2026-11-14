<section id="capaian" aria-labelledby="capaian-judul" class="border-b border-[#d6ded7] bg-white py-14 lg:py-18">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div data-scroll-section data-scroll-fade-only data-scrollspy-section="capaian">
            <div class="flex flex-col gap-5 border-b border-[#d6ded7] pb-6 lg:flex-row lg:items-end lg:justify-between lg:gap-10">
                <div class="max-w-2xl">
                    <p class="text-xs font-semibold text-[#784f14]">
                        Evaluasi Kinerja Pemerintahan Digital
                    </p>
                    <h2 id="capaian-judul" class="font-display mt-2 text-2xl font-bold tracking-[-0.02em] text-[#10231b] sm:text-[1.875rem] sm:leading-[1.15]">
                        Capaian Evaluasi SPBE &amp; Smart City
                    </h2>
                    <p class="mt-2.5 text-sm leading-relaxed text-[#3f5249]">
                        Rekam evaluasi Sistem Pemerintahan Berbasis Elektronik (SPBE) dan pemetaan {{ number_format($smartCity['total_aplikasi'], 0, ',', '.') }} aplikasi Pemerintah Kabupaten Bogor pada kerangka Smart City.
                    </p>
                </div>

                <dl class="grid shrink-0 grid-cols-2 gap-x-6 gap-y-2 border-t border-[#e5ebe6] pt-3.5 text-xs sm:flex sm:items-center sm:gap-6 lg:border-t-0 lg:border-l lg:border-[#e5ebe6] lg:pl-6 lg:pt-0">
                    <div>
                        <dt class="text-[#3f5249]">Cakupan SPBE {{ $spbe['tahun'] ?? '2025' }}</dt>
                        <dd class="mt-0.5 font-semibold tabular-nums text-[#10231b]">{{ $spbe['total_aspek'] }} Aspek &middot; {{ $spbe['total_indikator'] }} Indikator</dd>
                    </div>
                    <div>
                        <dt class="text-[#3f5249]">Pemetaan Smart City</dt>
                        <dd class="mt-0.5 font-semibold tabular-nums text-[#10231b]">{{ number_format($smartCity['total_aplikasi'], 0, ',', '.') }} Aplikasi OPD</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-12 lg:items-stretch">
                {{-- Panel Kiri: Scoreboard, 4 Domain, Rincian 8 Aspek & Rujukan SPBE --}}
                <article id="spbe" aria-labelledby="spbe-judul" class="flex min-w-0 flex-col justify-between overflow-hidden rounded-xl border border-[#d6ded7] bg-white lg:col-span-7">
                    {{-- Header Scoreboard Indeks SPBE --}}
                    <div class="border-b border-[#e5ebe6] bg-[#fafaf7] px-5 py-5 sm:px-6">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1">
                                    <h3 id="spbe-judul" class="font-display text-lg font-bold tracking-[-0.015em] text-[#10231b] sm:text-xl">
                                        Indeks SPBE Kabupaten Bogor
                                    </h3>
                                </div>
                                <p class="mt-1 text-xs leading-relaxed text-[#3f5249]">
                                    {{ $spbe['referensi'] }}
                                </p>
                                @if (! empty($spbe['url']))
                                    <a href="{{ $spbe['url'] }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="-my-1 inline-flex min-h-[44px] items-center gap-1 py-1.5 text-xs font-semibold text-[#1b4332] hover:text-[#0b2017] hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                        <span>Rincian {{ $spbe['total_indikator'] }} Indikator SPBE</span>
                                        <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                        <span class="sr-only"> (buka di tab baru)</span>
                                    </a>
                                @endif
                            </div>

                            <div class="flex shrink-0 items-center justify-between gap-4 border-t border-[#e5ebe6] pt-3.5 sm:flex-col sm:items-end sm:border-t-0 sm:pt-0 sm:text-right">
                                <div>
                                    <span class="block text-xs font-semibold text-[#3f5249]">
                                        Indeks Tahun {{ $spbe['tahun'] ?? '2025' }}
                                    </span>
                                    <div class="mt-1 flex items-center gap-2.5 sm:justify-end">
                                        <span class="font-display text-3xl font-bold leading-none tracking-[-0.03em] tabular-nums text-[#10231b] sm:text-[2.375rem]">
                                            {{ $spbe['indeks_2025'] }}
                                        </span>
                                        <span class="rounded-sm border-l-2 border-[#d49b35] bg-[#fbf4e4] px-2.5 py-1 text-xs font-bold tracking-[0.04em] text-[#784f14]">
                                            {{ $spbe['predikat_2025'] }}
                                        </span>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold tabular-nums text-[#166534]">
                                    {{ $spbe['kenaikan'] }} <span class="font-normal text-[#3f5249]">vs {{ $spbe['indeks_2024'] }} (2024)</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Ringkasan 4 Domain SPBE --}}
                    @if (! empty($spbe['domain_ringkas']))
                        <div class="border-b border-[#e5ebe6] bg-white">
                            <div class="flex flex-wrap items-baseline justify-between gap-2 px-5 pt-4 pb-2.5 sm:px-6">
                                <h4 class="text-xs font-bold text-[#10231b]">Rekapitulasi Nilai 4 Domain SPBE ({{ $spbe['tahun'] ?? '2025' }})</h4>
                                <span class="text-xs text-[#3f5249]">Skala 0-5 &middot; perbandingan 2024 ke {{ $spbe['tahun'] ?? '2025' }}</span>
                            </div>
                            <dl class="grid grid-cols-2 border-t border-[#e5ebe6] sm:grid-cols-4">
                                @foreach ($spbe['domain_ringkas'] as $dom)
                                    @php
                                        $domNumeric = (float) str_replace(',', '.', (string) ($dom['nilai_2025'] ?? '0'));
                                        $domBarPct = min(100, max(0, round(($domNumeric / 5.0) * 100, 1)));
                                    @endphp
                                    <div class="px-4 py-3.5 sm:px-5 {{ $loop->index % 2 === 0 ? 'border-r border-[#e5ebe6]' : '' }} {{ $loop->index < 2 ? 'border-b border-[#e5ebe6] sm:border-b-0' : '' }} {{ ! $loop->last ? 'sm:border-r sm:border-[#e5ebe6]' : '' }}">
                                        <dt class="text-xs font-semibold leading-snug text-[#10231b]">{{ $dom['domain'] }}</dt>
                                        <dd class="mt-0.5 text-xs tabular-nums text-[#3f5249]">Bobot {{ $dom['bobot'] }}</dd>
                                        <dd class="mt-2.5 flex items-baseline justify-between gap-2">
                                            <span class="font-display text-lg font-bold leading-none tabular-nums text-[#10231b]">{{ $dom['nilai_2025'] }}</span>
                                            <span class="text-xs font-semibold tabular-nums {{ str_starts_with($dom['selisih'], '+') ? 'text-[#166534]' : (str_starts_with($dom['selisih'], '-') ? 'text-[#991b1b]' : 'text-[#3f5249]') }}">{{ $dom['selisih'] }}</span>
                                        </dd>
                                        <div class="mt-2 h-1 w-full overflow-hidden rounded-xs bg-[#e5ebe6]" aria-hidden="true">
                                            <span class="block h-full rounded-xs bg-[#1b4332]" style="width: {{ $domBarPct }}%"></span>
                                        </div>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    @endif

                    {{-- Rincian Mobile 8 Aspek SPBE (< 640px) --}}
                    <div class="divide-y divide-[#e5ebe6] sm:hidden">
                        @foreach ($spbe['aspek'] as $aspek)
                            <div class="px-5 py-3.5">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex min-w-0 items-start gap-2">
                                        <span class="mt-0.5 w-5 shrink-0 font-mono text-xs tabular-nums text-[#3f5249]">{{ str_pad((string) $aspek['no'], 2, '0', STR_PAD_LEFT) }}</span>
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold leading-snug text-[#10231b]">{{ $aspek['nama'] }}</p>
                                            <span class="mt-0.5 block text-xs text-[#3f5249]">{{ $aspek['domain'] }}</span>
                                        </div>
                                    </div>
                                    <span class="shrink-0 text-xs font-medium tabular-nums text-[#3f5249]">
                                        {{ $aspek['bobot'] }}
                                    </span>
                                </div>
                                <div class="mt-2.5 grid grid-cols-3 gap-2 rounded-lg border border-[#e5ebe6] bg-[#fafaf7] px-3 py-2 text-xs tabular-nums">
                                    <div>
                                        <span class="block text-[#3f5249]">2024</span>
                                        <span class="mt-0.5 block font-semibold text-[#10231b]">{{ $aspek['nilai_2024'] }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-[#3f5249]">2025</span>
                                        <span class="mt-0.5 block font-bold text-[#10231b]">{{ $aspek['nilai_2025'] }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-[#3f5249]">Selisih</span>
                                        <span class="mt-0.5 block font-semibold {{ str_starts_with($aspek['selisih'], '+') ? 'text-[#166534]' : (str_starts_with($aspek['selisih'], '-') ? 'text-[#991b1b]' : 'text-[#3f5249]') }}">{{ $aspek['selisih'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Tabel Rincian 8 Aspek SPBE Desktop/Tablet (>= 640px) --}}
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="min-w-full divide-y divide-[#e5ebe6] text-left text-xs sm:text-sm">
                            <caption class="sr-only">Perbandingan nilai 8 aspek SPBE Kabupaten Bogor tahun 2024 dan 2025</caption>
                            <thead class="border-b border-[#e5ebe6] bg-[#fafaf7] text-xs font-semibold text-[#3f5249]">
                                <tr>
                                    <th scope="col" class="py-3 pr-3 pl-5 sm:pl-6">Aspek Penilaian</th>
                                    <th scope="col" class="px-3 py-3 text-right whitespace-nowrap">Bobot</th>
                                    <th scope="col" class="px-3 py-3 text-right whitespace-nowrap">2024</th>
                                    <th scope="col" class="bg-[#f6f5f0]/80 px-3 py-3 text-right whitespace-nowrap text-[#10231b]">2025</th>
                                    <th scope="col" class="py-3 pr-5 pl-3 text-right whitespace-nowrap sm:pr-6">Selisih</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#e5ebe6] text-[#10231b]">
                                @foreach ($spbe['aspek'] as $aspek)
                                    <tr class="hover:bg-[#fafaf7]">
                                        <td class="py-3 pr-3 pl-5 sm:pl-6">
                                            <div class="flex items-start gap-2.5">
                                                <span class="mt-0.5 w-5 shrink-0 font-mono text-xs tabular-nums text-[#3f5249]">{{ str_pad((string) $aspek['no'], 2, '0', STR_PAD_LEFT) }}</span>
                                                <div class="min-w-0">
                                                    <span class="block text-sm font-semibold leading-snug text-[#10231b]">{{ $aspek['nama'] }}</span>
                                                    <span class="mt-0.5 block text-xs text-[#3f5249]">{{ $aspek['domain'] }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 text-right text-xs tabular-nums whitespace-nowrap text-[#3f5249]">{{ $aspek['bobot'] }}</td>
                                        <td class="px-3 py-3 text-right text-xs tabular-nums whitespace-nowrap text-[#3f5249]">{{ $aspek['nilai_2024'] }}</td>
                                        <td class="bg-[#f6f5f0]/45 px-3 py-3 text-right font-display text-sm font-bold tabular-nums whitespace-nowrap text-[#10231b]">{{ $aspek['nilai_2025'] }}</td>
                                        <td class="py-3 pr-5 pl-3 text-right text-xs font-semibold tabular-nums whitespace-nowrap sm:pr-6 {{ str_starts_with($aspek['selisih'], '+') ? 'text-[#166534]' : (str_starts_with($aspek['selisih'], '-') ? 'text-[#991b1b]' : 'text-[#3f5249]') }}">{{ $aspek['selisih'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Rujukan & Dokumen Resmi SPBE --}}
                    @if (! empty($spbe['regulasi_tautan']))
                        @php
                            $spbeDocs = ! empty($spbe['url'])
                                ? collect($spbe['regulasi_tautan'])->reject(fn ($item) => ($item['url'] ?? '') === $spbe['url'])->values()->all()
                                : $spbe['regulasi_tautan'];
                            $regulasiOddTotal = count($spbeDocs) % 2 === 1;
                        @endphp
                        <div class="border-t border-[#e5ebe6] bg-[#fafaf7] px-5 py-4 sm:px-6">
                            <h4 class="text-xs font-bold text-[#10231b]">Rujukan &amp; Dokumen Resmi SPBE</h4>
                            <ul class="mt-2.5 grid grid-cols-1 gap-2 sm:grid-cols-2">
                                @foreach ($spbeDocs as $regLink)
                                    @php
                                        $isPdfDoc = str_ends_with(strtolower($regLink['url']), '.pdf');
                                    @endphp
                                    <li class="{{ $loop->first && $regulasiOddTotal ? 'sm:col-span-2' : '' }}">
                                        <a href="{{ $regLink['url'] }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="talas-transition group flex min-h-[44px] items-center justify-between gap-3 rounded-lg border border-[#dce4de] bg-white px-3.5 py-2 text-xs font-semibold text-[#10231b] hover:border-[#1b4332] hover:bg-[#edf2ed]/60 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                            <span class="flex min-w-0 items-center gap-2.5">
                                                <i data-lucide="{{ $isPdfDoc ? 'file-text' : 'globe' }}"
                                                   class="h-4 w-4 shrink-0 {{ $isPdfDoc ? 'text-[#784f14]' : 'text-[#1b4332]' }}"
                                                   aria-hidden="true"></i>
                                                <span class="leading-snug">{{ $regLink['label'] }}</span>
                                            </span>
                                            <i data-lucide="arrow-up-right"
                                               class="h-3.5 w-3.5 shrink-0 text-[#3f5249] transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:text-[#1b4332]"
                                               aria-hidden="true"></i>
                                            <span class="sr-only"> (buka di tab baru)</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </article>

                {{-- Panel Kanan: Perkembangan Smart City & Distribusi 7 Dimensi --}}
                <article id="smartcity" aria-labelledby="smartcity-judul" class="min-w-0 rounded-xl border border-[#d6ded7] bg-[#f6f5f0] p-5 sm:p-6 lg:col-span-5">
                    <div class="flex flex-wrap items-start justify-between gap-2">
                        <h3 id="smartcity-judul" class="font-display text-lg font-bold tracking-[-0.015em] text-[#10231b] sm:text-xl">
                            Perkembangan Smart City
                        </h3>
                        @if (! empty($smartCity['url']))
                            <a href="{{ $smartCity['url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="-my-2 inline-flex min-h-[44px] items-center gap-1 px-1 text-xs font-semibold text-[#1b4332] hover:text-[#0b2017] hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                <span>Halaman Smart City</span>
                                <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                <span class="sr-only"> (buka di tab baru)</span>
                            </a>
                        @endif
                    </div>
                    <p class="mt-1 text-xs leading-relaxed text-[#3f5249]">
                        Tren indeks evaluasi tahunan serta distribusi {{ number_format($smartCity['total_aplikasi'], 0, ',', '.') }} aplikasi perangkat daerah pada tujuh dimensi Smart City.
                    </p>

                    {{-- Rekapitulasi Evaluasi Tahunan 2022 - 2024 & Komponen Tahap II --}}
                    @php
                        $komponenItems = [];
                        if (! empty($smartCity['komponen_2024'])) {
                            $komponenRaw = (string) $smartCity['komponen_2024'];
                            $afterColon = str_contains($komponenRaw, ':') ? trim(explode(':', $komponenRaw, 2)[1]) : $komponenRaw;
                            $afterColon = rtrim($afterColon, '.');
                            foreach (explode('·', $afterColon) as $part) {
                                $part = trim($part);
                                if (preg_match('/^(.*)\s+(\d+,\d+)$/', $part, $km)) {
                                    $komponenItems[] = [
                                        'label' => trim($km[1]),
                                        'nilai' => trim($km[2]),
                                    ];
                                }
                            }
                        }
                    @endphp
                    <div class="mt-5 overflow-hidden rounded-lg border border-[#d6ded7] bg-white">
                        <ol class="divide-y divide-[#e5ebe6]">
                            @foreach ($smartCity['indeks_tahunan'] as $indeks)
                                @php
                                    $catatanRaw = (string) ($indeks['catatan'] ?? '');
                                    $catatanParts = explode(' · ', $catatanRaw, 2);
                                    $catatanUtama = trim($catatanParts[0] ?? '');
                                    $suratRef = trim($catatanParts[1] ?? '');
                                    $deltaNilai = '';
                                    if (preg_match('/^(.*?)\s*\(([^)]+)\)$/', $catatanUtama, $cm)) {
                                        $catatanUtama = trim($cm[1]);
                                        $deltaNilai = trim($cm[2]);
                                    }
                                @endphp
                                <li class="flex items-start justify-between gap-3 px-4 py-3 {{ $loop->last ? 'bg-[#fafaf7]' : '' }}">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-x-2 gap-y-0.5">
                                            <span class="font-display text-sm font-bold tabular-nums {{ $loop->last ? 'text-[#784f14]' : 'text-[#10231b]' }}">
                                                {{ $indeks['tahun'] }}
                                            </span>
                                            @if ($loop->last)
                                                <span class="border-l-2 border-[#d49b35] bg-[#fbf4e4] px-1.5 py-0.5 text-xs font-semibold text-[#784f14]">
                                                    Terkini
                                                </span>
                                            @endif
                                            @if ($catatanUtama !== '')
                                                <span class="text-xs font-semibold text-[#10231b]">
                                                    {{ $catatanUtama }}
                                                </span>
                                            @endif
                                        </div>
                                        @if ($suratRef !== '')
                                            <span class="mt-0.5 block text-xs text-[#3f5249]">{{ $suratRef }}</span>
                                        @endif
                                    </div>

                                    <div class="shrink-0 text-right tabular-nums">
                                        <span class="font-display block text-xl font-bold leading-none {{ $loop->last ? 'text-[#784f14]' : 'text-[#10231b]' }}">
                                            {{ $indeks['nilai'] }}
                                        </span>
                                        @if ($deltaNilai !== '')
                                            <span class="mt-1 block text-xs font-semibold {{ str_starts_with($deltaNilai, '+') ? 'text-[#166534]' : (str_starts_with($deltaNilai, '-') ? 'text-[#991b1b]' : 'text-[#3f5249]') }}">{{ $deltaNilai }}</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>

                        @if ($komponenItems !== [])
                            <div class="border-t border-[#e5ebe6] bg-[#fafaf7] px-4 py-3" role="group" aria-label="{{ $smartCity['komponen_2024'] }}">
                                <span class="block text-xs font-semibold text-[#3f5249]">Komponen Evaluasi Tahap II 2024</span>
                                <dl class="mt-2 flex flex-wrap items-start justify-between gap-x-4 gap-y-2">
                                    @foreach ($komponenItems as $komp)
                                        <div>
                                            <dt class="text-xs text-[#3f5249]">{{ $komp['label'] }}</dt>
                                            <dd class="font-display text-sm font-bold tabular-nums text-[#10231b]">{{ $komp['nilai'] }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        @elseif (! empty($smartCity['komponen_2024']))
                            <p class="border-t border-[#e5ebe6] bg-[#fafaf7] px-4 py-3 text-xs leading-relaxed text-[#3f5249]">
                                {{ $smartCity['komponen_2024'] }}
                            </p>
                        @endif
                    </div>

                    {{-- Sebaran 7 Dimensi Aplikasi via Spektrum Komposisi --}}
                    @php
                        $dimensiPalette = ['#0b2017', '#2d6a4f', '#d49b35', '#1b4332', '#926018', '#52796f', '#8fa399'];
                        $dimensiSummaryList = [];
                        foreach ($smartCity['dimensi_aplikasi'] as $dimSummaryItem) {
                            $dimensiSummaryList[] = $dimSummaryItem['dimensi'].' '.$dimSummaryItem['jumlah'].' ('.$dimSummaryItem['persen'].')';
                        }
                        $dimensiAriaLabel = 'Komposisi '.number_format($smartCity['total_aplikasi'], 0, ',', '.').' aplikasi pada '.count($smartCity['dimensi_aplikasi']).' dimensi Smart City: '.implode(', ', $dimensiSummaryList);
                    @endphp
                    <div class="mt-6 border-t border-[#d6ded7] pt-5">
                        <div class="flex items-baseline justify-between gap-2">
                            <h4 class="font-display text-sm font-bold text-[#10231b]">
                                Sebaran {{ number_format($smartCity['total_aplikasi'], 0, ',', '.') }} Aplikasi per Dimensi
                            </h4>
                            <span class="text-xs font-medium text-[#3f5249]">{{ count($smartCity['dimensi_aplikasi']) }} kelompok</span>
                        </div>

                        <div class="mt-3 overflow-hidden rounded-full bg-[#dce4de]"
                             role="img"
                             aria-label="{{ $dimensiAriaLabel }}">
                            <div data-progress-bar="100" class="flex h-2.5 w-full">
                                @foreach ($smartCity['dimensi_aplikasi'] as $dimIndex => $dim)
                                    @php
                                        $pct = round(($dim['jumlah'] / max(1, $smartCity['total_aplikasi'])) * 100, 1);
                                        $barColor = $dimensiPalette[$dimIndex % count($dimensiPalette)];
                                    @endphp
                                    <span class="h-full min-w-[3px] border-r border-[#f6f5f0] last:border-r-0"
                                          style="width: {{ $pct }}%; background-color: {{ $barColor }}"
                                          title="{{ $dim['dimensi'] }}: {{ $dim['jumlah'] }} ({{ $dim['persen'] }})"></span>
                                @endforeach
                            </div>
                        </div>

                        <ol class="mt-3.5 divide-y divide-[#dce4de] border-y border-[#dce4de]">
                            @foreach ($smartCity['dimensi_aplikasi'] as $dimIndex => $dim)
                                @php
                                    $barColor = $dimensiPalette[$dimIndex % count($dimensiPalette)];
                                @endphp
                                <li class="flex items-center justify-between gap-3 py-2 text-xs">
                                    <span class="flex min-w-0 items-center gap-2.5">
                                        <span class="h-2.5 w-2.5 shrink-0 rounded-xs" style="background-color: {{ $barColor }}" aria-hidden="true"></span>
                                        <span class="{{ $loop->first ? 'font-bold text-[#10231b]' : 'font-medium text-[#10231b]' }}">{{ $dim['dimensi'] }}</span>
                                    </span>
                                    <span class="flex shrink-0 items-baseline gap-2.5 tabular-nums">
                                        <strong class="font-bold text-[#10231b]">{{ $dim['jumlah'] }}</strong>
                                        <span class="w-12 text-right text-[#3f5249]">{{ $dim['persen'] }}</span>
                                    </span>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Landasan Regulasi Daerah --}}
                    <div class="mt-5">
                        <h4 class="text-xs font-bold text-[#10231b]">
                            Landasan Regulasi Daerah
                        </h4>
                        <ul class="mt-2.5 space-y-2.5">
                            @foreach ($smartCity['regulasi'] as $regulasi)
                                <li class="rounded-lg border border-[#d6ded7] bg-white p-3.5">
                                    <p class="text-xs leading-relaxed text-[#3f5249]">
                                        {{ is_array($regulasi) ? ($regulasi['judul'] ?? '') : $regulasi }}
                                    </p>
                                    @if (is_array($regulasi) && ! empty($regulasi['url']))
                                        <a href="{{ $regulasi['url'] }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="-my-1 inline-flex min-h-[44px] items-center gap-1.5 py-1.5 text-xs font-semibold text-[#1b4332] hover:text-[#0b2017] hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                            <i data-lucide="file-text" class="h-3.5 w-3.5 shrink-0 text-[#784f14]" aria-hidden="true"></i>
                                            <span>Unduh {{ $regulasi['dokumen_label'] ?? 'Dokumen PDF' }}</span>
                                            <i data-lucide="arrow-up-right" class="h-3 w-3 shrink-0" aria-hidden="true"></i>
                                            <span class="sr-only"> (buka di tab baru)</span>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            </div>
        </div>

        {{-- Ekosistem Monitoring & Kanal Layanan Terintegrasi --}}
        @php
            $ekosistemCollection = collect($ekosistem ?? []);
            $loginMod = $ekosistemCollection->firstWhere('kode', 'login');
            $skmMod = $ekosistemCollection->firstWhere('kode', 'skm');

            $priorityOrder = ['dashboard' => 0, 'scoreweb-kec' => 1, 'sop' => 2, 'chikiber' => 3];
            $matrixMods = $ekosistemCollection
                ->reject(fn ($item) => in_array($item['kode'] ?? '', ['login', 'skm'], true))
                ->sortBy(fn ($item, $idx) => $priorityOrder[$item['kode'] ?? ''] ?? (10 + $idx))
                ->values()
                ->all();
            $matrixCount = count($matrixMods);
        @endphp
        <div id="ekosistem" data-scroll-section data-scroll-fade-only class="mt-14 border-t border-[#d6ded7] pt-10">
            <div class="border-b border-[#d6ded7] pb-5">
                <div class="max-w-3xl">
                    <h3 class="font-display text-xl font-bold tracking-[-0.02em] text-[#10231b] sm:text-2xl">
                        Dashboard Monitoring, SKM &amp; Keamanan Siber
                    </h3>
                    <p class="mt-1.5 text-sm leading-relaxed text-[#3f5249]">
                        Kanal sistem resmi terintegrasi Diskominfo Kabupaten Bogor untuk autentikasi operator, survei kepuasan masyarakat, pemantauan aplikasi, standar operasional, dan buletin siber.
                    </p>
                </div>
            </div>

            @if ($loginMod || $skmMod)
                <div class="mt-6 grid gap-5 lg:grid-cols-12">
                    {{-- Anchor Gelap: Portal Login & Admin (497 Akun Peran) --}}
                    @if ($loginMod)
                        @php
                            $loginMetricNum = '';
                            $loginMetricUnit = (string) ($loginMod['metrik'] ?? '');
                            if (preg_match('/^([\d.,]+)\s+(.+)$/', $loginMetricUnit, $lm)) {
                                $loginMetricNum = $lm[1];
                                $loginMetricUnit = $lm[2];
                            }

                            $loginRoles = [];
                            if (preg_match_all('/([A-Za-z][A-Za-z ]+?)\s*\((\d+)\)/', (string) ($loginMod['keterangan'] ?? ''), $lrm, PREG_SET_ORDER)) {
                                foreach ($lrm as $roleMatch) {
                                    $roleLabel = trim(preg_replace('/^(?:Akses operator|dan)\s+/i', '', $roleMatch[1]) ?? $roleMatch[1]);
                                    $loginRoles[] = [
                                        'nama' => $roleLabel,
                                        'jumlah' => $roleMatch[2],
                                    ];
                                }
                            }
                        @endphp
                        <article class="flex flex-col justify-between rounded-xl border border-[#0b2017] bg-[#10231b] p-5 text-white sm:p-6 {{ $skmMod ? 'lg:col-span-5' : 'lg:col-span-12' }}">
                            <div>
                                <div class="flex items-start justify-between gap-4 border-b border-white/12 pb-3.5">
                                    <div>
                                        <div class="flex items-center gap-2 text-xs font-medium text-[#d8e3dc]">
                                            <i data-lucide="lock" class="h-4 w-4 shrink-0 text-[#f2c66d]" aria-hidden="true"></i>
                                            <span>Akses &amp; Otorisasi Peran</span>
                                        </div>
                                        <h4 class="font-display mt-2 text-lg font-bold tracking-[-0.015em] text-white sm:text-xl">
                                            {{ $loginMod['label'] }}
                                        </h4>
                                    </div>
                                    @if (! empty($loginMod['metrik']))
                                        <div class="shrink-0 text-right tabular-nums">
                                            @if ($loginMetricNum !== '')
                                                <span class="font-display block text-2xl font-bold leading-none text-[#f2c66d]">{{ $loginMetricNum }}</span>
                                                <span class="mt-1 block text-xs text-[#d8e3dc]">{{ $loginMetricUnit }}</span>
                                            @else
                                                <span class="text-xs font-bold text-[#f2c66d]">{{ $loginMod['metrik'] }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                @if (count($loginRoles) >= 2)
                                    <p class="mt-3.5 text-xs leading-relaxed text-[#d8e3dc]">
                                        Sebaran akun pengelola resmi pada sistem pelaporan dan autentikasi:
                                    </p>
                                    <dl class="mt-3 grid grid-cols-2 gap-2.5 text-xs"
                                        aria-label="{{ $loginMod['keterangan'] }}">
                                        @foreach ($loginRoles as $roleItem)
                                            <div class="rounded-lg border border-white/10 bg-white/[0.04] px-3 py-2">
                                                <dt class="text-[#d8e3dc]">{{ $roleItem['nama'] }}</dt>
                                                <dd class="font-display mt-0.5 text-base font-bold tabular-nums text-white">{{ $roleItem['jumlah'] }}</dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                @else
                                    <p class="mt-3.5 text-xs leading-relaxed text-[#d8e3dc]">
                                        {{ $loginMod['keterangan'] }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-5 flex flex-wrap items-center gap-2.5 border-t border-white/12 pt-4">
                                <a href="{{ $loginMod['url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="talas-transition inline-flex min-h-[44px] items-center justify-center gap-1.5 rounded-lg bg-[#d49b35] px-4 py-2 text-xs font-bold text-[#0b2017] hover:bg-[#e1aa44] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f2c66d]">
                                    <span>Masuk Portal Operator</span>
                                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                    <span class="sr-only"> (buka di tab baru)</span>
                                </a>

                                @if (! empty($loginMod['tautan_sekunder']['url']))
                                    <a href="{{ $loginMod['tautan_sekunder']['url'] }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="talas-transition inline-flex min-h-[44px] items-center justify-center gap-1.5 rounded-lg border border-white/25 px-3.5 py-2 text-xs font-semibold text-white hover:border-white/55 hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#f2c66d]">
                                        <span>{{ $loginMod['tautan_sekunder']['label'] }}</span>
                                        <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                        <span class="sr-only"> (buka di tab baru)</span>
                                    </a>
                                @endif
                            </div>
                        </article>
                    @endif

                    {{-- Panel Telemetri Kepuasan: Dashboard SKM --}}
                    @if ($skmMod)
                        @php
                            $skmMetricNum = '';
                            $skmMetricUnit = (string) ($skmMod['metrik'] ?? '');
                            if (preg_match('/^([\d.,]+)\s+(.+)$/', $skmMetricUnit, $sm)) {
                                $skmMetricNum = $sm[1];
                                $skmMetricUnit = $sm[2];
                            }

                            $skmDesc = (string) ($skmMod['keterangan'] ?? '');
                            $skmScope = '';
                            $skmBreakdown = [];
                            if (str_contains($skmDesc, ':')) {
                                [$skmScopePart, $skmDetailPart] = explode(':', $skmDesc, 2);
                                $skmScope = trim($skmScopePart);
                                if (preg_match_all('/(Positif|Netral|Negatif)\s+([\d.,]+)\s*\(([\d,]+%)\)/', $skmDetailPart, $smm, PREG_SET_ORDER)) {
                                    foreach ($smm as $sMatch) {
                                        $pctFloat = (float) str_replace([',', '%'], ['.', ''], $sMatch[3]);
                                        $skmBreakdown[$sMatch[1]] = [
                                            'label' => $sMatch[1],
                                            'teks' => $sMatch[1].' '.$sMatch[2].' ('.$sMatch[3].')',
                                            'pct' => $pctFloat,
                                        ];
                                    }
                                }
                            }
                        @endphp
                        <article class="flex flex-col justify-between rounded-xl border border-[#d6ded7] bg-[#f6f5f0] p-5 sm:p-6 {{ $loginMod ? 'lg:col-span-7' : 'lg:col-span-12' }}">
                            <div>
                                <div class="flex flex-wrap items-start justify-between gap-4 border-b border-[#d6ded7] pb-3.5">
                                    <div>
                                        <div class="flex items-center gap-2 text-xs font-semibold text-[#784f14]">
                                            <i data-lucide="bar-chart-3" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                                            <span>Survei Kepuasan Masyarakat</span>
                                        </div>
                                        <h4 class="font-display mt-2 text-lg font-bold tracking-[-0.015em] text-[#10231b] sm:text-xl">
                                            {{ $skmMod['label'] }}
                                        </h4>
                                    </div>

                                    <div class="flex items-center gap-4 tabular-nums">
                                        @if (! empty($skmMod['positif_persen']))
                                            <div>
                                                <span class="font-display block text-2xl font-bold leading-none text-[#166534] sm:text-[1.75rem]">{{ $skmMod['positif_persen'] }}</span>
                                                <span class="mt-1 block text-xs font-medium text-[#3f5249]">Respon Positif</span>
                                            </div>
                                        @endif
                                        @if (! empty($skmMod['metrik']))
                                            <div class="{{ ! empty($skmMod['positif_persen']) ? 'border-l border-[#d6ded7] pl-4' : '' }}">
                                                @if ($skmMetricNum !== '')
                                                    <span class="font-display block text-2xl font-bold leading-none text-[#10231b] sm:text-[1.75rem]">{{ $skmMetricNum }}</span>
                                                    <span class="mt-1 block text-xs font-medium text-[#3f5249]">{{ $skmMetricUnit }}</span>
                                                @else
                                                    <span class="text-xs font-bold text-[#10231b]">{{ $skmMod['metrik'] }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if (count($skmBreakdown) === 3)
                                    <div class="mt-4">
                                        <div class="flex items-center justify-between text-xs text-[#3f5249]">
                                            <span class="font-semibold text-[#10231b]">Proporsi Penilaian Publik</span>
                                            <span>{{ $skmScope !== '' ? $skmScope.' Kabupaten Bogor' : '78 PD Kabupaten Bogor' }}</span>
                                        </div>

                                        <div class="mt-2.5 overflow-hidden rounded-full bg-[#dce4de]"
                                             role="img"
                                             aria-label="{{ $skmMod['keterangan'] }}">
                                            <div data-progress-bar="100" class="flex h-3 w-full">
                                                <span class="h-full border-r border-[#f6f5f0]"
                                                      style="width: {{ $skmBreakdown['Positif']['pct'] }}%; background-color: #166534"
                                                      title="{{ $skmBreakdown['Positif']['teks'] }}"></span>
                                                <span class="h-full border-r border-[#f6f5f0]"
                                                      style="width: {{ $skmBreakdown['Netral']['pct'] }}%; background-color: #d49b35"
                                                      title="{{ $skmBreakdown['Netral']['teks'] }}"></span>
                                                <span class="h-full"
                                                      style="width: {{ $skmBreakdown['Negatif']['pct'] }}%; background-color: #991b1b"
                                                      title="{{ $skmBreakdown['Negatif']['teks'] }}"></span>
                                            </div>
                                        </div>

                                        <ul class="mt-3.5 grid grid-cols-1 gap-2 sm:grid-cols-3">
                                            <li class="flex items-center gap-2 rounded-lg border border-[#d6ded7] bg-white px-3 py-2 text-xs tabular-nums">
                                                <span class="h-2.5 w-2.5 shrink-0 rounded-xs bg-[#166534]" aria-hidden="true"></span>
                                                <span class="font-semibold text-[#166534]">{{ $skmBreakdown['Positif']['teks'] }}</span>
                                            </li>
                                            <li class="flex items-center gap-2 rounded-lg border border-[#d6ded7] bg-white px-3 py-2 text-xs tabular-nums">
                                                <span class="h-2.5 w-2.5 shrink-0 rounded-xs bg-[#d49b35]" aria-hidden="true"></span>
                                                <span class="font-semibold text-[#784f14]">{{ $skmBreakdown['Netral']['teks'] }}</span>
                                            </li>
                                            <li class="flex items-center gap-2 rounded-lg border border-[#d6ded7] bg-white px-3 py-2 text-xs tabular-nums">
                                                <span class="h-2.5 w-2.5 shrink-0 rounded-xs bg-[#991b1b]" aria-hidden="true"></span>
                                                <span class="font-semibold text-[#991b1b]">{{ $skmBreakdown['Negatif']['teks'] }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <p class="mt-3 text-xs leading-relaxed text-[#3f5249]">
                                        {{ $skmMod['keterangan'] }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-5 flex flex-wrap items-center justify-between gap-3 border-t border-[#d6ded7] pt-4">
                                <span class="text-xs font-medium text-[#3f5249]">
                                    Evaluasi kepuasan layanan perangkat daerah terintegrasi
                                </span>
                                <a href="{{ $skmMod['url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="talas-transition inline-flex min-h-[44px] items-center justify-center gap-1.5 rounded-lg border border-[#1b4332] bg-white px-4 py-2 text-xs font-semibold text-[#1b4332] hover:bg-[#1b4332] hover:text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                    <span>Buka Dashboard SKM</span>
                                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                    <span class="sr-only"> (buka di tab baru)</span>
                                </a>
                            </div>
                        </article>
                    @endif
                </div>
            @endif

            {{-- Matriks Kanal Terintegrasi (4 Modul dengan Pembatas Hairline & Ritme Aksi Sejajar) --}}
            @if ($matrixCount > 0)
                <div class="mt-5 overflow-hidden rounded-xl border border-[#d6ded7] bg-white">
                    <div class="grid grid-cols-1 sm:grid-cols-2 {{ $matrixCount === 3 ? 'lg:grid-cols-3' : ($matrixCount >= 4 ? 'lg:grid-cols-4' : '') }}">
                        @foreach ($matrixMods as $mod)
                            @php
                                $kode = $mod['kode'] ?? '';
                                $modMeta = match ($kode) {
                                    'dashboard' => ['icon' => 'server', 'kategori' => 'Monitoring Aplikasi', 'cta' => 'Buka Dashboard Layanan', 'sub' => null],
                                    'scoreweb-kec' => ['icon' => 'check-circle-2', 'kategori' => 'Evaluasi Website', 'cta' => 'Scoreweb Kecamatan (40)', 'sub' => null],
                                    'sop' => ['icon' => 'file-text', 'kategori' => 'Standar Operasional', 'cta' => 'Buka Arsip SOP (PDF)', 'sub' => 'Kepkadis 000.8/241/KPTS/II/2024'],
                                    'chikiber' => ['icon' => 'shield-check', 'kategori' => 'Keamanan Siber', 'cta' => 'Baca Buletin Chikiber', 'sub' => 'Edisi Januari s.d. Desember'],
                                    default => ['icon' => 'globe', 'kategori' => 'Layanan Resmi', 'cta' => 'Akses Modul Resmi', 'sub' => null],
                                };
                                $hasBottomOnSm = $matrixCount % 2 === 0 ? $loop->index < $matrixCount - 2 : $loop->index < $matrixCount - 1;
                            @endphp
                            <article class="flex flex-col justify-between p-5 transition-colors duration-200 hover:bg-[#fafaf7] lg:p-6 {{ ! $loop->last ? 'border-b border-[#e5ebe6]' : '' }} {{ $loop->index % 2 === 0 && ! $loop->last ? 'sm:border-r sm:border-[#e5ebe6]' : '' }} {{ $hasBottomOnSm ? 'sm:border-b sm:border-[#e5ebe6]' : 'sm:border-b-0' }} {{ ! $loop->last ? 'lg:border-r lg:border-[#e5ebe6]' : '' }} lg:border-b-0">
                                <div>
                                    <div class="flex items-center gap-2 text-xs font-medium text-[#3f5249]">
                                        <i data-lucide="{{ $modMeta['icon'] }}" class="h-4 w-4 shrink-0 text-[#1b4332]" aria-hidden="true"></i>
                                        <span>{{ $modMeta['kategori'] }}</span>
                                    </div>

                                    @if (! empty($mod['metrik']))
                                        <p class="font-display mt-3 text-lg font-bold leading-snug tracking-[-0.015em] tabular-nums text-[#784f14]">
                                            {{ $mod['metrik'] }}
                                        </p>
                                    @endif

                                    <h4 class="font-display mt-1 text-base font-bold text-[#10231b]">
                                        {{ $mod['label'] }}
                                    </h4>
                                    <p class="mt-1.5 text-xs leading-relaxed text-[#3f5249]">
                                        {{ $mod['keterangan'] }}
                                    </p>
                                </div>

                                <div class="mt-5 flex flex-col items-start gap-0.5 border-t border-[#e5ebe6] pt-2.5">
                                    <a href="{{ $mod['url'] }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="-my-0.5 inline-flex min-h-[44px] items-center gap-1.5 py-1.5 text-xs font-semibold text-[#1b4332] hover:text-[#0b2017] hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                        <span>{{ $modMeta['cta'] }}</span>
                                        <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                        <span class="sr-only"> (buka di tab baru)</span>
                                    </a>

                                    @if (! empty($mod['tautan_sekunder']['url']))
                                        <a href="{{ $mod['tautan_sekunder']['url'] }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="-my-0.5 inline-flex min-h-[44px] items-center gap-1.5 py-1.5 text-xs font-semibold text-[#784f14] hover:text-[#10231b] hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                            <span>{{ $mod['tautan_sekunder']['label'] }}</span>
                                            <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                            <span class="sr-only"> (buka di tab baru)</span>
                                        </a>
                                    @elseif (! empty($modMeta['sub']))
                                        <p class="-my-0.5 flex min-h-[44px] items-center py-1.5 text-xs font-medium text-[#3f5249]">
                                            {{ $modMeta['sub'] }}
                                        </p>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

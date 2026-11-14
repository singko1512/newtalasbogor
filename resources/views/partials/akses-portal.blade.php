@php
    $ticketService = collect($layananUtama ?? [])->firstWhere('slug', 'pemulihan-website');
    $ticketHighlights = $ticketService['sorotan_alur'] ?? [];
    $totalAkun = collect($portalRoles ?? [])->sum('jumlah');
@endphp

<section id="lacak-tiket" aria-labelledby="lacak-tiket-judul" class="border-b border-[#d6ded7] bg-[#edf2ed] py-14 lg:py-20">
    <div data-scroll-section data-scroll-fade-only class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Header: Judul, Ringkasan & Aksi Autentikasi --}}
        <div class="grid gap-6 border-b border-[#cfd9d2] pb-8 lg:grid-cols-12 lg:items-end lg:gap-10">
            <div class="lg:col-span-7">
                <p class="text-xs font-semibold text-[#784f14]">
                    Pengajuan Layanan &amp; Tiket Gangguan &middot; SOP 04
                </p>
                <h2 id="lacak-tiket-judul" class="font-display mt-2 text-2xl font-bold tracking-[-0.02em] text-[#10231b] sm:text-[1.875rem] sm:leading-[1.15]">
                    Akses Portal Operator &amp; Lacak Status Tiket
                </h2>
                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-[#3f5249]">
                    Permohonan domain, hosting, email kedinasan, serta pelaporan tiket gangguan diajukan oleh operator resmi SKPD, Kecamatan, Desa, dan Admin Diskominfo melalui akun TALAS BOGOR.
                </p>
            </div>

            <div class="lg:col-span-5 lg:justify-self-end">
                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-center lg:justify-end">
                    <a href="{{ $meta['login_url'] }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="talas-transition inline-flex min-h-[46px] w-full items-center justify-center gap-2 rounded-lg border-b-2 border-[#0b2017] bg-[#1b4332] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#143325] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332] active:scale-[0.98] sm:w-auto">
                        <i data-lucide="lock" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                        <span>Masuk Portal Tiket Resmi</span>
                        <i data-lucide="arrow-up-right" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                        <span class="sr-only"> (buka di tab baru)</span>
                    </a>
                    <button type="button"
                            data-open-portal-modal
                            aria-haspopup="dialog"
                            class="talas-transition inline-flex min-h-[46px] w-full cursor-pointer items-center justify-center rounded-lg border border-[#b9c8be] bg-white px-5 py-2.5 text-sm font-semibold text-[#10231b] hover:border-[#1b4332] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332] active:scale-[0.98] sm:w-auto">
                        Panduan Peran Operator
                    </button>
                </div>
                <p class="mt-3 text-xs leading-relaxed text-[#3f5249] lg:text-right">
                    Status dan riwayat tiket hanya tampil setelah login dengan akun instansi.
                </p>
            </div>
        </div>

        <div class="mt-8 grid gap-10 lg:grid-cols-12 lg:gap-10">
            {{-- Ledger Peran Operator Resmi --}}
            @if (! empty($portalRoles))
                <div class="lg:col-span-7">
                    <div class="flex items-baseline justify-between gap-3">
                        <h3 class="font-display text-sm font-bold text-[#10231b]">Peran Operator Resmi</h3>
                        <span class="text-xs tabular-nums text-[#3f5249]">
                            {{ number_format($totalAkun, 0, ',', '.') }} akun &middot; {{ count($portalRoles) }} peran
                        </span>
                    </div>

                    <div class="mt-3 divide-y divide-[#e5ebe6] overflow-hidden rounded-xl border border-[#cfd9d2] bg-white">
                        @foreach ($portalRoles as $role)
                            @php
                                $roleKey = $role['key'] ?? 'role-'.$loop->index;
                                $unitLabel = match ($roleKey) {
                                    'skpd' => 'Perangkat Daerah',
                                    'kec' => 'Kecamatan',
                                    'desa' => 'Desa Terdaftar',
                                    'admin' => 'Bidang Pengelola',
                                    default => 'Akun Resmi',
                                };
                                preg_match_all('/SOP (\d{2})/', (string) ($role['rujukan'] ?? ''), $sopMatches);
                                $rujukanRingkas = $sopMatches[1] !== []
                                    ? 'Rujukan SOP '.implode(', ', $sopMatches[1])
                                    : (! empty($role['unit_bidang']) ? implode(', ', $role['unit_bidang']) : '');
                            @endphp
                            <article data-portal-role-card="{{ $roleKey }}"
                                     class="group grid cursor-pointer gap-x-5 gap-y-2 px-5 py-5 transition-colors duration-200 hover:bg-[#fafaf7] sm:grid-cols-[4.5rem_minmax(0,1fr)] sm:px-6">
                                <div class="flex items-baseline gap-1.5 sm:block">
                                    <span class="font-display text-[1.75rem] font-bold leading-none tracking-[-0.02em] tabular-nums text-[#1b4332]">
                                        {{ number_format($role['jumlah'], 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-[#3f5249] sm:mt-1.5 sm:block">akun</span>
                                </div>

                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-baseline gap-x-2.5 gap-y-0.5">
                                        <h4 class="font-display text-base font-bold leading-snug text-[#10231b] transition-colors group-hover:text-[#1b4332]">
                                            {{ $role['peran'] }}
                                        </h4>
                                        <span class="text-xs font-semibold text-[#784f14]">{{ $unitLabel }}</span>
                                    </div>
                                    <p class="mt-1 text-xs leading-relaxed text-[#3f5249]">{{ $role['keterangan'] ?? '' }}</p>

                                    @if (! empty($role['layanan']))
                                        <ul class="mt-3 grid gap-x-6 gap-y-1.5 text-xs leading-snug text-[#10231b] sm:grid-cols-2">
                                            @foreach ($role['layanan'] as $itemLayanan)
                                                <li class="border-l border-[#cfd9d2] pl-2.5">{{ $itemLayanan }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <div class="mt-3 flex flex-wrap items-center justify-between gap-x-4 border-t border-[#eef2ef] pt-1">
                                        <span class="py-2 text-xs tabular-nums text-[#3f5249]">{{ $rujukanRingkas }}</span>
                                        <div class="-mr-2 flex flex-wrap items-center gap-x-1">
                                            @if (! empty($role['alt_login_url']))
                                                <a href="{{ $role['alt_login_url'] }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="inline-flex min-h-[44px] items-center gap-1 rounded-lg px-2 text-xs font-semibold text-[#784f14] hover:text-[#10231b] hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                                    <span>{{ $role['alt_login_label'] ?? 'Login Admin' }}</span>
                                                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                                    <span class="sr-only"> (buka di tab baru)</span>
                                                </a>
                                            @endif
                                            <button type="button"
                                                    data-open-portal-modal
                                                    data-portal-role-target="{{ $roleKey }}"
                                                    aria-haspopup="dialog"
                                                    class="talas-transition group/role inline-flex min-h-[44px] cursor-pointer items-center gap-1 rounded-lg px-2 text-xs font-bold text-[#1b4332] hover:bg-[#edf2ed] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                                                <span>Lihat panduan</span>
                                                <span class="sr-only"> {{ $role['peran'] }}</span>
                                                <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 transition-transform duration-200 group-hover/role:translate-x-0.5" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Alur Penanganan Tiket Gangguan (SOP 04) --}}
            @if (! empty($ticketHighlights))
                <div class="lg:col-span-5 lg:border-l lg:border-[#cfd9d2] lg:pl-10">
                    <h3 class="font-display text-sm font-bold text-[#10231b]">Alur Penanganan Tiket Gangguan</h3>
                    @if (! empty($ticketService['mutu_baku']))
                        <p class="mt-1 text-xs tabular-nums text-[#3f5249]">SOP 04 &middot; {{ $ticketService['mutu_baku'] }}</p>
                    @endif

                    <ol class="mt-6">
                        @foreach ($ticketHighlights as $tahap)
                            @php
                                $parts = explode('. ', $tahap['judul'] ?? '', 2);
                                $stepTitle = count($parts) === 2 ? $parts[1] : ($tahap['judul'] ?? '');
                            @endphp
                            <li class="relative flex gap-4 pb-6 last:pb-0">
                                @unless ($loop->last)
                                    <span class="absolute top-8 bottom-1 left-[13px] w-px bg-[#b9c8be]" aria-hidden="true"></span>
                                @endunless
                                <span class="relative flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-[#1b4332]/35 bg-white font-display text-xs font-bold tabular-nums text-[#1b4332]" aria-hidden="true">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="min-w-0 pt-0.5">
                                    <p class="text-sm font-semibold leading-snug text-[#10231b]">{{ $stepTitle }}</p>
                                    <p class="mt-1 text-xs leading-relaxed text-[#3f5249]">{{ $tahap['ringkas'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ol>

                    <div class="mt-7 border-t border-[#cfd9d2] pt-4">
                        @if (! empty($ticketService['pelaksana']))
                            <dl class="text-xs leading-relaxed">
                                <dt class="font-semibold text-[#10231b]">Pelaksana</dt>
                                <dd class="mt-0.5 text-[#3f5249]">{{ $ticketService['pelaksana'] }}</dd>
                            </dl>
                        @endif
                        <button type="button"
                                data-open-service-modal
                                data-service-slug="pemulihan-website"
                                aria-haspopup="dialog"
                                class="talas-transition group/sop -ml-2 mt-2 inline-flex min-h-[44px] cursor-pointer items-center gap-1 rounded-lg px-2 text-xs font-bold text-[#1b4332] hover:bg-white/70 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#1b4332]">
                            <span>Lihat alur lengkap SOP 04</span>
                            <i data-lucide="chevron-right" class="h-4 w-4 shrink-0 transition-transform duration-200 group-hover/sop:translate-x-0.5" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

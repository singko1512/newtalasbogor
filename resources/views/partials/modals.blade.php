{{-- Modal Rincian Layanan --}}
<div id="modal-detail-layanan"
     data-modal="service"
     role="dialog"
     aria-modal="true"
     aria-labelledby="modal-layanan-judul"
     aria-hidden="true"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b2017]/75 p-3 backdrop-blur-xs sm:p-5">
    <div data-modal-backdrop class="fixed inset-0" aria-hidden="true"></div>
    <div data-modal-panel
         tabindex="-1"
         class="relative z-10 flex max-h-[92vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl border border-[#d6ded7] bg-white shadow-2xl">
        {{-- Kepala Dokumen Layanan --}}
        <div class="flex shrink-0 items-start justify-between gap-3 border-b border-[#d6ded7] bg-[#f8faf8] px-4 py-3.5 sm:px-7 sm:py-5">
            <div class="flex min-w-0 items-start gap-3 sm:gap-4">
                <img data-modal-service-icon
                     src="{{ asset('images/icons/layanan/domain-bogorkab.svg') }}"
                     alt=""
                     width="40"
                     height="40"
                     class="mt-0.5 h-10 w-10 shrink-0 select-none sm:h-11 sm:w-11">
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-1.5 text-xs">
                        <span data-modal-service-kategori class="font-bold text-[#784f14]">
                            Layanan TALAS BOGOR
                        </span>
                        <span class="text-[#c5d1c8]" aria-hidden="true">&middot;</span>
                        <span data-modal-service-kode class="font-mono text-[11px] font-bold tabular-nums text-[#1b4332]">
                            SOP
                        </span>
                    </div>
                    <h2 id="modal-layanan-judul"
                        data-modal-service-nama
                        class="mt-1 font-display text-lg font-bold leading-snug tracking-tight text-[#10231b] sm:text-xl">
                        Rincian Layanan
                    </h2>
                </div>
            </div>

            <button type="button"
                    data-close-modal
                    aria-label="Tutup rincian layanan"
                    class="talas-transition inline-flex min-h-[44px] min-w-[44px] shrink-0 cursor-pointer items-center justify-center rounded-lg border border-[#d6ded7] bg-white text-[#3f5249] hover:border-[#1b4332] hover:text-[#10231b]">
                <i data-lucide="x" class="h-5 w-5 shrink-0" aria-hidden="true"></i>
            </button>
        </div>

        {{-- Isi Spesifikasi, Berkas, & Alur Prosedur --}}
        <div data-modal-scroll class="flex-1 space-y-5 overflow-y-auto px-4 py-4 sm:px-7 sm:py-5">
            <div data-modal-service-error
                 role="alert"
                 class="hidden rounded-xl border border-[#b45309]/40 bg-[#fffbeb] p-4 text-xs leading-relaxed text-[#78350f]"></div>

            <p data-modal-service-ringkasan class="text-sm leading-relaxed text-[#3f5249]"></p>

            <dl class="grid gap-3 rounded-xl border border-[#d6ded7] bg-[#f8faf8] p-4 text-xs sm:grid-cols-2 sm:gap-4">
                <div>
                    <dt class="font-bold tracking-wide text-[#3f5249] uppercase">Sasaran Pengguna</dt>
                    <dd data-modal-service-sasaran class="mt-1 text-sm font-semibold text-[#10231b]"></dd>
                </div>
                <div>
                    <dt class="font-bold tracking-wide text-[#3f5249] uppercase">Pelaksana Layanan</dt>
                    <dd data-modal-service-pelaksana class="mt-1 text-sm font-semibold text-[#10231b]"></dd>
                </div>
                <div class="border-t border-[#e5ebe6] pt-3">
                    <dt class="font-bold tracking-wide text-[#3f5249] uppercase">Rujukan Prosedur</dt>
                    <dd data-modal-service-sop class="mt-1 font-semibold text-[#1b4332]"></dd>
                </div>
                <div class="border-t border-[#e5ebe6] pt-3">
                    <dt class="font-bold tracking-wide text-[#3f5249] uppercase">Ringkasan Mutu Baku</dt>
                    <dd data-modal-service-mutu class="mt-1 font-semibold text-[#10231b]"></dd>
                </div>
            </dl>

            <section data-modal-sop-section aria-labelledby="modal-sop-docs-heading">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <h3 id="modal-sop-docs-heading" class="font-display text-sm font-bold text-[#10231b]">
                        Dokumen SOP Resmi (PDF)
                    </h3>
                    <span data-modal-sop-note class="hidden rounded border border-[#d6ded7] bg-[#f8faf8] px-2 py-0.5 text-[11px] font-semibold text-[#3f5249]"></span>
                </div>
                <div data-modal-service-sop-list class="mt-2.5 grid gap-2 sm:grid-cols-2"></div>
            </section>

            <section aria-labelledby="modal-kelengkapan-heading">
                <h3 id="modal-kelengkapan-heading" class="font-display text-sm font-bold text-[#10231b]">
                    Persyaratan &amp; Kelengkapan Berkas
                </h3>
                <ul data-modal-service-kelengkapan class="mt-2.5 space-y-2 text-sm text-[#3f5249]"></ul>
            </section>

            <section aria-labelledby="modal-alur-heading">
                <h3 id="modal-alur-heading" class="font-display text-sm font-bold text-[#10231b]">
                    Tahapan Prosedur &amp; Waktu Penyelesaian
                </h3>
                <p data-modal-service-alur-empty
                   class="mt-2.5 hidden rounded-lg border border-dashed border-[#d6ded7] bg-[#f8faf8] px-3.5 py-2.5 text-xs leading-relaxed text-[#3f5249]">
                    Tahapan prosedur belum dirinci pada ringkasan ini. Silakan unduh dokumen SOP resmi atau akses portal pengajuan.
                </p>
                <ol data-modal-service-alur class="mt-2.5 space-y-2 text-sm"></ol>
            </section>

            <div class="rounded-xl border border-[#d6ded7] bg-[#edf2ed]/50 p-4 text-xs leading-relaxed text-[#3f5249]">
                <p class="font-bold text-[#10231b]">Catatan Prosedur &amp; Dasar Hukum</p>
                <p data-modal-service-syarat class="mt-1"></p>
                <p data-modal-service-dasar class="mt-1.5 font-medium text-[#1b4332]"></p>
            </div>
        </div>

        {{-- Kaki Aksi: Unduh PDF SOP Spesifik & Portal Pengajuan --}}
        <div class="flex shrink-0 flex-col gap-2 border-t border-[#d6ded7] bg-[#f8faf8] px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:px-7 sm:py-4">
            <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center">
                <a data-modal-service-pdf
                   href="{{ $sopArchiveUrl ?? 'https://talas.bogorkab.go.id/index.php?pgtype=soplayanan' }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="talas-transition inline-flex min-h-[44px] items-center justify-center gap-1.5 whitespace-nowrap rounded-lg border border-[#d6ded7] bg-white px-3 text-xs font-semibold text-[#1b4332] hover:border-[#1b4332] sm:px-4">
                    <span>Unduh PDF SOP</span>
                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                </a>
                <a data-modal-service-archive-fallback
                   href="{{ $sopArchiveUrl ?? 'https://talas.bogorkab.go.id/index.php?pgtype=soplayanan' }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="talas-transition hidden min-h-[44px] items-center justify-center gap-1.5 rounded-lg border border-[#d6ded7] bg-white px-3 text-xs font-semibold text-[#1b4332] hover:border-[#1b4332] sm:px-4">
                    <span>Arsip {{ $sopCount ?? 10 }} SOP</span>
                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                </a>
                <button type="button"
                        data-close-modal
                        class="talas-transition inline-flex min-h-[44px] cursor-pointer items-center justify-center rounded-lg border border-[#d6ded7] bg-white px-3 text-xs font-semibold text-[#3f5249] hover:border-[#1b4332] hover:text-[#10231b] sm:hidden">
                    Tutup
                </button>
            </div>

            <div class="flex items-center gap-2">
                <button type="button"
                        data-close-modal
                        class="talas-transition hidden min-h-[44px] cursor-pointer items-center justify-center rounded-lg border border-[#d6ded7] bg-white px-4 text-xs font-semibold text-[#3f5249] hover:border-[#1b4332] hover:text-[#10231b] sm:inline-flex">
                    Tutup
                </button>
                <a href="{{ $meta['login_url'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="talas-transition inline-flex min-h-[44px] w-full items-center justify-center gap-1.5 rounded-lg bg-[#1b4332] px-4 text-xs font-semibold text-white hover:bg-[#143325] sm:w-auto">
                    <span>Ajukan via Login Portal</span>
                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Panduan Akses Masuk Portal Operator / Admin --}}
<div id="modal-akses-portal"
     data-modal="portal"
     role="dialog"
     aria-modal="true"
     aria-labelledby="modal-portal-judul"
     aria-describedby="modal-portal-deskripsi"
     aria-hidden="true"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-[#081710]/80 p-3 backdrop-blur-xs sm:p-5">
    <div data-modal-backdrop class="fixed inset-0" aria-hidden="true"></div>
    <div data-modal-panel
         tabindex="-1"
         class="relative z-10 flex max-h-[92dvh] w-full max-w-3xl flex-col overflow-hidden rounded-lg border border-[#d6ded7] border-t-4 border-t-[#1b4332] bg-white shadow-[0_28px_70px_-28px_rgba(0,0,0,0.5)]">
        <div class="flex shrink-0 items-center justify-between gap-3 border-b border-[#d6ded7] bg-[#f8faf8] px-4 py-3 sm:px-7 sm:py-3.5">
            <div class="flex min-w-0 items-center gap-3">
                <img src="{{ asset('images/logo-pemkab-bogor.png') }}"
                     alt=""
                     width="40"
                     height="46"
                     class="h-9 w-auto shrink-0 object-contain sm:h-10">
                <div class="min-w-0">
                    <p class="font-display text-base font-bold leading-tight tracking-tight text-[#10231b] sm:text-lg">TALAS BOGOR</p>
                    <p class="mt-0.5 text-xs leading-snug text-[#3f5249]">Portal Layanan dan Tiket, Diskominfo Kabupaten Bogor</p>
                </div>
            </div>

            <button type="button"
                    data-close-modal
                    aria-label="Tutup panduan masuk portal"
                    class="talas-transition inline-flex min-h-[44px] min-w-[44px] shrink-0 cursor-pointer items-center justify-center rounded-md border border-[#d6ded7] bg-white text-[#3f5249] hover:border-[#1b4332] hover:text-[#10231b]">
                <i data-lucide="x" class="h-5 w-5 shrink-0" aria-hidden="true"></i>
            </button>
        </div>

        <div data-modal-scroll class="flex-1 overflow-y-auto overscroll-contain px-4 py-4 sm:px-7 sm:py-5">
            <div>
                <h2 id="modal-portal-judul" class="font-display text-xl font-bold tracking-tight text-[#10231b] sm:text-2xl">
                    Masuk portal operator
                </h2>
                <p id="modal-portal-deskripsi" class="mt-1 max-w-2xl text-sm leading-relaxed text-[#3f5249]">
                    Pilih instansi Anda untuk memeriksa cakupan layanan sebelum melanjutkan ke autentikasi resmi.
                </p>
            </div>

            <div data-glide-portal-roles
                 class="relative mt-4 grid grid-cols-2 overflow-hidden rounded-lg border border-[#d6ded7] bg-white"
                 role="tablist"
                 aria-label="Pilih peran operator portal">
                @foreach ($portalRoles as $role)
                    @php
                        $roleKey = $role['key'] ?? 'role-' . $loop->index;
                        $cellBorder = ($loop->odd ? 'border-r border-[#e5ebe6] ' : '') . ($loop->index < 2 ? 'border-b border-[#e5ebe6] ' : '');
                    @endphp
                    <button type="button"
                            id="portal-tab-{{ $roleKey }}"
                            role="tab"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                            aria-controls="portal-panel-{{ $roleKey }}"
                            tabindex="{{ $loop->first ? '0' : '-1' }}"
                            data-portal-role="{{ $roleKey }}"
                            class="talas-transition {{ $cellBorder }}relative z-10 flex min-h-[48px] w-full cursor-pointer items-center gap-2.5 px-3 py-2.5 text-left text-xs font-bold sm:px-4 sm:text-sm {{ $loop->first ? 'bg-[#edf2ed] text-[#10231b] shadow-[inset_3px_0_0_#784f14]' : 'bg-white text-[#3f5249] hover:bg-[#f6f5f0]/70 hover:text-[#10231b]' }}">
                        <i data-lucide="{{ $role['ikon'] ?? 'users' }}" class="h-4 w-4 shrink-0 text-[#784f14] sm:h-[18px] sm:w-[18px]" aria-hidden="true"></i>
                        <span>{{ $role['tab_label'] ?? $role['peran'] }}</span>
                    </button>
                @endforeach
            </div>

            <div class="relative mt-4 sm:mt-5" data-portal-role-stage>
                @foreach ($portalRoles as $role)
                    @php
                        $roleKey = $role['key'] ?? 'role-' . $loop->index;
                    @endphp
                    <section id="portal-panel-{{ $roleKey }}"
                             role="tabpanel"
                             aria-labelledby="portal-tab-{{ $roleKey }}"
                             tabindex="0"
                             data-portal-role-panel="{{ $roleKey }}"
                             {{ $loop->first ? '' : 'hidden' }}>
                        <h3 class="font-display text-lg font-bold tracking-tight text-[#10231b] sm:text-xl">
                            Layanan untuk {{ $role['tab_label'] ?? $role['peran'] }}
                        </h3>
                        <p class="mt-1.5 text-sm leading-relaxed text-[#3f5249]">{{ $role['pengguna'] ?? $role['keterangan'] }}</p>

                        @if (! empty($role['unit_bidang']))
                            <div class="mt-3 flex flex-wrap items-center gap-1.5">
                                <span class="text-xs font-bold text-[#784f14]">Unit pengelola:</span>
                                @foreach ($role['unit_bidang'] as $unit)
                                    <span class="rounded border border-[#d6ded7] bg-[#f6f5f0] px-2.5 py-0.5 text-xs font-semibold text-[#10231b]">{{ $unit }}</span>
                                @endforeach
                            </div>
                        @endif

                        <h4 class="mt-4 text-xs font-bold text-[#784f14]">Cakupan layanan</h4>
                        <ul class="mt-2 grid gap-x-6 gap-y-2 sm:grid-cols-2">
                            @foreach ($role['layanan'] ?? [] as $layanan)
                                <li class="flex gap-2.5 text-sm leading-snug text-[#10231b]">
                                    <span class="mt-[0.55rem] h-1 w-1 shrink-0 bg-[#784f14]" aria-hidden="true"></span>
                                    <span>{{ $layanan }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <p class="mt-4 border-t border-[#d6ded7] pt-3 text-xs leading-relaxed text-[#3f5249]">
                            <strong class="font-bold text-[#10231b]">Rujukan:</strong> {{ $role['rujukan'] ?? '' }}
                        </p>

                        @if (! empty($role['alt_login_url']))
                            <p class="mt-1.5 text-xs">
                                <a href="{{ $role['alt_login_url'] }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="inline-flex items-center gap-1 font-semibold text-[#1b4332] hover:underline">
                                    <span>{{ $role['alt_login_label'] ?? 'Login Admin' }}</span>
                                    <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                </a>
                            </p>
                        @endif
                    </section>
                @endforeach
            </div>

            <div class="mt-4 flex gap-2.5 border-t border-[#d6ded7] pt-3.5 sm:mt-5 sm:pt-4">
                <i data-lucide="lock" class="mt-0.5 h-4 w-4 shrink-0 text-[#926018]" aria-hidden="true"></i>
                <p class="text-xs leading-relaxed text-[#3f5249] sm:text-[13px]">
                    <strong class="font-bold text-[#10231b]">Login di talas.bogorkab.go.id.</strong>
                    Gunakan akun instansi Anda atau laman khusus Admin Diskominfo. Situs autentikasi resmi akan terbuka di tab baru.
                </p>
            </div>
        </div>

        <div class="grid shrink-0 grid-cols-2 gap-2 border-t border-[#d6ded7] bg-[#f8faf8] px-4 py-3 sm:flex sm:flex-row sm:items-center sm:justify-end sm:px-7 sm:py-3.5">
            <button type="button"
                    data-close-modal
                    class="talas-transition inline-flex min-h-[44px] cursor-pointer items-center justify-center rounded-md border border-[#d6ded7] bg-white px-4 text-sm font-semibold text-[#3f5249] hover:border-[#1b4332] hover:text-[#10231b] sm:border-transparent sm:bg-transparent sm:px-5 sm:hover:border-transparent sm:hover:bg-[#edf2ed]">
                Tutup
            </button>
            <a href="{{ $meta['admin_login_url'] }}"
               target="_blank"
               rel="noopener noreferrer"
               class="talas-transition inline-flex min-h-[44px] items-center justify-center gap-2 rounded-md border border-[#d6ded7] bg-white px-4 text-sm font-semibold text-[#10231b] hover:border-[#1b4332] hover:bg-[#f6f5f0]">
                <i data-lucide="shield" class="h-4 w-4 shrink-0 text-[#926018]" aria-hidden="true"></i>
                <span>Login Admin</span>
            </a>
            <a href="{{ $meta['login_url'] }}"
               target="_blank"
               rel="noopener noreferrer"
               class="talas-transition col-span-2 inline-flex min-h-[44px] items-center justify-center gap-2 rounded-md border-b-2 border-[#0b2017] bg-[#1b4332] px-5 text-sm font-bold text-white hover:bg-[#143325] active:translate-y-px">
                <i data-lucide="log-in" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                <span class="sm:hidden">Masuk ke TALAS</span>
                <span class="hidden sm:inline">Masuk dengan akun instansi</span>
            </a>
        </div>
    </div>
</div>

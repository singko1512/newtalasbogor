<section id="lacak-tiket" aria-labelledby="lacak-tiket-judul" class="border-b border-[#d6ded7] bg-[#edf2ed] py-12 lg:py-14">
    <div data-scroll-section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between lg:gap-10">
            <div class="max-w-2xl">
                <p class="font-mono text-xs font-bold tracking-wide text-[#926018] uppercase">
                    Pengajuan Layanan &amp; Tiket Gangguan (SOP 04)
                </p>
                <h2 id="lacak-tiket-judul" class="mt-1 text-2xl font-bold tracking-tight text-[#10231b] sm:text-[1.75rem]">
                    Akses Portal Operator &amp; Lacak Status Tiket
                </h2>
                <div aria-hidden="true" class="mt-2.5 h-1 w-12 rounded-full bg-[#d49b35]"></div>
                <p class="mt-3 text-sm leading-relaxed text-[#3f5249] sm:text-base">
                    Pengajuan permohonan domain, hosting, email kedinasan, maupun pelaporan dan pemantauan tiket error dilakukan oleh operator resmi SKPD, Kecamatan, Desa, dan Admin Diskominfo melalui autentikasi resmi TALAS BOGOR.
                </p>
            </div>

            <div class="flex w-full shrink-0 flex-col gap-3 sm:w-auto sm:flex-row sm:flex-wrap sm:items-center">
                <a href="{{ $meta['login_url'] }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="talas-transition inline-flex min-h-[44px] w-full items-center justify-center gap-1.5 rounded-lg bg-[#1b4332] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#143325] active:scale-[0.98] sm:w-auto">
                    <i data-lucide="lock" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                    <span>Masuk Portal Tiket Resmi</span>
                    <i data-lucide="arrow-up-right" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                </a>
                <button type="button"
                        data-open-portal-modal
                        class="talas-transition inline-flex min-h-[44px] w-full cursor-pointer items-center justify-center rounded-lg border border-[#10231b]/25 bg-white px-5 py-2.5 text-sm font-semibold text-[#10231b] hover:border-[#1b4332] hover:bg-[#f6f5f0] active:scale-[0.98] sm:w-auto">
                    Panduan Peran Operator
                </button>
            </div>
        </div>

        @if (! empty($portalRoles))
            <dl class="mt-8 grid grid-cols-2 gap-3 lg:grid-cols-4">
                @foreach ($portalRoles as $role)
                    <div class="rounded-lg border border-[#d6ded7] bg-white px-4 py-3.5">
                        <dt class="text-xs font-semibold text-[#3f5249]">{{ $role['peran'] }}</dt>
                        <dd class="font-display mt-1 text-2xl font-bold tabular-nums text-[#1b4332]">{{ number_format($role['jumlah'], 0, ',', '.') }}</dd>
                        <p class="mt-0.5 text-xs text-[#3f5249]">{{ $role['keterangan'] }}</p>
                    </div>
                @endforeach
            </dl>
        @endif
    </div>
</section>

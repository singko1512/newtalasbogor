<header data-header-surface
        class="talas-header talas-transition sticky top-0 z-40 border-b border-[#d6ded7] bg-white/98 text-[#10231b] shadow-[0_1px_2px_rgba(16,35,27,0.05)]">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2.5 sm:px-6 lg:px-8">
        <a href="#konten-utama"
           class="group flex min-h-[44px] min-w-0 items-center gap-3 rounded-lg pr-2">
            {{-- Lambang Resmi Pemerintah Kabupaten Bogor & Diskominfo --}}
            <img src="{{ asset('images/logo-pemkab-bogor.png') }}"
                 alt="Logo Diskominfo Kabupaten Bogor"
                 width="36"
                 height="42"
                 class="h-9 w-auto shrink-0 object-contain drop-shadow-xs">
            <span class="min-w-0">
                <span class="font-display block text-base font-bold leading-tight tracking-tight text-[#10231b] sm:text-[17px]">
                    Talas Bogor
                </span>
                <span class="block text-[11px] font-medium leading-tight text-[#3f5249]">
                    Diskominfo Kab. Bogor
                </span>
            </span>
        </a>

        <nav aria-label="Navigasi utama portal" data-glide-nav class="relative hidden items-center gap-1 lg:flex">
            <a href="#layanan"
               class="talas-transition relative z-10 inline-flex min-h-[44px] items-center rounded-lg px-3.5 text-sm font-medium text-[#3f5249] hover:bg-[#edf2ed]/60 hover:text-[#10231b]">
                Layanan
            </a>
            <a href="#direktori"
               class="talas-transition relative z-10 inline-flex min-h-[44px] items-center rounded-lg px-3.5 text-sm font-medium text-[#3f5249] hover:bg-[#edf2ed]/60 hover:text-[#10231b]">
                Direktori
            </a>
            <a href="#capaian"
               class="talas-transition relative z-10 inline-flex min-h-[44px] items-center rounded-lg px-3.5 text-sm font-medium text-[#3f5249] hover:bg-[#edf2ed]/60 hover:text-[#10231b]">
                SPBE &amp; Smart City
            </a>
            <a href="#ekosistem"
               class="talas-transition relative z-10 inline-flex min-h-[44px] items-center rounded-lg px-3.5 text-sm font-medium text-[#3f5249] hover:bg-[#edf2ed]/60 hover:text-[#10231b]">
                Ekosistem
            </a>
            <a href="#lacak-tiket"
               class="talas-transition relative z-10 inline-flex min-h-[44px] items-center rounded-lg px-3.5 text-sm font-medium text-[#3f5249] hover:bg-[#edf2ed]/60 hover:text-[#10231b]">
                Akses Tiket
            </a>
        </nav>

        <div class="flex shrink-0 items-center gap-2">
            <button type="button"
                    data-open-portal-modal
                    aria-haspopup="dialog"
                    class="talas-login-btn relative hidden h-9 cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-[#1b4332]/75 bg-white px-3.5 text-[13px] font-semibold tracking-[-0.01em] text-[#1b4332] hover:border-[#1b4332] hover:shadow-[0_2px_10px_-3px_rgba(27,67,50,0.3)] active:scale-[0.97] sm:inline-flex">
                <i data-lucide="log-in" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                <span>login</span>
                <span class="talas-login-charge gap-1.5 px-3.5" aria-hidden="true">
                    <i data-lucide="log-in" class="h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                    <span>login</span>
                </span>
            </button>

            <button type="button"
                    data-mobile-nav-toggle
                    aria-expanded="false"
                    aria-controls="nav-seluler"
                    aria-label="Buka menu navigasi"
                    class="talas-transition inline-flex min-h-[44px] min-w-[44px] cursor-pointer items-center justify-center gap-2 rounded-lg border border-[#d6ded7] bg-[#f6f5f0] px-3 text-sm font-semibold text-[#10231b] hover:bg-[#edf2ed] lg:hidden">
                <i data-lucide="menu" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                <span>Menu</span>
            </button>
        </div>
    </div>

    <div id="nav-seluler"
         data-mobile-nav-menu
         class="hidden border-t border-[#d6ded7] bg-white px-4 py-3 lg:hidden">
        <nav aria-label="Navigasi seluler" class="grid gap-1">
            <a href="#rekap" class="flex min-h-[44px] items-center rounded-lg px-3 text-sm font-medium text-[#10231b] hover:bg-[#edf2ed]">
                Rekapitulasi Layanan (755)
            </a>
            <a href="#layanan" class="flex min-h-[44px] items-center rounded-lg px-3 text-sm font-medium text-[#10231b] hover:bg-[#edf2ed]">
                Katalog 9 Layanan &amp; 10 SOP
            </a>
            <a href="#direktori" class="flex min-h-[44px] items-center rounded-lg px-3 text-sm font-medium text-[#10231b] hover:bg-[#edf2ed]">
                Direktori Aplikasi &amp; Website
            </a>
            <a href="#capaian" class="flex min-h-[44px] items-center rounded-lg px-3 text-sm font-medium text-[#10231b] hover:bg-[#edf2ed]">
                Indeks SPBE &amp; Smart City
            </a>
            <a href="#ekosistem" class="flex min-h-[44px] items-center rounded-lg px-3 text-sm font-medium text-[#10231b] hover:bg-[#edf2ed]">
                Ekosistem &amp; SKM Diskominfo
            </a>
            <a href="#lacak-tiket" class="flex min-h-[44px] items-center rounded-lg px-3 text-sm font-medium text-[#10231b] hover:bg-[#edf2ed]">
                Akses Tiket Operator
            </a>
            <button type="button"
                    data-open-portal-modal
                    aria-haspopup="dialog"
                    class="talas-login-btn relative mt-2 flex min-h-[44px] w-full cursor-pointer items-center justify-center gap-2 rounded-lg border border-[#1b4332] bg-white px-4 text-sm font-semibold text-[#1b4332] active:scale-[0.98]">
                <i data-lucide="log-in" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                <span>login</span>
                <span class="talas-login-charge gap-2 px-4" aria-hidden="true">
                    <i data-lucide="log-in" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                    <span>login</span>
                </span>
            </button>
        </nav>
    </div>

    <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 bottom-0 h-[2px] overflow-hidden">
        <div data-scroll-progress class="h-full w-full origin-left scale-x-0 bg-[#1b4332]/85 will-change-transform"></div>
    </div>
</header>

@php
    $navigasiBagian = [
        ['label' => 'Katalog 9 Layanan', 'href' => '#layanan'],
        ['label' => 'Direktori Aplikasi & Desa.id', 'href' => '#direktori'],
        ['label' => 'Capaian SPBE & Smart City', 'href' => '#capaian'],
        ['label' => 'Ekosistem Monitoring & SKM', 'href' => '#ekosistem'],
        ['label' => 'Akses Portal & Tiket', 'href' => '#lacak-tiket'],
    ];

    $tautanResmi = [
        ['label' => 'Portal Login Operator', 'url' => $meta['login_url']],
        ['label' => 'Login Admin Diskominfo', 'url' => $meta['admin_login_url']],
        ['label' => 'SOP Layanan (PDF)', 'url' => $meta['sop_archive_url']],
        ['label' => 'Dashboard Layanan', 'url' => $meta['dashboard_layanan_url']],
        ['label' => 'Dashboard SKM', 'url' => $meta['skm_url']],
        ['label' => 'Buletin Chikiber', 'url' => $meta['chikiber_url']],
    ];
@endphp

<footer id="kontak" class="overflow-hidden border-t border-[#d49b35]/35 bg-[#10231b] text-[#e8efe9]">
    <div data-scroll-section data-scroll-fade-only class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-14">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-12 lg:items-start lg:gap-12">
            {{-- Kolom 1: Identitas Resmi & Kontak Diskominfo Kabupaten Bogor --}}
            <div class="min-w-0 md:col-span-2 lg:col-span-5">
                <a href="#konten-utama" class="inline-flex min-h-[44px] items-center gap-3 rounded-xl bg-white px-3.5 py-2 shadow-sm focus-visible:outline-[#e7c172]">
                    <img src="{{ asset('images/logo-diskominfo-bogorkab.png') }}"
                         alt="Logo Diskominfo Kabupaten Bogor"
                         width="160"
                         height="38"
                         class="h-8 w-auto object-contain">
                </a>

                <p class="font-display mt-4 text-base font-bold text-white">
                    Talas Bogor &middot; {{ $meta['kepanjangan'] }}
                </p>

                <p class="mt-2 max-w-md text-sm leading-relaxed text-[#c7d7cd]">
                    Pengelola layanan domain, hosting, email kedinasan, dan pengamanan aplikasi Pemerintah Kabupaten Bogor.
                </p>

                <dl class="mt-5 space-y-2.5 text-xs text-[#c7d7cd]">
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="map-pin" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#e7c172]" aria-hidden="true"></i>
                        <div>
                            <dt class="inline font-semibold text-white">Alamat Kantor:</dt>
                            <dd class="inline">{{ $meta['kontak']['alamat'] }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="phone" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#e7c172]" aria-hidden="true"></i>
                        <div>
                            <dt class="inline font-semibold text-white">Telepon:</dt>
                            <dd class="inline">
                                <a href="tel:{{ preg_replace('/\D+/', '', $meta['kontak']['telepon']) }}" class="-my-2.5 inline-flex min-h-[44px] items-center rounded-xs py-2.5 underline decoration-white/30 hover:text-white focus-visible:outline-[#e7c172]">{{ $meta['kontak']['telepon'] }}</a>
                            </dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="mail" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#e7c172]" aria-hidden="true"></i>
                        <div>
                            <dt class="inline font-semibold text-white">Email Resmi:</dt>
                            <dd class="inline">
                                <a href="mailto:{{ $meta['kontak']['email'] }}" class="-my-2.5 inline-flex min-h-[44px] items-center rounded-xs py-2.5 underline decoration-white/30 hover:text-white focus-visible:outline-[#e7c172]">{{ $meta['kontak']['email'] }}</a>
                            </dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <i data-lucide="clock" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#e7c172]" aria-hidden="true"></i>
                        <div>
                            <dt class="inline font-semibold text-white">Jam Layanan:</dt>
                            <dd class="inline">{{ $meta['kontak']['jam_layanan'] }}</dd>
                        </div>
                    </div>
                </dl>
            </div>

            {{-- Kolom 2: Navigasi Seksi Portal --}}
            <div class="min-w-0 md:col-span-1 lg:col-span-3">
                <h2 class="font-display text-sm font-bold tracking-[0.01em] text-white">
                    Navigasi Portal
                </h2>
                <ul class="mt-2.5 space-y-0.5 text-sm">
                    @foreach ($navigasiBagian as $nav)
                        <li>
                            <a href="{{ $nav['href'] }}"
                               class="talas-transition inline-flex min-h-[44px] w-full items-center rounded-xs text-[#c7d7cd] hover:text-white hover:underline focus-visible:outline-[#e7c172]">
                                {{ $nav['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Kolom 3: Ekosistem & Tautan Resmi TALAS --}}
            <div class="min-w-0 md:col-span-1 lg:col-span-4">
                <h2 class="font-display text-sm font-bold tracking-[0.01em] text-white">
                    Ekosistem Sistem Resmi
                </h2>
                <ul class="mt-2.5 space-y-0.5 text-sm">
                    @foreach ($tautanResmi as $tautan)
                        <li>
                            <a href="{{ $tautan['url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="talas-transition group inline-flex min-h-[44px] w-full items-center justify-between gap-2 rounded-xs text-[#c7d7cd] hover:text-white hover:underline focus-visible:outline-[#e7c172]">
                                <span>{{ $tautan['label'] }}</span>
                                <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0 opacity-75 group-hover:opacity-100" aria-hidden="true"></i>
                                <span class="sr-only"> (buka di tab baru)</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col gap-2 border-t border-white/15 pt-6 text-xs text-[#c7d7cd] sm:flex-row sm:items-center sm:justify-between">
            <p>{{ $meta['instansi'] }} &copy; {{ $meta['hak_cipta'] }}</p>
            <p>Data publik terverifikasi: {{ $meta['tanggal_observasi'] }}</p>
        </div>
    </div>
</footer>

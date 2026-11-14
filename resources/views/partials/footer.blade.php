@php
    $tautanResmi = [
        ['label' => 'SOP Layanan (PDF)', 'url' => $meta['sop_archive_url']],
        ['label' => 'Dashboard Layanan', 'url' => $meta['dashboard_layanan_url']],
        ['label' => 'Dashboard SKM', 'url' => $meta['skm_url']],
        ['label' => 'Buletin Chikiber', 'url' => $meta['chikiber_url']],
    ];
@endphp

<footer id="kontak" class="overflow-hidden bg-[#10231b] text-[#e8efe9]">
    <div data-scroll-section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-12 lg:px-8">
        <div class="grid gap-10 md:grid-cols-[minmax(0,1fr)_minmax(220px,280px)] md:items-start md:gap-12">
            {{-- Identitas Resmi & Kontak Diskominfo Kabupaten Bogor --}}
            <div class="min-w-0">
                <a href="#konten-utama" class="inline-flex items-center gap-3 rounded-xl bg-white px-3.5 py-2 shadow-sm focus-visible:outline-[#e7c172]">
                    <img src="{{ asset('images/logo-diskominfo-bogorkab.png') }}"
                         alt="Logo Diskominfo Kabupaten Bogor"
                         width="160"
                         height="38"
                         class="h-8 w-auto object-contain">
                </a>

                <p class="mt-4 text-base font-bold text-white">
                    Talas Bogor &middot; {{ $meta['kepanjangan'] }}
                </p>

                <p class="mt-2 max-w-md text-sm leading-relaxed text-[#c7d7cd]">
                    Pengelola layanan domain, hosting, email kedinasan, dan pengamanan aplikasi Kabupaten Bogor.
                </p>

                <dl class="mt-5 space-y-2.5 text-xs text-[#c7d7cd]">
                    <div class="flex items-start gap-2">
                        <i data-lucide="map-pin" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#e7c172]" aria-hidden="true"></i>
                        <div>
                            <dt class="inline font-semibold text-white">Alamat Kantor:</dt>
                            <dd class="inline">{{ $meta['kontak']['alamat'] }}</dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <i data-lucide="phone" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#e7c172]" aria-hidden="true"></i>
                        <div>
                            <dt class="inline font-semibold text-white">Telepon:</dt>
                            <dd class="inline">
                                <a href="tel:{{ preg_replace('/\D+/', '', $meta['kontak']['telepon']) }}" class="rounded-xs underline decoration-white/30 hover:text-white focus-visible:outline-[#e7c172]">{{ $meta['kontak']['telepon'] }}</a>
                            </dd>
                        </div>
                    </div>
                    <div class="flex items-start gap-2">
                        <i data-lucide="mail" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#e7c172]" aria-hidden="true"></i>
                        <div>
                            <dt class="inline font-semibold text-white">Email Resmi:</dt>
                            <dd class="inline">
                                <a href="mailto:{{ $meta['kontak']['email'] }}" class="rounded-xs underline decoration-white/30 hover:text-white focus-visible:outline-[#e7c172]">{{ $meta['kontak']['email'] }}</a>
                            </dd>
                        </div>
                    </div>
                </dl>
            </div>

            {{-- Tautan Eksternal Inti TALAS --}}
            <div class="min-w-0">
                <h2 class="font-display text-base font-bold text-white">
                    Tautan Resmi TALAS
                </h2>
                <ul class="mt-3 text-sm">
                    @foreach ($tautanResmi as $tautan)
                        <li>
                            <a href="{{ $tautan['url'] }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="talas-transition group flex min-h-[44px] w-full items-center gap-1.5 rounded-xs text-[#c7d7cd] hover:text-white hover:underline focus-visible:outline-[#e7c172] lg:min-h-0 lg:py-1.5">
                                <span>{{ $tautan['label'] }}</span>
                                <i data-lucide="arrow-up-right" class="h-3.5 w-3.5 shrink-0 opacity-75 group-hover:opacity-100" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-8 border-t border-white/15 pt-6 text-xs text-[#c7d7cd]">
            <p>{{ $meta['instansi'] }} &copy; {{ $meta['hak_cipta'] }}</p>
        </div>
    </div>
</footer>

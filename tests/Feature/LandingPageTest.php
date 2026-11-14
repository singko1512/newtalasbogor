<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_renders_verified_talas_sections_and_excludes_out_of_scope_content(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('TALAS BOGOR');
        $response->assertSee('Portal Layanan &amp; Aplikasi Digital', false);
        $response->assertSee('Selamat Datang di Portal TALAS BOGOR');
        $response->assertSee('Rekapitulasi Layanan Kabupaten Bogor');
        $response->assertSee('bg-[#d49b35]');
        $response->assertSee('images/logo-pemkab-bogor.png');
        $response->assertSee('images/logo-diskominfo-bogorkab.png');
        $response->assertSee('images/hero-bogor.webp');
        $response->assertSee('Permohonan Domain Bogorkab');
        $response->assertSee('Perubahan Setting Domain');
        $response->assertSee('Pemulihan Error Website');
        $response->assertSee('239');
        $response->assertSee('195');
        $response->assertSee('100');
        $response->assertSee('416');
        $response->assertSee('755');
        $response->assertSee('4,34');
        $response->assertSee('MEMUASKAN');
        $response->assertSee('14.737');
        $response->assertSee('SOP 01');
        $response->assertSee('Standar Teknis Siklus Pengembangan Aplikasi');
        $response->assertSee('SOP 10');
        $response->assertSee('Pengaktifan Domain Bogorkab');
        $response->assertSee('Perkembangan Smart City');
        $response->assertSee('Scoreweb Kecamatan (40)');
        $response->assertSee('Scoreweb Kelurahan (19)');
        $response->assertSee('Dashboard SKM');
        $response->assertSee('Akses Portal Operator &amp; Lacak Status Tiket', false);
        $response->assertSee('Portal Login &amp; Admin', false);
        $response->assertSee('Chikiber');
        $response->assertSee('Jalan Tegar Beriman, Cibinong, Kabupaten Bogor');
        $response->assertSee('(021) 8758605');
        $response->assertSee('diskominfo@bogorkab.go.id');
        $response->assertSee('id="modal-detail-layanan"', false);
        $response->assertSee('id="modal-akses-portal"', false);
        $response->assertSee('id="talas-directory-data"', false);
        $response->assertDontSee('[DATA BELUM TERVERIFIKASI]');
        $response->assertDontSee('Identitas Visual Placeholder');
        $response->assertDontSee('menunggu publikasi resmi');
        $response->assertDontSee('talas-hero-ecosystem.jpg');

        $html = $response->getContent();
        $this->assertIsString($html);
        $this->assertStringNotContainsString('digidesa', mb_strtolower($html));
        $this->assertStringNotContainsString("\u{2014}", $html);
    }

    public function test_directory_searches_full_verified_dataset_and_handles_invalid_inputs(): void
    {
        $websiteResponse = $this->get('/?tab=website&q=SETDA');

        $websiteResponse->assertStatus(200);
        $websiteResponse->assertSee('setda.bogorkab.go.id');
        $websiteResponse->assertSeeInOrder([
            'id="tab-aplikasi"',
            'aria-selected="false"',
            'id="tab-website"',
            'aria-selected="true"',
        ], false);

        // Pencarian di luar 5 sampel awal (desa ke-258 / CIBINONG) harus ditemukan pada dataset penuh
        $deepDesaResponse = $this->get('/?tab=desaid&q=sentul');
        $deepDesaResponse->assertStatus(200);
        $deepDesaResponse->assertSee('sentul-babakanmadang.desa.id');

        // Pencarian OPD di luar 6 sampel awal
        $deepOpdResponse = $this->get('/?tab=aplikasi&q=DISDUKCAPIL');
        $deepOpdResponse->assertStatus(200);
        $deepOpdResponse->assertSee('DISDUKCAPIL');

        // Filter kategori website & clamp halaman out-of-range
        $catResponse = $this->get('/?tab=website&web_cat=PEMKAB&page=9999');
        $catResponse->assertStatus(200);
        $catResponse->assertSee('bogorkab.go.id');
        $catResponse->assertSee('Hal. 1 / 1');

        $fallbackResponse = $this->get('/?tab=invalid_tab&q=<script>alert(1)</script>&page=-5');

        $fallbackResponse->assertStatus(200);
        $fallbackResponse->assertDontSee('<script>alert(1)</script>', false);
        $fallbackResponse->assertSee('Tidak ditemukan data yang cocok pada direktori');
        $fallbackResponse->assertSeeInOrder([
            'id="tab-aplikasi"',
            'aria-selected="true"',
            'id="tab-website"',
            'aria-selected="false"',
        ], false);
    }

    public function test_directory_search_shows_empty_notice_when_entry_does_not_match(): void
    {
        $response = $this->get('/?tab=desaid&q=tidakmungkinadadicuplikan');

        $response->assertStatus(200);
        $response->assertSee('Tidak ditemukan data yang cocok pada direktori Registrasi Domain Desa.id');
    }

    public function test_services_section_embeds_curated_icons_and_verified_sop_dossier_json(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('id="talas-services-json"', false);
        $response->assertSee('data-sop-jump', false);
        $response->assertSee('https://talas.bogorkab.go.id/index.php?pgtype=soplayanan', false);
        $response->assertSee('images/icons/layanan/domain-bogorkab.svg');
        $response->assertSee('images/icons/layanan/sop-document.svg');
        $response->assertSee('https://talas.bogorkab.go.id/upl/soplayanan/SOP_PA_05.pdf');
        $response->assertSee('Webmin');
        $response->assertSee('iRedAdmin');

        $html = $response->getContent();
        $this->assertIsString($html);
        $this->assertSame(1, preg_match('/<script id="talas-services-json" type="application\/json">(.*?)<\/script>/s', $html, $matches));

        /** @var array<string, array<string, mixed>> $servicesPayload */
        $servicesPayload = json_decode(html_entity_decode($matches[1], ENT_QUOTES, 'UTF-8'), true, 512, JSON_THROW_ON_ERROR);
        $validSopCodes = collect(config('talas.sop'))->pluck('kode')->all();

        foreach (config('talas.layanan_utama') as $service) {
            $iconRelative = $service['icon_path'] ?? '';
            $this->assertNotSame('', $iconRelative);
            $this->assertFileExists(public_path($iconRelative));
            $this->assertNotEmpty($service['sop_refs']);
            foreach ($service['sop_refs'] as $sopCode) {
                $this->assertContains($sopCode, $validSopCodes);
            }
        }

        $this->assertFalse($servicesPayload['reset-password']['has_dedicated_sop']);
        $this->assertSame(['SOP 07'], collect($servicesPayload['reset-password']['dokumen_sop'])->pluck('kode')->all());

        $this->assertFalse($servicesPayload['va-pentest']['has_dedicated_sop']);
        $this->assertSame(
            ['SOP 01', 'SOP 10', 'SOP 02', 'SOP 03', 'SOP 04', 'SOP 09'],
            collect($servicesPayload['va-pentest']['dokumen_sop'])->pluck('kode')->all(),
        );

        $this->assertTrue($servicesPayload['setting-domain']['has_dedicated_sop']);
        $this->assertSame(
            [
                'https://talas.bogorkab.go.id/upl/soplayanan/SOP_PA_05.pdf',
                'https://talas.bogorkab.go.id/upl/soplayanan/SOP_PA_09.pdf',
                'https://talas.bogorkab.go.id/upl/soplayanan/SOP_PA_10.pdf',
            ],
            collect($servicesPayload['setting-domain']['dokumen_sop'])->pluck('url')->all(),
        );

        $this->assertSame(
            ['SOP 02', 'SOP 03', 'SOP 01'],
            collect($servicesPayload['domain-hosting']['dokumen_sop'])->pluck('kode')->all(),
        );
        $this->assertNotEmpty($servicesPayload['pemulihan-website']['alur']);
    }

    public function test_service_catalog_fails_fast_when_referencing_unknown_sop_code(): void
    {
        $services = config('talas.layanan_utama');
        $services[0]['sop_refs'] = ['SOP 99'];
        config(['talas.layanan_utama' => $services]);

        $this->withoutExceptionHandling();
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('SOP 99');

        $this->get('/');
    }

    public function test_landing_page_includes_official_legacy_documents_and_submodules(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Rincian Domain & regulasi SPBE resmi
        $response->assertSee('Rekapitulasi Nilai 4 Domain SPBE (2025)');
        $response->assertSee('4,80');
        $response->assertSee('3,181');
        $response->assertSee('https://talas.bogorkab.go.id/index.php?pgtype=spbe', false);
        $response->assertSee('https://talas.bogorkab.go.id/index.php?pgtype=perbupspbe', false);
        $response->assertSee('https://talas.bogorkab.go.id/index.php?pgtype=stpaspbe', false);
        $response->assertSee('https://talas.bogorkab.go.id/upl/permen6/lampiran1_permen6_2025.pdf', false);
        $response->assertSee('https://talas.bogorkab.go.id/upl/permen6/lampiran2_permen6_2025.pdf', false);

        // Regulasi, surat evaluasi, & komponen Smart City resmi
        $response->assertSee('https://talas.bogorkab.go.id/index.php?pgtype=smartcity', false);
        $response->assertSee('https://talas.bogorkab.go.id/talas/upl_doc/perbup_smartcity_2020.pdf', false);
        $response->assertSee('https://talas.bogorkab.go.id/talas/upl_doc/kepbup_dewan_smartcity_2020.pdf', false);
        $response->assertSee('Baseline 3,96');
        $response->assertSee('B-1003/DJAI/AI.01.04/12/2022');
        $response->assertSee('B-1384/DJAI/AI.01.04/12/2023');
        $response->assertSee('B-1478/DJAI/AI.01.02/11/2024');

        // Dashboard Layanan, Asesmen 57 Layanan, Sifat Layanan, Scoreweb, & riwayat Desa.id
        $response->assertSee('Asesmen 57 Layanan');
        $response->assertSee('xpage=assesment', false);
        $response->assertSee('Hosting Lainnya: 37');
        $response->assertSee('Colocation Luar: 4');
        $response->assertSee('Publikasi/Informasi Digital (47)');
        $response->assertDontSee('Khusus (47)');
        $response->assertSee('Pemkab, Kel. &amp; Lainnya', false);
        $response->assertSee('Nilai1 = Jumlah Konten x 60%');
        $response->assertSee('2018 (120)');
        $response->assertSee('2025 (12)');

        // Aritmetika KPI website harus berjumlah tepat 100 (38 SKPD + 40 Kec + 22 Pemkab/Kel/Lainnya)
        $webKpis = collect(config('talas.direktori.website.kartu_kpi'))->keyBy('kode');
        $this->assertSame(
            (int) $webKpis['total']['nilai'],
            (int) $webKpis['skpd']['nilai'] + (int) $webKpis['kecamatan']['nilai'] + (int) $webKpis['lainnya']['nilai'],
        );

        // Login Admin Diskominfo (?pgtype=admin), SKM breakdown, & Chikiber 12 edisi
        $response->assertSee('https://talas.bogorkab.go.id/index.php?pgtype=admin', false);
        $response->assertSee('Aplikasi Informatika');
        $response->assertSee('Infrastruktur Teknologi');
        $response->assertSee('Persandian');
        $response->assertSee('Positif 9.318 (63,2%)');
        $response->assertSee('12 Edisi Bulanan');

        $html = $response->getContent();
        $this->assertIsString($html);
        $this->assertSame(0, preg_match('/<a\b[^>]*>(?:(?!<\/a>).)*<a\b/is', $html), 'Anchor bersarang tidak boleh ada di markup HTML');
        $this->assertStringNotContainsString('digidesa', mb_strtolower($html));
        $this->assertStringNotContainsString("\u{2014}", $html);
    }

    public function test_directory_filter_scopes_web_cat_handles_scientific_page_and_excludes_url_protocols(): void
    {
        // web_cat tidak boleh mengaktifkan status filter atau tombol Reset di tab non-website
        $nonWebsiteResponse = $this->get('/?tab=aplikasi&web_cat=PEMKAB&page=1e999');
        $nonWebsiteResponse->assertStatus(200);
        $nonWebsiteResponse->assertSee('data-active-tab="aplikasi"', false);
        $nonWebsiteResponse->assertSee('data-web-category="SEMUA"', false);
        $nonWebsiteResponse->assertSee('Hal. 1 / 5');

        $nonWebsiteHtml = $nonWebsiteResponse->getContent();
        $this->assertIsString($nonWebsiteHtml);
        $this->assertSame(1, preg_match('/<a\s[^>]*data-dir-reset[^>]*>/s', $nonWebsiteHtml, $resetMatches));
        $this->assertStringContainsString('hidden', $resetMatches[0]);

        // Ketika di tab website + web_cat aktif, tombol Reset harus tampil (tanpa class hidden)
        $websiteCatResponse = $this->get('/?tab=website&web_cat=SKPD');
        $websiteCatResponse->assertStatus(200);
        $websiteCatResponse->assertSee('data-web-category="SKPD"', false);
        $websiteCatHtml = $websiteCatResponse->getContent();
        $this->assertIsString($websiteCatHtml);
        $this->assertSame(1, preg_match('/<a\s[^>]*data-dir-reset[^>]*>/s', $websiteCatHtml, $activeResetMatches));
        $this->assertStringNotContainsString('hidden', $activeResetMatches[0]);

        // Pencarian protokol "https" tidak boleh cocok palsu terhadap kolom URL tersembunyi
        $protocolSearchResponse = $this->get('/?tab=website&q=https');
        $protocolSearchResponse->assertStatus(200);
        $protocolSearchResponse->assertSee('Tidak ditemukan data yang cocok pada direktori Website Resmi bogorkab.go.id');

        // Pencarian halaman nol aman kembali ke Hal. 1
        $zeroPageResponse = $this->get('/?tab=aplikasi&page=0');
        $zeroPageResponse->assertStatus(200);
        $zeroPageResponse->assertSee('Hal. 1 / 5');
    }

    public function test_services_spotlight_attribute_header_login_label_and_hero_composition_are_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('data-service-spotlight="true"', false);
        $response->assertSee('data-service-spotlight="false"', false);
        $response->assertSee('<span>Login</span>', false);
        $response->assertDontSee('<span>login</span>', false);
        $response->assertSee('Komposisi 755 layanan: 416 Website desa.id (55,1%), 239 Aplikasi OPD (31,7%), dan 100 Website bogorkab.go.id (13,2%)');
        $response->assertSee('id="portal-tab-admin"', false);
    }

    public function test_ssr_service_grid_balances_unpaired_cards_before_spotlight_and_styles_non_positive_domain_deltas(): void
    {
        $services = config('talas.layanan_utama');
        $regular = $services[0];
        $spotlight = $services[8];
        $secondRegular = $services[1];

        config(['talas.layanan_utama' => [$regular, $spotlight, $secondRegular]]);

        $domains = config('talas.spbe.domain_ringkas');
        $domains[1]['selisih'] = '-0,15';
        $domains[2]['selisih'] = '0,00';
        config(['talas.spbe.domain_ringkas' => $domains]);

        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();
        $this->assertIsString($html);

        $matchedCards = preg_match_all('/<article\b[^>]*data-service-card[^>]*>/', $html, $cardMatches);
        $this->assertSame(3, $matchedCards);
        $this->assertStringContainsString('md:col-span-2', $cardMatches[0][0]);
        $this->assertStringContainsString('md:col-span-2', $cardMatches[0][1]);
        $this->assertStringContainsString('md:col-span-2', $cardMatches[0][2]);

        $response->assertSee('text-[#991b1b]">-0,15', false);
        $response->assertSee('text-[#3f5249]">0,00', false);
    }

    public function test_all_rendered_lucide_icons_are_registered_in_frontend_bundle(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $html = $response->getContent();
        $this->assertIsString($html);

        preg_match_all('/data-lucide="([a-z0-9-]+)"/i', $html, $matches);
        $usedIcons = array_values(array_unique($matches[1]));
        $this->assertContains('clipboard-check', $usedIcons);
        $this->assertContains('shield', $usedIcons);

        $appJs = file_get_contents(resource_path('js/app.js'));
        $this->assertIsString($appJs);
        $this->assertSame(1, preg_match('/const\s+LUCIDE_ICONS\s*=\s*\{(.*?)\};/s', $appJs, $registryMatch));

        foreach ($usedIcons as $kebabName) {
            $pascalName = str_replace(' ', '', ucwords(str_replace('-', ' ', $kebabName)));
            $this->assertMatchesRegularExpression(
                '/\b'.preg_quote($pascalName, '/').'\b/',
                $registryMatch[1],
                "Ikon Lucide '{$kebabName}' ({$pascalName}) belum didaftarkan di LUCIDE_ICONS pada resources/js/app.js",
            );
        }
    }
}

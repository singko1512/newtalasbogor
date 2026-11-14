@extends('layouts.app')

@section('title', $meta['judul_brand'] . ' | ' . $meta['kepanjangan'])

@section('content')
    @include('partials.header', ['meta' => $meta])

    <main id="konten-utama">
        @include('partials.hero', [
            'meta' => $meta,
            'hero' => $hero,
            'heroSummary' => $heroSummary,
        ])
        @include('partials.layanan', [
            'layananUtama' => $layananUtama,
            'sopList' => $sopList,
            'serviceFilters' => $serviceFilters,
            'sopArchiveUrl' => $sopArchiveUrl,
            'loginUrl' => $meta['login_url'],
        ])
        @include('partials.direktori', [
            'meta' => $meta,
            'direktori' => $direktori,
            'direktoriSummary' => $direktoriSummary,
            'webCategories' => $webCategories,
            'hasActiveFilter' => $hasActiveFilter,
            'directoryDataset' => $directoryDataset,
            'activeTab' => $activeTab,
            'activeWebCategory' => $activeWebCategory,
            'searchQuery' => $searchQuery,
            'perPage' => $perPage,
        ])
        @include('partials.capaian', [
            'meta' => $meta,
            'spbe' => $spbe,
            'smartCity' => $smartCity,
            'ekosistem' => $ekosistem,
        ])
        @include('partials.akses-portal', [
            'meta' => $meta,
            'portalRoles' => $portalRoles,
        ])
    </main>

    @include('partials.footer', [
        'meta' => $meta,
    ])
    @include('partials.modals', [
        'meta' => $meta,
        'portalRoles' => $portalRoles,
        'sopArchiveUrl' => $sopArchiveUrl,
        'sopCount' => count($sopList),
    ])
@endsection

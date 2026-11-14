<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Talas Bogor - Portal Layanan dan Aplikasi Kabupaten Bogor')</title>
    <meta name="description" content="Portal layanan dan aplikasi Dinas Komunikasi dan Informatika Kabupaten Bogor: katalog 9 layanan digital, direktori 239 aplikasi OPD, 100 website bogorkab.go.id, 416 website desa.id, indeks SPBE, serta Smart City.">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pemkab-bogor.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-pemkab-bogor.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f6f5f0] text-[#10231b] antialiased selection:bg-[#1b4332] selection:text-white">
    <a href="#konten-utama"
       class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-[#1b4332] focus:px-4 focus:py-2.5 focus:text-sm focus:font-semibold focus:text-white focus:shadow-lg">
        Langsung ke konten utama
    </a>

    @yield('content')
</body>
</html>

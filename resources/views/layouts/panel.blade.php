<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Admin') | Seblak Nashwa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/tema.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
@php $pesananAktif = \App\Models\Pesanan::statusAktif()->count(); @endphp

<aside class="pn-side">
    @include('partials.panel-nav')
</aside>

<div class="pn-main">
    <header class="pn-top">
        <div class="d-flex align-items-center gap-3 px-3 px-lg-4 py-3">
            <button class="btn d-lg-none p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuPanel" aria-label="Buka menu">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="ms-auto d-flex align-items-center gap-3 small">
                <span class="text-muted d-none d-md-inline">{{ now()->locale('id')->translatedFormat('l, d F Y · H.i') }}</span>
                <a href="#" class="text-dark fs-5 js-segera" aria-label="Notifikasi"><i class="bi bi-bell"></i></a>
                <a href="{{ route('admin.pesanan.index') }}" class="nw-badge">{{ $pesananAktif }} pesanan aktif</a>
            </div>
        </div>
    </header>

    <main class="px-3 px-lg-4 py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h1 class="h2 fw-bold mb-1">@yield('heading', 'Panel Admin')</h1>
                <p class="text-muted mb-0">@yield('subheading')</p>
            </div>
            @yield('aksi')
        </div>

        @yield('content')
    </main>
</div>

{{-- Menu samping untuk layar kecil --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="menuPanel" aria-labelledby="menuPanelLabel">
    <div class="offcanvas-header">
        <span class="fw-bold" id="menuPanelLabel">Menu</span>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column pt-0">
        @include('partials.panel-nav')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('partials.swal')
@stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Seblak Nashwa') | Pedasnya pas, nagihnya jelas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/tema.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
@php
    $namaDepan = auth()->check() ? \Illuminate\Support\Str::of(auth()->user()->nama)->before(' ')->toString() : null;
    $jumlahKeranjang = auth()->check()
        ? (int) \App\Models\DetailKeranjang::whereHas('keranjang', fn ($q) => $q->where('id_user', auth()->id()))->sum('jumlah')
        : 0;
@endphp

<header class="nw-nav sticky-top">
    <div class="container d-flex align-items-center justify-content-between py-2">
        <a href="{{ route('home') }}" class="nw-brand" aria-label="Seblak Nashwa, ke beranda">
            <span class="nw-brand-ico"><i class="bi bi-cup-hot-fill"></i></span>
            <span>
                <strong>Seblak Nashwa</strong>
                <small>PEDASNYA PAS, NAGIHNYA JELAS.</small>
            </span>
        </a>

        {{-- Menu utama: tampil di layar lebar --}}
        <nav class="d-none d-lg-flex gap-4" aria-label="Navigasi utama">
            <a href="{{ route('home') }}" class="nw-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('katalog.index') }}" class="nw-link {{ request()->routeIs('katalog.*') ? 'active' : '' }}">Menu</a>
            <a href="{{ route('pesanan.riwayat') }}" class="nw-link {{ request()->routeIs('pesanan.*', 'keranjang.*', 'checkout.*') ? 'active' : '' }}">Pesanan</a>
        </nav>

        <div class="d-flex align-items-center gap-3">
            @auth
                <a href="{{ route('keranjang.index') }}" class="nw-cart" aria-label="Keranjang">
                    <i class="bi bi-bag"></i>
                    @if ($jumlahKeranjang > 0)<span class="nw-cart-n">{{ $jumlahKeranjang }}</span>@endif
                </a>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-dark fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="nw-avatar">{{ mb_strtoupper(mb_substr($namaDepan, 0, 1)) }}</span>
                        <span class="d-none d-sm-inline small">{{ $namaDepan }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('pesanan.riwayat') }}">Pesanan saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="small fw-bold d-none d-sm-inline">Masuk / Daftar</a>
                <a href="{{ route('katalog.index') }}" class="btn btn-primary btn-sm px-3">Pesan<span class="d-none d-sm-inline"> Sekarang</span></a>
            @endauth
        </div>
    </div>

    {{-- Menu utama: tampil di layar kecil (HP) sebagai tab --}}
    <nav class="nw-tabs d-lg-none" aria-label="Navigasi utama">
        <div class="container d-flex">
            <a href="{{ route('home') }}" class="nw-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('katalog.index') }}" class="nw-link {{ request()->routeIs('katalog.*') ? 'active' : '' }}">Menu</a>
            <a href="{{ route('pesanan.riwayat') }}" class="nw-link {{ request()->routeIs('pesanan.*', 'keranjang.*', 'checkout.*') ? 'active' : '' }}">Pesanan</a>
        </div>
    </nav>
</header>

<main class="flex-grow-1">
    @yield('content')
</main>

@hasSection('footer')
    @yield('footer')
@else
    <footer class="nw-foot mt-5 py-4">
        <div class="container d-flex flex-column flex-md-row justify-content-between gap-2 small text-muted">
            <span>© {{ date('Y') }} Seblak Nashwa · Dibuat hangat, disajikan sepenuh hati.</span>
            <span class="d-flex gap-4">
                <a href="#" class="text-muted js-segera">Bantuan pemesanan</a>
                <a href="#" class="text-muted js-segera">Kebijakan privasi</a>
                <a href="{{ route('admin.login') }}" class="text-muted">Masuk admin</a>
            </span>
        </div>
    </footer>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('partials.swal')
@stack('scripts')
</body>
</html>
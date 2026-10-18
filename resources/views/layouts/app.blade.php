<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seblak Nashwa') | Pedasnya pas, nagihnya jelas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/kedai.css') }}">
    @stack('styles')
</head>
<body>
@php
    // Tautan ke halaman anggota lain. Selama route-nya belum dibuat, tautan diarahkan ke tempat sementara.
    $tautMenu    = Route::has('katalog.index') ? route('katalog.index') : url('/') . '#menu';
    $tautPesanan = Route::has('pesanan.riwayat') ? route('pesanan.riwayat') : route('login');
    $namaDepan   = auth()->check() ? \Illuminate\Support\Str::of(auth()->user()->nama)->before(' ') : null;
@endphp

<header class="nav">
    <div class="wrap nav-in">
        <a href="{{ route('home') }}" class="brand" aria-label="Seblak Nashwa, ke beranda">
            <span class="brand-ico"><x-icon name="bowl" /></span>
            <span class="brand-txt">
                <strong>Seblak Nashwa</strong>
                <small>PEDASNYA PAS, NAGIHNYA JELAS.</small>
            </span>
        </a>

        <nav class="nav-links" aria-label="Navigasi utama">
            @hasSection('nav_links')
                @yield('nav_links')
            @else
                <a href="{{ $tautMenu }}">Menu</a>
                <a href="{{ url('/') }}#cara-pesan">Cara pesan</a>
                <a href="{{ url('/') }}#tentang">Tentang kedai</a>
                <a href="{{ url('/') }}#faq">FAQ</a>
            @endif
        </nav>

        <div class="nav-act">
            @hasSection('nav_action')
                @yield('nav_action')
            @else
                @auth
                    <span class="hai">Halo, {{ $namaDepan }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="link-btn">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="link-btn">Masuk / Daftar</a>
                @endauth
                <a href="{{ $tautMenu }}" class="btn btn-primary btn-sm">Pesan Sekarang <x-icon name="arrow-right" /></a>
            @endif
        </div>
    </div>
</header>

@if (session('status'))
    <div class="flash" role="status">
        <div class="wrap">{{ session('status') }}</div>
    </div>
@endif

<main>
    @yield('content')
</main>

@hasSection('footer')
    @yield('footer')
@else
    <footer class="foot">
        <div class="wrap foot-grid">
            <div class="foot-brand">
                <a href="{{ route('home') }}" class="brand">
                    <span class="brand-ico"><x-icon name="bowl" /></span>
                    <span class="brand-txt">
                        <strong>Seblak Nashwa</strong>
                        <small>PEDASNYA PAS, NAGIHNYA JELAS.</small>
                    </span>
                </a>
                <p>Dibuat hangat dari dapur rumahan.<br>Seblak dimasak saat kamu pesan.</p>
            </div>

            <div>
                <h4>Jelajahi</h4>
                <a href="{{ $tautMenu }}">Menu</a>
                <a href="{{ url('/') }}#cara-pesan">Cara pesan</a>
                <a href="{{ url('/') }}#tentang">Tentang kedai</a>
                <a href="{{ url('/') }}#faq">FAQ</a>
            </div>

            <div>
                <h4>Untuk kamu</h4>
                <a href="{{ $tautMenu }}">Pesan sekarang</a>
                <a href="{{ $tautPesanan }}">Pesanan saya</a>
                <a href="{{ route('login') }}">Masuk / Daftar</a>
            </div>

            <div>
                <h4>Jam layanan</h4>
                <p>Setiap hari<br><strong>10.00–21.00 WIB</strong></p>
            </div>
        </div>

        <div class="wrap foot-bottom">
            <span>© {{ date('Y') }} Seblak Nashwa. Pedasnya pas, nagihnya jelas.</span>
            <a href="{{ route('admin.login') }}">Masuk admin <x-icon name="arrow-up-right" /></a>
        </div>
    </footer>
@endif

@stack('scripts')
</body>
</html>

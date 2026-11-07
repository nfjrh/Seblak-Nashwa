@extends('layouts.pelanggan')

@section('title', 'Menu')

@section('content')
@php $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.'); @endphp
<div class="container py-4">

    {{-- Info kedai --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 small">
        <div class="d-flex align-items-center gap-2">
            <span class="nw-badge nw-badge-hijau">Buka sekarang</span>
            <span class="text-muted">Setiap hari · 10.00–21.00 WITA</span>
        </div>
        <span class="text-danger fw-semibold"><i class="bi bi-geo-alt-fill"></i> Ambil di outlet atau antar ke rumah</span>
    </div>

    {{-- Banner --}}
    <section class="nw-hero p-4 p-md-5 mb-4">
        <div class="row align-items-center">
            <div class="col-12 col-md-8">
                <div class="nw-eyebrow mb-2">Seblak hangat, hari jadi nikmat</div>
                <h1 class="display-5 fw-bold mb-3">Lagi Mau yang Pedas?<br>Seblak Nashwa aja.</h1>
                <p class="text-muted mb-3">Racik seblak sesukamu. Pilih level pedas, tambah topping favorit, lalu tunggu nikmatnya datang.</p>
                <div class="d-flex flex-wrap gap-3 small fw-semibold">
                    <span><i class="bi bi-check2 text-danger"></i> Dimasak saat dipesan</span>
                    <span><i class="bi bi-check2 text-danger"></i> Level pedas 0–5</span>
                    <span><i class="bi bi-check2 text-danger"></i> Mulai {{ $rp($menu->min('harga') ?? 0) }}</span>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4">
        {{-- Daftar menu --}}
        <div class="col-12 {{ auth()->check() ? 'col-lg-8' : '' }}">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                <h2 class="h3 mb-0">Mau seblak yang mana?</h2>
                <form action="{{ route('katalog.index') }}" method="GET" class="flex-grow-1 flex-md-grow-0" style="min-width:230px">
                    @if (request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari menu favoritmu...">
                    </div>
                </form>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('katalog.index', array_filter(['q' => request('q')])) }}" class="nw-chip {{ request('kategori') ? '' : 'active' }}">Semua menu</a>
                @foreach ($kategori as $k)
                    <a href="{{ route('katalog.index', array_filter(['kategori' => $k->id_kategori, 'q' => request('q')])) }}"
                       class="nw-chip {{ (string) request('kategori') === (string) $k->id_kategori ? 'active' : '' }}">{{ $k->nama_kategori }}</a>
                @endforeach
            </div>

            <div class="row row-cols-1 row-cols-sm-2 {{ auth()->check() ? 'row-cols-xl-2' : 'row-cols-lg-3' }} g-3">
                @forelse ($menu as $m)
                    <div class="col">
                        <a href="{{ route('katalog.show', $m->id_menu) }}" class="nw-card nw-menu position-relative">
                            <x-foto-menu :menu="$m" rasio="4x3" />
                            <span class="nw-badge nw-tag {{ $m->status === 'tersedia' ? '' : 'nw-badge-abu' }}">
                                {{ $m->status === 'tersedia' ? 'Pilihan favorit' : 'Habis' }}
                            </span>
                            <div class="p-3">
                                <div class="small text-uppercase fw-bold text-muted">{{ $m->kategori->nama_kategori ?? 'Menu' }}</div>
                                <h3 class="h5 mb-1">{{ $m->nama_menu }}</h3>
                                <p class="small text-muted mb-2">{{ $m->deskripsi }}</p>
                                <div class="nw-price fs-5">{{ $rp($m->harga) }}</div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="nw-card p-5 text-center text-muted">
                            <i class="bi bi-search fs-1"></i>
                            <p class="mt-2 mb-0">Menu yang kamu cari belum ada. Coba kata kunci lain.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Keranjang sementara (hanya untuk yang sudah masuk) --}}
        @auth
            <aside class="col-12 col-lg-4">
                <div class="nw-card p-3 p-md-4 sticky-lg-top" style="top:96px">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h2 class="h5 mb-0">Keranjangmu</h2>
                        <span class="nw-badge">{{ $keranjangItems->sum('jumlah') }} item</span>
                    </div>

                    @if ($keranjangItems->isEmpty())
                        <p class="text-muted small mt-3 mb-0">Keranjangmu masih kosong. Pilih menu dulu, ya.</p>
                    @else
                        <p class="text-muted small">Pilihan enakmu sudah terkumpul. Yuk, lanjut pesan!</p>
                        <hr>
                        @foreach ($keranjangItems as $item)
                            <div class="d-flex justify-content-between gap-2 mb-3">
                                <div>
                                    <div class="fw-bold small">{{ $item->menu->nama_menu }}</div>
                                    <div class="text-muted" style="font-size:.75rem">
                                        {{ $item->levelPedas->nama_level ?? '' }}@if ($item->toppings->isNotEmpty()) · {{ $item->toppings->pluck('nama_topping')->join(', ') }}@endif
                                    </div>
                                    <div class="nw-price small">{{ $rp($item->subtotal()) }}</div>
                                </div>
                                <span class="text-muted small">×{{ $item->jumlah }}</span>
                            </div>
                        @endforeach
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold">Subtotal</span>
                            <span class="nw-price fs-5">{{ $rp($keranjangTotal) }}</span>
                        </div>
                        <p class="text-muted" style="font-size:.72rem">Biaya layanan dan pengantaran dihitung saat pembayaran.</p>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 mb-2">Lanjut pembayaran</a>
                        <a href="{{ route('keranjang.index') }}" class="d-block text-center small fw-bold">Ubah pesanan</a>
                    @endif
                </div>
            </aside>
        @endauth
    </div>

    <div class="nw-card-soft p-3 mt-4 small text-muted">
        <i class="bi bi-fork-knife text-danger me-2"></i> Mau lebih rame? Tambahkan topping favoritmu saat memilih seblak.
    </div>
</div>

@endsection
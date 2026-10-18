@extends('layouts.app')
@section('title', $menu->nama_menu)

@push('styles')
<style>
    .detail { display: grid; grid-template-columns: 1fr 1fr; gap: 44px; align-items: start; }
    .detail-foto { border-radius: 22px; overflow: hidden; box-shadow: var(--shadow); aspect-ratio: 4 / 3; background: var(--soft); }
    .detail-foto img, .detail-foto .ph { width: 100%; height: 100%; object-fit: cover; display: flex; align-items: center; justify-content: center; font-size: 64px; }
    .detail h1 { font-size: 34px; margin: 8px 0; }
    .detail .harga { color: var(--brand); font-size: 26px; font-weight: 800; margin-bottom: 14px; }
    .detail .habis-info { background: #fff1d6; color: #8a5a00; padding: 12px 16px; border-radius: 10px; font-weight: 700; margin: 14px 0; }
    .detail .aksi { margin-top: 22px; }
    @media (max-width: 860px) { .detail { grid-template-columns: 1fr; gap: 24px; } }
</style>
@endpush

@section('content')
<section class="sec">
    <div class="wrap">
        <div class="detail">
            <div class="detail-foto">
                <x-foto :src="$menu->fotoUrl()" :alt="$menu->nama_menu" />
            </div>

            <div>
                @if ($menu->kategori)
                    <span class="pill">{{ $menu->kategori->nama_kategori }}</span>
                @endif
                <h1>{{ $menu->nama_menu }}</h1>
                <div class="harga">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                <p>{{ $menu->deskripsi }}</p>

                @if ($menu->status != 'tersedia')
                    <div class="habis-info">Menu ini sedang habis.</div>
                @endif

                {{-- Anggota 3: tambahkan pilihan topping dan level pedas di sini --}}

                <div class="aksi">
                    <a href="{{ route('katalog.index') }}" class="btn btn-ghost">Kembali ke daftar menu</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

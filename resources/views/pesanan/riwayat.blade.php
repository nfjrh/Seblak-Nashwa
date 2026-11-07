@extends('layouts.pelanggan')

@section('title', 'Pesanan Saya')

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $label = ['baru' => 'Diterima', 'diproses' => 'Disiapkan', 'siap' => 'Siap', 'selesai' => 'Selesai', 'batal' => 'Dibatalkan'];
    $kelas = ['selesai' => 'nw-badge-hijau', 'batal' => 'nw-badge-abu'];
@endphp
<div class="container py-4">
    <div class="nw-eyebrow mb-1">Pesanan saya</div>
    <h1 class="display-6 fw-bold mb-1">Riwayat pesananmu</h1>
    <p class="text-muted mb-4">Pantau pesanan yang sedang berjalan dan lihat pesanan sebelumnya.</p>

    @forelse ($pesanans as $p)
        <div class="nw-card p-3 p-md-4 mb-3">
            <div class="row align-items-center g-2">
                <div class="col-12 col-md-4">
                    <div class="fw-bold">#NSW-{{ str_pad($p->id_pesanan, 4, '0', STR_PAD_LEFT) }}</div>
                    {{-- Diubah dari WIB ke WITA --}}
                    <div class="small text-muted">{{ optional($p->tanggal_pesanan)->format('d M Y · H.i') }} WITA</div>
                </div>
                <div class="col-6 col-md-3 small text-muted">
                    {{ $p->detail_pesanans_count }} menu ·
                    {{ $p->metode_pengambilan === 'antar' ? 'Pengantaran' : 'Ambil sendiri' }}
                </div>
                <div class="col-6 col-md-2 nw-price text-md-end">{{ $rp($p->total_harga) }}</div>
                <div class="col-12 col-md-3 d-flex justify-content-between justify-content-md-end align-items-center gap-3">
                    <span class="nw-badge {{ $kelas[$p->status_pesanan] ?? '' }}">{{ $label[$p->status_pesanan] ?? ucfirst($p->status_pesanan) }}</span>
                    
                    {{-- Diubah menjadi tombol Bootstrap biasa --}}
                    <a href="{{ route('pesanan.detail', $p->id_pesanan) }}" class="btn btn-outline-danger btn-sm">
                        Lihat detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="nw-card p-5 text-center">
            <i class="bi bi-receipt fs-1 text-muted"></i>
            <h2 class="h5 mt-2">Belum ada pesanan</h2>
            <p class="text-muted">Pesanan pertamamu akan muncul di sini.</p>
            <a href="{{ route('katalog.index') }}" class="btn btn-primary">Mulai pesan</a>
        </div>
    @endforelse
</div>

@endsection
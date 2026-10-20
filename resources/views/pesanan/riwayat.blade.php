@extends('layouts.app')
@section('title', 'Pesanan Saya')

@push('styles')
    @include('pesanan._gaya')
@endpush

@section('content')
@php
    $rp = fn ($angka) => 'Rp' . number_format((float) $angka, 0, ',', '.');
    $labelStatus = ['baru' => 'Pesanan diterima', 'diproses' => 'Sedang dimasak', 'siap' => 'Siap', 'selesai' => 'Selesai', 'batal' => 'Dibatalkan'];
@endphp

<section class="ps-sec">
    <div class="wrap">
        <div class="ps-top">
            <div>
                <span class="ps-eyebrow">Riwayat</span>
                <h1 class="ps-h1">Pesanan saya</h1>
                <p class="ps-sub-t">Semua pesananmu beserta statusnya.</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="btn btn-primary btn-sm">Pesan lagi <x-icon name="arrow-right" /></a>
        </div>

        @if (session('status'))
            <div class="ps-alert ps-ok">{{ session('status') }}</div>
        @endif

        @forelse ($pesanans as $pesanan)
            <a href="{{ route('pesanan.detail', $pesanan->id_pesanan) }}" class="ps-order">
                <div>
                    <strong>Pesanan #{{ $pesanan->id_pesanan }}</strong>
                    <small>{{ optional($pesanan->tanggal_pesanan)->format('d M Y, H:i') }} · {{ $pesanan->detail_pesanans_count }} menu</small>
                </div>
                <div class="ps-badges">
                    <span class="ps-badge {{ $pesanan->status_pesanan }}">{{ $labelStatus[$pesanan->status_pesanan] ?? ucfirst($pesanan->status_pesanan) }}</span>
                    <span class="ps-badge {{ optional($pesanan->pembayaran)->status_pembayaran }}">Bayar: {{ ucfirst(optional($pesanan->pembayaran)->status_pembayaran ?? 'menunggu') }}</span>
                </div>
                <div class="ps-tot">{{ $rp($pesanan->total_harga) }}</div>
            </a>
        @empty
            <div class="ps-empty">
                <h2>Belum ada pesanan</h2>
                <p>Pesananmu akan muncul di sini setelah kamu checkout.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-primary">Lihat menu <x-icon name="arrow-right" /></a>
            </div>
        @endforelse
    </div>
</section>
@endsection

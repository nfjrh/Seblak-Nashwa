@extends('layouts.app')
@section('title', 'Pesanan #' . $pesanan->id_pesanan)

@push('styles')
    @include('pesanan._gaya')
@endpush

@section('content')
@php
    $rp = fn ($angka) => 'Rp' . number_format((float) $angka, 0, ',', '.');
    $langkah = [
        'baru'     => 'Pesanan diterima',
        'diproses' => 'Sedang dimasak',
        'siap'     => $pesanan->metode_pengambilan === 'antar' ? 'Siap diantar' : 'Siap diambil',
        'selesai'  => 'Selesai',
    ];
    $urutan  = array_keys($langkah);
    $posisi  = array_search($pesanan->status_pesanan, $urutan, true);
    $bayar   = optional($pesanan->pembayaran);
@endphp

<section class="ps-sec">
    <div class="wrap">
        <div class="ps-top">
            <div>
                <span class="ps-eyebrow">Status pesanan</span>
                <h1 class="ps-h1">Pesanan #{{ $pesanan->id_pesanan }}</h1>
                <p class="ps-sub-t">{{ optional($pesanan->tanggal_pesanan)->format('d M Y, H:i') }}</p>
            </div>
            <a href="{{ route('pesanan.riwayat') }}" class="btn btn-ghost btn-sm"><x-icon name="arrow-left" /> Semua pesanan</a>
        </div>

        @if (session('status'))
            <div class="ps-alert ps-ok">{{ session('status') }}</div>
        @endif

        <div class="ps-card" style="margin-bottom:24px">
            @if ($pesanan->status_pesanan === 'batal')
                <span class="ps-badge batal">Pesanan dibatalkan</span>
            @else
                <div class="ps-track">
                    @foreach ($langkah as $kode => $nama)
                        @php
                            $selesaiLangkah = $posisi !== false && $loop->index < $posisi;
                            $sekarang       = $posisi !== false && $loop->index === $posisi;
                        @endphp
                        <div class="ps-step {{ $selesaiLangkah || $sekarang ? 'done' : '' }} {{ $sekarang ? 'now' : '' }}">
                            <i></i>{{ $nama }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="ps-grid">
            <div class="ps-card">
                <h2>Rincian pesanan</h2>
                @foreach ($pesanan->detailPesanans as $detail)
                    <div class="ps-mini-item">
                        <span>
                            {{ $detail->jumlah }}× {{ $detail->menu->nama_menu ?? 'Menu' }}
                            <small>
                                {{ $detail->levelPedas->nama_level ?? '-' }}@if ($detail->toppings->isNotEmpty()) · {{ $detail->toppings->pluck('nama_topping')->join(', ') }}@endif
                            </small>
                        </span>
                        <strong>{{ $rp($detail->subtotal) }}</strong>
                    </div>
                @endforeach
                <div class="ps-line total"><span>Total</span><span>{{ $rp($pesanan->total_harga) }}</span></div>
            </div>

            <aside class="ps-card">
                <h2>Informasi</h2>
                <div class="ps-kv"><span>Penerimaan</span><span>{{ $pesanan->metode_pengambilan === 'antar' ? 'Pengantaran' : 'Ambil di kedai' }}</span></div>
                @if ($pesanan->alamat)
                    <div class="ps-kv"><span>Alamat</span><span>{{ $pesanan->alamat }}</span></div>
                @endif
                @if ($pesanan->catatan)
                    <div class="ps-kv"><span>Catatan</span><span>{{ $pesanan->catatan }}</span></div>
                @endif
                <div class="ps-kv"><span>Pembayaran</span><span>{{ $bayar->metode_pembayaran ?? '-' }}</span></div>
                <div class="ps-kv"><span>Status bayar</span><span><span class="ps-badge {{ $bayar->status_pembayaran }}">{{ ucfirst($bayar->status_pembayaran ?? 'menunggu') }}</span></span></div>
            </aside>
        </div>
    </div>
</section>
@endsection

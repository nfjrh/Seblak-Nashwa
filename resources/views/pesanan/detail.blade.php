@extends('layouts.pelanggan')

@section('title', 'Status Pesanan')

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $nomor = '#NSW-' . str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT);
    $status = $pesanan->status_pesanan;
    $batal = $status === 'batal';

    // Urutan perjalanan pesanan (status di database -> tampilan di desain)
    $langkah = [
        ['kunci' => 'baru',     'judul' => 'Diterima',               'ikon' => 'bi-check-lg',     'ket' => 'Pesanan masuk'],
        ['kunci' => 'diproses', 'judul' => 'Disiapkan',              'ikon' => 'bi-cup-hot',      'ket' => 'Sedang dimasak'],
        ['kunci' => 'siap',     'judul' => 'Siap diambil / dikirim', 'ikon' => 'bi-bicycle',      'ket' => 'Menunggu serah terima'],
        ['kunci' => 'selesai',  'judul' => 'Selesai',                'ikon' => 'bi-fork-knife',   'ket' => 'Selamat menikmati!'],
    ];
    $posisi = array_search($status, array_column($langkah, 'kunci'));
    $posisi = $posisi === false ? -1 : $posisi;

    $banner = [
        'baru'     => ['Pesananmu sudah kami terima', 'Kedai akan segera mengonfirmasi dan mulai memasak.'],
        'diproses' => ['Dapur lagi sibuk bikin yang enak.', 'Pesananmu sedang dimasak. Kami akan memperbarui status saat siap.'],
        'siap'     => ['Pesananmu sudah siap!', 'Silakan diambil, atau tunggu pengantar sampai di alamatmu.'],
        'selesai'  => ['Selamat menikmati!', 'Pesananmu sudah selesai. Terima kasih sudah memesan di Seblak Nashwa.'],
        'batal'    => ['Pesanan dibatalkan', 'Pesanan ini tidak diproses. Hubungi kedai bila ada pertanyaan.'],
    ][$status] ?? ['Status pesanan', 'Pantau pesananmu di sini.'];
    $pembayaran = $pesanan->pembayaran;
@endphp
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-4">
        <div>
            <div class="nw-eyebrow mb-1">Pesanan saya</div>
            <h1 class="display-6 fw-bold mb-1">{{ $banner[0] }}</h1>
            <p class="text-muted mb-0">{{ $banner[1] }}</p>
        </div>
        <div class="text-md-end">
            <div class="h4 fw-bold mb-0">{{ $nomor }}</div>
            <div class="small text-muted">{{ optional($pesanan->tanggal_pesanan)->format('d M Y · H.i') }} WIB</div>
        </div>
    </div>

    {{-- Perjalanan pesanan --}}
    <div class="nw-card p-3 p-md-4 mb-4">
        <h2 class="h5 mb-4">Perjalanan pesananmu</h2>
        @if ($batal)
            <div class="d-flex align-items-center gap-3">
                <span class="nw-tl-dot" style="background:#FDEBE6;color:#C63E2A"><i class="bi bi-x-lg"></i></span>
                <div><div class="fw-bold text-danger">Dibatalkan</div><div class="small text-muted">Pesanan ini tidak dilanjutkan.</div></div>
            </div>
        @else
            <div class="nw-timeline">
                @foreach ($langkah as $i => $l)
                    <div class="nw-tl-item {{ $i < $posisi ? 'done' : ($i === $posisi ? ($status === 'selesai' ? 'done' : 'now') : '') }}">
                        <span class="nw-tl-dot"><i class="bi {{ $i < $posisi || ($i === $posisi && $status === 'selesai') ? 'bi-check-lg' : $l['ikon'] }}"></i></span>
                        <div class="nw-tl-label mt-2">{{ $l['judul'] }}</div>
                        <div class="text-muted" style="font-size:.7rem">{{ $l['ket'] }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="row g-4">
        {{-- Rincian --}}
        <div class="col-12 col-lg-8">
            <div class="nw-card p-3 p-md-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h5 mb-0">Rincian pesanan</h2>
                    <span class="small text-muted">{{ $pesanan->detailPesanans->count() }} menu · {{ $pesanan->detailPesanans->sum('jumlah') }} item</span>
                </div>
                <hr>
                @foreach ($pesanan->detailPesanans as $d)
                    <div class="d-flex gap-3 align-items-center py-2">
                        <div style="width:56px;flex:none"><x-foto-menu :menu="$d->menu" rasio="1x1" class="rounded-3" /></div>
                        <div class="flex-grow-1">
                            <div class="fw-bold small">{{ $d->menu->nama_menu ?? 'Menu' }}</div>
                            <div class="text-muted" style="font-size:.75rem">
                                {{ $d->levelPedas->nama_level ?? '' }}@if ($d->toppings->isNotEmpty()) · {{ $d->toppings->pluck('nama_topping')->join(', ') }}@endif
                            </div>
                            <div class="nw-price small">{{ $rp($d->subtotal) }}</div>
                        </div>
                        <span class="text-muted small">×{{ $d->jumlah }}</span>
                    </div>
                @endforeach

                @if ($pesanan->catatan)
                    <div class="nw-card-soft p-3 small mt-2"><i class="bi bi-chat-left-text me-1"></i> Catatan: {{ $pesanan->catatan }}</div>
                @endif

                <hr>
                <div class="d-flex justify-content-between align-items-end">
                    <span class="fw-bold">Total</span>
                    <div class="text-end">
                        <div class="nw-price fs-4">{{ $rp($pesanan->total_harga) }}</div>
                        @if ($pembayaran)
                            <div class="small text-muted">{{ $pembayaran->metode_pembayaran }} · {{ ucfirst($pembayaran->status_pembayaran) }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Info pengambilan dan bantuan --}}
        <div class="col-12 col-lg-4">
            <div class="nw-card p-3 p-md-4 mb-3">
                @if ($pesanan->metode_pengambilan === 'antar')
                    <h2 class="h6 mb-2"><i class="bi bi-bicycle text-danger me-1"></i> Diantar ke alamatmu</h2>
                    <div class="small fw-bold">{{ auth()->user()->nama }}@if (auth()->user()->nomor_hp) · {{ auth()->user()->nomor_hp }}@endif</div>
                    <div class="small text-muted">{{ $pesanan->alamat }}</div>
                @else
                    <h2 class="h6 mb-2"><i class="bi bi-shop text-danger me-1"></i> Ambil di kedai</h2>
                    <div class="small text-muted">Tunjukkan nomor pesanan <strong>{{ $nomor }}</strong> saat mengambil.</div>
                @endif
            </div>

            <div class="nw-card p-3 p-md-4">
                <a href="#" class="btn btn-outline-dark w-100 mb-2 js-segera"><i class="bi bi-chat-dots me-1 text-danger"></i> Hubungi kedai</a>
                <a href="{{ route('katalog.index') }}" class="btn btn-primary w-100 mb-2">Kembali ke menu</a>
                <a href="{{ route('pesanan.riwayat') }}" class="d-block text-center small fw-bold">Semua pesananku</a>
            </div>
        </div>
    </div>
</div>

@endsection
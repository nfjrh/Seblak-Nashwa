@extends('layouts.panel')

@section('title', 'Pesanan ' . $pesanan->nomor_pesanan)
@section('heading', 'Pesanan #' . $pesanan->nomor_pesanan)
@section('subheading', 'Rincian pesanan, pembayaran, dan pembaruan status.')

@section('aksi')
    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-outline-dark"><i class="bi bi-arrow-left me-1"></i> Semua pesanan</a>
@endsection

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $label = ['baru' => 'Baru', 'diproses' => 'Disiapkan', 'siap' => 'Siap', 'selesai' => 'Selesai', 'batal' => 'Dibatalkan'];
    $tombol = ['diproses' => 'Terima dan mulai disiapkan', 'siap' => 'Tandai siap', 'selesai' => 'Selesaikan pesanan', 'batal' => 'Batalkan pesanan'];
    $pembayaran = $pesanan->pembayaran;
@endphp

<div class="row g-4">
    <div class="col-12 col-lg-8">
        {{-- Item --}}
        <div class="nw-card p-3 p-md-4 mb-4">
            <h2 class="h5 mb-3">Item pesanan</h2>
            @foreach ($pesanan->detailPesanans as $d)
                <div class="d-flex gap-3 align-items-center py-2 {{ ! $loop->last ? 'border-bottom' : '' }}">
                    <div style="width:56px;flex:none"><x-foto-menu :menu="$d->menu" rasio="1x1" class="rounded-3" /></div>
                    <div class="flex-grow-1">
                        <div class="fw-bold small">{{ $d->menu->nama_menu ?? 'Menu' }}</div>
                        @if ($d->levelPedas || $d->toppings->isNotEmpty())
                            <div class="text-muted" style="font-size:.75rem">{{ $d->levelPedas->nama_level ?? '' }}@if ($d->toppings->isNotEmpty()) · {{ $d->toppings->pluck('nama_topping')->join(', ') }}@endif</div>
                        @endif
                        @if ($d->catatan)
                            <div class="small fst-italic text-danger"><i class="bi bi-chat-left-text me-1"></i>Catatan: {{ $d->catatan }}</div>
                        @endif
                    </div>
                    <div class="text-end"><div class="nw-price small">{{ $rp($d->subtotal) }}</div><div class="text-muted" style="font-size:.75rem">×{{ $d->jumlah }}</div></div>
                </div>
            @endforeach

            @if ($pesanan->catatan)
                <div class="nw-card-soft p-3 small mt-3"><strong>Catatan pelanggan:</strong> {{ $pesanan->catatan }}</div>
            @endif

            <hr>
            <div class="d-flex justify-content-between small mb-1"><span class="text-muted">Subtotal menu</span><span>{{ $rp($pesanan->subtotal_menu) }}</span></div>
            <div class="d-flex justify-content-between small mb-1"><span class="text-muted">Biaya layanan</span><span>{{ $rp($pesanan->biaya_layanan) }}</span></div>
            <div class="d-flex justify-content-between small mb-1"><span class="text-muted">Ongkir</span><span>{{ $rp($pesanan->ongkir) }}</span></div>
            <hr>
            <div class="d-flex justify-content-between align-items-center"><strong>Total pembayaran</strong><span class="nw-price fs-4">{{ $pesanan->total_rupiah }}</span></div>
        </div>

        {{-- Pembayaran --}}
        <div class="nw-card p-3 p-md-4">
            <h2 class="h5 mb-3">Pembayaran</h2>
            @if ($pembayaran)
                <div class="row g-2 small mb-3">
                    <div class="col-6 col-md-4"><div class="text-muted">Metode</div><strong>{{ $pembayaran->metode_pembayaran }}</strong></div>
                    <div class="col-6 col-md-4"><div class="text-muted">Jumlah</div><strong>{{ $pembayaran->jumlah_rupiah }}</strong></div>
                    <div class="col-12 col-md-4"><div class="text-muted">Status</div><span class="st st-{{ $pembayaran->status_pembayaran }}">{{ ucfirst($pembayaran->status_pembayaran) }}</span></div>
                </div>
                @if ($pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_MENUNGGU)
                    <form action="{{ route('admin.pesanan.pembayaran', $pesanan->id_pesanan) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="keputusan" value="{{ \App\Models\Pembayaran::STATUS_LUNAS }}">
                        <button class="btn btn-primary btn-sm">Tandai lunas</button>
                    </form>
                    <form action="{{ route('admin.pesanan.pembayaran', $pesanan->id_pesanan) }}" method="POST" class="d-inline form-konfirmasi"
                          data-judul="Tolak pembayaran ini?" data-teks="Pembayaran akan ditandai ditolak." data-tombol="Ya, tolak">
                        @csrf @method('PATCH')
                        <input type="hidden" name="keputusan" value="{{ \App\Models\Pembayaran::STATUS_DITOLAK }}">
                        <button class="btn btn-outline-danger btn-sm">Tolak</button>
                    </form>
                @endif
            @else
                <p class="text-muted small mb-0">Belum ada data pembayaran.</p>
            @endif
        </div>
    </div>

    <div class="col-12 col-lg-4">
        <div class="nw-card p-3 p-md-4 mb-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div><div class="small text-muted">Detail pesanan</div><div class="h4 fw-bold mb-0">#{{ $pesanan->nomor_pesanan }}</div></div>
                <span class="st st-{{ $pesanan->status_pesanan }}">{{ $label[$pesanan->status_pesanan] ?? $pesanan->status_pesanan }}</span>
            </div>
            <div class="small text-muted mb-3">{{ optional($pesanan->tanggal_pesanan)->format('d M Y · H.i') }}</div>
            <div class="fw-bold">{{ $pesanan->nama_penerima ?? $pesanan->user->nama ?? '-' }}</div>
            <div class="small text-muted mb-2">{{ $pesanan->nomor_penerima ?? $pesanan->user->nomor_hp ?? '' }}</div>
            <div class="small"><i class="bi {{ $pesanan->metode_pengambilan === 'antar' ? 'bi-bicycle' : 'bi-shop' }} text-danger me-1"></i>
                {{ $pesanan->metode_pengambilan === 'antar' ? 'Pengantaran' : 'Ambil sendiri' }}</div>
            @if ($pesanan->alamat)
                <div class="small text-muted mt-1">{{ $pesanan->alamat }}@if ($pesanan->detail_alamat) <br>Detail: {{ $pesanan->detail_alamat }}@endif</div>
            @endif
        </div>

        <div class="nw-card p-3 p-md-4">
            <h2 class="h6 mb-3">Ubah status</h2>
            @forelse ($pilihanStatus as $s)
                <form action="{{ route('admin.pesanan.status', $pesanan->id_pesanan) }}" method="POST"
                      class="mb-2 {{ $s === 'batal' ? 'form-konfirmasi' : '' }}"
                      @if ($s === 'batal') data-judul="Batalkan pesanan ini?" data-teks="Pesanan yang dibatalkan tidak bisa diproses lagi." data-tombol="Ya, batalkan" @endif>
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="{{ $s }}">
                    <button class="btn {{ $s === 'batal' ? 'btn-outline-danger' : 'btn-primary' }} w-100">{{ $tombol[$s] ?? ucfirst($s) }}</button>
                </form>
            @empty
                <p class="small text-muted mb-0">Pesanan ini sudah final, status tidak bisa diubah lagi.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
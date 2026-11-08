@extends('layouts.pelanggan')

@section('title', 'Keranjang')

@section('content')
@php $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.'); @endphp
<div class="container py-4">
    <div class="nw-eyebrow mb-1">Tinggal selangkah lagi</div>
    <h1 class="display-6 fw-bold mb-1">Keranjangmu</h1>
    <p class="text-muted mb-4">Cek lagi pilihanmu sebelum lanjut ke pembayaran.</p>

    @if ($items->isEmpty())
        <div class="nw-card p-5 text-center">
            <i class="bi bi-bag fs-1 text-muted"></i>
            <h2 class="h5 mt-2">Keranjangmu masih kosong</h2>
            <p class="text-muted">Pilih seblak favoritmu dulu, ya.</p>
            <a href="{{ route('katalog.index') }}" class="btn btn-primary">Lihat menu</a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="nw-card p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h2 class="h5 mb-0">Pesananmu · {{ $items->sum('jumlah') }} item</h2>
                        <a href="{{ route('katalog.index') }}" class="fw-bold small">+ Tambah menu</a>
                    </div>
                    <hr>

                    @foreach ($items as $item)
                        <div class="d-flex gap-3 align-items-center py-2 {{ ! $loop->last ? 'border-bottom' : '' }}">
                            <div style="width:68px;flex:none"><x-foto-menu :menu="$item->menu" rasio="1x1" class="rounded-3" /></div>

                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $item->menu->nama_menu }}</div>
                                @if ($item->levelPedas || $item->toppings->isNotEmpty())
                                    <div class="text-muted small">
                                        {{ $item->levelPedas->nama_level ?? '' }}@if ($item->toppings->isNotEmpty()) · {{ $item->toppings->pluck('nama_topping')->join(', ') }}@endif
                                    </div>
                                @endif
                                @if ($item->catatan)
                                    <div class="small fst-italic text-muted"><i class="bi bi-chat-left-text me-1"></i>{{ $item->catatan }}</div>
                                @endif
                                <div class="nw-price small">{{ $rp($item->subtotal()) }}</div>
                            </div>

                            {{-- Ubah jumlah: tombol - dan + mengirim jumlah baru --}}
                            <div class="d-flex align-items-center gap-2">
                                <form action="{{ route('keranjang.ubah', $item->id_detail_keranjang) }}" method="POST" class="nw-qty">
                                    @csrf @method('PATCH')
                                    <button type="submit" name="jumlah" value="{{ $item->jumlah - 1 }}" {{ $item->jumlah <= 1 ? 'disabled' : '' }} aria-label="Kurangi">−</button>
                                    <span>{{ $item->jumlah }}</span>
                                    <button type="submit" name="jumlah" value="{{ $item->jumlah + 1 }}" {{ $item->jumlah >= 20 ? 'disabled' : '' }} aria-label="Tambah">+</button>
                                </form>

                                <form action="{{ route('keranjang.hapus', $item->id_detail_keranjang) }}" method="POST"
                                      class="form-konfirmasi" data-judul="Hapus dari keranjang?"
                                      data-teks="{{ $item->menu->nama_menu }} akan dihapus dari pesananmu." data-tombol="Ya, hapus">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-muted" aria-label="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="nw-card p-3 p-md-4 sticky-lg-top" style="top:96px">
                    <h2 class="h5 mb-3">Ringkasan</h2>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Subtotal ({{ $items->sum('jumlah') }} item)</span>
                        <strong>{{ $rp($total) }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Total</span>
                        <span class="nw-price fs-4">{{ $rp($total) }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">Lanjut ke pembayaran</a>
                    <p class="text-muted text-center mt-3 mb-0" style="font-size:.72rem">Biaya layanan dan pengantaran dihitung saat pembayaran.</p>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection
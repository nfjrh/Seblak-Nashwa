@extends('layouts.app')
@section('title', 'Keranjang')

@push('styles')
    @include('pesanan._gaya')
@endpush

@section('content')
@php $rp = fn ($angka) => 'Rp' . number_format((float) $angka, 0, ',', '.'); @endphp

<section class="ps-sec">
    <div class="wrap">
        <div class="ps-top">
            <div>
                <span class="ps-eyebrow">Keranjang</span>
                <h1 class="ps-h1">Keranjang pesananmu</h1>
                <p class="ps-sub-t">Periksa kembali pesananmu sebelum lanjut ke checkout.</p>
            </div>
            <a href="{{ route('katalog.index') }}" class="btn btn-ghost btn-sm">Tambah menu lain</a>
        </div>

        @if (session('status'))
            <div class="ps-alert ps-ok">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="ps-alert">@foreach ($errors->all() as $pesan) <div>{{ $pesan }}</div> @endforeach</div>
        @endif

        @if ($items->isEmpty())
            <div class="ps-empty">
                <h2>Keranjangmu masih kosong</h2>
                <p>Pilih seblak favoritmu, atur level pedas dan topping, lalu masukkan ke sini.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-primary">Lihat menu <x-icon name="arrow-right" /></a>
            </div>
        @else
            <div class="ps-grid">
                <div class="ps-card">
                    @foreach ($items as $item)
                        <div class="ps-item">
                            <div class="ps-thumb"><x-foto :src="$item->menu->fotoUrl()" :alt="$item->menu->nama_menu" /></div>

                            <div class="ps-info">
                                <strong>{{ $item->menu->nama_menu }}</strong>
                                <small>
                                    {{ $item->levelPedas->nama_level ?? '-' }}
                                    @if ($item->toppings->isNotEmpty())
                                        · {{ $item->toppings->pluck('nama_topping')->join(', ') }}
                                    @endif
                                </small>
                                <span class="ps-unit">{{ $rp($item->hargaSatuan()) }} / porsi</span>
                            </div>

                            <form action="{{ route('keranjang.ubah', $item->id_detail_keranjang) }}" method="POST" class="ps-qty">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="20" aria-label="Jumlah">
                                <button type="submit" class="ps-mini">Ubah</button>
                            </form>

                            <div class="ps-price">{{ $rp($item->subtotal()) }}</div>

                            <form action="{{ route('keranjang.hapus', $item->id_detail_keranjang) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ps-del" aria-label="Hapus {{ $item->menu->nama_menu }}">✕</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <aside class="ps-card ps-sum">
                    <h2>Ringkasan</h2>
                    <div class="ps-line"><span>{{ $items->sum('jumlah') }} porsi</span><span>{{ $rp($total) }}</span></div>
                    <div class="ps-line"><span>Biaya layanan dan antar</span><span>Dihitung saat bayar</span></div>
                    <div class="ps-line total"><span>Total</span><span>{{ $rp($total) }}</span></div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary ps-btn-full">Lanjut ke Checkout <x-icon name="arrow-right" /></a>
                </aside>
            </div>
        @endif
    </div>
</section>
@endsection

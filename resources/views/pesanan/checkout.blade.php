@extends('layouts.app')
@section('title', 'Checkout')

@push('styles')
    @include('pesanan._gaya')
@endpush

@section('content')
@php
    $rp = fn ($angka) => 'Rp' . number_format((float) $angka, 0, ',', '.');
    $pengambilan = old('metode_pengambilan', 'ambil');
    $bayar       = old('metode_pembayaran', 'transfer');
@endphp

<section class="ps-sec">
    <div class="wrap">
        <div class="ps-top">
            <div>
                <span class="ps-eyebrow">Checkout</span>
                <h1 class="ps-h1">Satu langkah lagi, ya.</h1>
                <p class="ps-sub-t">Pilih cara menerima pesanan dan metode pembayaran.</p>
            </div>
            <a href="{{ route('keranjang.index') }}" class="btn btn-ghost btn-sm"><x-icon name="arrow-left" /> Kembali ke keranjang</a>
        </div>

        @if ($errors->any())
            <div class="ps-alert">@foreach ($errors->all() as $pesan) <div>{{ $pesan }}</div> @endforeach</div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="ps-grid">
                <div>
                    <div class="ps-card">
                        <h2>Cara menerima pesanan</h2>
                        <div class="ps-choice">
                            <label>
                                <input type="radio" name="metode_pengambilan" value="ambil" {{ $pengambilan === 'ambil' ? 'checked' : '' }}>
                                <span>Ambil di kedai<small>Datang saat pesanan siap</small></span>
                            </label>
                            <label>
                                <input type="radio" name="metode_pengambilan" value="antar" {{ $pengambilan === 'antar' ? 'checked' : '' }}>
                                <span>Pengantaran<small>Diantar ke alamatmu</small></span>
                            </label>
                        </div>

                        <div class="ps-field" id="kotak-alamat" style="{{ $pengambilan === 'antar' ? '' : 'display:none' }}">
                            <label for="alamat">Alamat pengantaran</label>
                            <textarea id="alamat" name="alamat" rows="3" placeholder="Jalan, nomor rumah, patokan">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="ps-field">
                            <label for="catatan">Catatan untuk kedai (opsional)</label>
                            <textarea id="catatan" name="catatan" rows="2" placeholder="Contoh: kuah dipisah, tanpa sayur">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <div class="ps-card">
                        <h2>Metode pembayaran</h2>
                        <div class="ps-choice">
                            @foreach ($metodeBayar as $kode => $nama)
                                <label>
                                    <input type="radio" name="metode_pembayaran" value="{{ $kode }}" {{ $bayar === $kode ? 'checked' : '' }}>
                                    <span>{{ $nama }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <aside class="ps-card ps-sum">
                    <h2>Ringkasan pesanan</h2>
                    @foreach ($items as $item)
                        <div class="ps-mini-item">
                            <span>
                                {{ $item->jumlah }}× {{ $item->menu->nama_menu }}
                                <small>
                                    {{ $item->levelPedas->nama_level ?? '-' }}@if ($item->toppings->isNotEmpty()) · {{ $item->toppings->pluck('nama_topping')->join(', ') }}@endif
                                </small>
                            </span>
                            <strong>{{ $rp($item->subtotal()) }}</strong>
                        </div>
                    @endforeach
                    <div class="ps-line total"><span>Total</span><span>{{ $rp($total) }}</span></div>
                    <button type="submit" class="btn btn-primary ps-btn-full">Buat Pesanan <x-icon name="arrow-right" /></button>
                </aside>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function () {
        var radios = document.querySelectorAll('input[name="metode_pengambilan"]');
        var kotak = document.getElementById('kotak-alamat');
        radios.forEach(function (r) {
            r.addEventListener('change', function () {
                kotak.style.display = document.querySelector('input[name="metode_pengambilan"]:checked').value === 'antar' ? '' : 'none';
            });
        });
    })();
</script>
@endpush

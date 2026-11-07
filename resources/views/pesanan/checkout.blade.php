@extends('layouts.pelanggan')

@section('title', 'Pembayaran')

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $ikonBayar = ['transfer' => 'bi-bank', 'qris' => 'bi-qr-code', 'tunai' => 'bi-cash-coin'];
    $infoBayar = [
        'transfer' => 'Transfer ke rekening kedai',
        'qris'     => 'Pindai dari bank / dompet digital',
        'tunai'    => 'Bayar saat pesanan diterima',
    ];
    $pengambilan = old('metode_pengambilan', 'ambil');
@endphp
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <div class="nw-eyebrow mb-1">Tinggal selangkah lagi</div>
            <h1 class="display-6 fw-bold mb-1">Cek pesanan, lalu nikmati.</h1>
            <p class="text-muted mb-0">Pastikan pilihanmu sudah pas sebelum pesanan masuk ke dapur.</p>
        </div>
        <div class="nw-steps">
            <span class="nw-step on">1 Keranjang</span><i class="bi bi-chevron-right text-muted"></i>
            <span class="nw-step on">2 Pembayaran</span><i class="bi bi-chevron-right text-muted"></i>
            <span class="nw-step">3 Selesai</span>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger small">
            <strong>Ada yang perlu dilengkapi:</strong>
            <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-12 col-lg-8">

                {{-- Ringkasan item --}}
                <div class="nw-card p-3 p-md-4 mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h5 mb-0">Pesananmu · {{ $items->sum('jumlah') }} item</h2>
                        <a href="{{ route('keranjang.index') }}" class="fw-bold small">Ubah pesanan</a>
                    </div>
                    <hr>
                    @foreach ($items as $item)
                        <div class="d-flex gap-3 align-items-center py-2">
                            <div style="width:56px;flex:none"><x-foto-menu :menu="$item->menu" rasio="1x1" class="rounded-3" /></div>
                            <div class="flex-grow-1">
                                <div class="fw-bold small">{{ $item->menu->nama_menu }}</div>
                                <div class="text-muted" style="font-size:.75rem">
                                    {{ $item->levelPedas->nama_level ?? '' }}@if ($item->toppings->isNotEmpty()) · {{ $item->toppings->pluck('nama_topping')->join(', ') }}@endif
                                </div>
                                <div class="nw-price small">{{ $rp($item->subtotal()) }}</div>
                            </div>
                            <span class="text-muted small">×{{ $item->jumlah }}</span>
                        </div>
                    @endforeach
                </div>

                {{-- Cara menerima --}}
                <div class="nw-card p-3 p-md-4 mb-3">
                    <h2 class="h5 mb-3">Bagaimana kamu ingin menerima pesanan?</h2>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-sm-6">
                            <input type="radio" class="btn-check" name="metode_pengambilan" id="ambil" value="ambil" {{ $pengambilan === 'ambil' ? 'checked' : '' }}>
                            <label class="nw-opsi" for="ambil">
                                <div class="fw-bold"><i class="bi bi-shop me-1"></i> Ambil sendiri</div>
                                <div class="small text-muted">Tanpa ongkir · ambil di kedai</div>
                            </label>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="radio" class="btn-check" name="metode_pengambilan" id="antar" value="antar" {{ $pengambilan === 'antar' ? 'checked' : '' }}>
                            <label class="nw-opsi" for="antar">
                                <div class="fw-bold"><i class="bi bi-bicycle me-1"></i> Pengantaran</div>
                                <div class="small text-muted">Diantar ke alamatmu</div>
                            </label>
                        </div>
                    </div>

                    <div class="small text-muted mb-3">
                        Atas nama <strong class="text-dark">{{ auth()->user()->nama }}</strong>@if (auth()->user()->nomor_hp) · {{ auth()->user()->nomor_hp }}@endif
                    </div>

                    <div id="kotak-alamat" class="mb-3 {{ $pengambilan === 'antar' ? '' : 'd-none' }}">
                        <label for="alamat" class="form-label">Alamat pengantaran</label>
                        <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Contoh: Jl. Melati No. 12, RT 02/RW 04">{{ old('alamat') }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="catatan" class="form-label">Catatan untuk dapur <span class="text-muted fw-normal">(opsional)</span></label>
                        <textarea name="catatan" id="catatan" rows="2" maxlength="500" class="form-control"
                                  placeholder="Contoh: Kuah agak banyak ya, terima kasih.">{{ old('catatan') }}</textarea>
                    </div>
                </div>

                {{-- Pembayaran --}}
                <div class="nw-card p-3 p-md-4">
                    <h2 class="h5 mb-3">Pilih pembayaran</h2>
                    <div class="row g-2">
                        @foreach ($metodeBayar as $kode => $label)
                            <div class="col-12 col-sm-6 col-md-4">
                                <input type="radio" class="btn-check" name="metode_pembayaran" id="bayar-{{ $kode }}" value="{{ $kode }}"
                                       {{ old('metode_pembayaran', array_key_exists('qris', $metodeBayar) ? 'qris' : array_key_first($metodeBayar)) === $kode ? 'checked' : '' }}>
                                <label class="nw-opsi" for="bayar-{{ $kode }}">
                                    <div class="fw-bold"><i class="bi {{ $ikonBayar[$kode] ?? 'bi-wallet2' }} me-1"></i> {{ $label }}</div>
                                    <div class="small text-muted">{{ $infoBayar[$kode] ?? '' }}</div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Ringkasan pembayaran --}}
            <div class="col-12 col-lg-4">
                <div class="nw-card p-3 p-md-4 sticky-lg-top" style="top:96px">
                    <h2 class="h5 mb-3">Ringkasan pembayaran</h2>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Subtotal ({{ $items->sum('jumlah') }} item)</span>
                        <strong>{{ $rp($total) }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold">Total pembayaran</span>
                        <span class="nw-price fs-4">{{ $rp($total) }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">Buat pesanan · {{ $rp($total) }}</button>
                    <p class="text-muted text-center mt-3 mb-0" style="font-size:.72rem">
                        Dengan memesan, kamu menyetujui ketentuan pemesanan. Pesanan yang sudah dimasak tidak dapat dibatalkan.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Kotak alamat hanya muncul kalau memilih pengantaran
    document.querySelectorAll('input[name="metode_pengambilan"]').forEach(function (r) {
        r.addEventListener('change', function () {
            document.getElementById('kotak-alamat').classList.toggle('d-none', this.value !== 'antar');
        });
    });
</script>

@endpush
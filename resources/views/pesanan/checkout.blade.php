{{-- resources/views/pesanan/checkout.blade.php --}}

@extends('anggota2.layout')

@section('content')
    <div class="container my-4">
        <h2 class="mb-3">Checkout Pesanan</h2>
        <p class="text-muted">Periksa kembali rincian pesanan Anda sebelum melanjutkan.</p>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Ringkasan Pesanan</h5>

                {{-- Tabel Daftar Menu Dari Keranjang --}}
                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Menu</th>
                                <th>Topping</th>
                                <th>Level Pedas</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($keranjangItems as $item)
                                @php
                                    $hargaMenu = $item->menu->harga ?? 0;
                                    $hargaTopping = $item->topping->harga ?? 0;
                                    $hargaLevel = $item->levelPedas->harga ?? 0;
                                    $subtotal = ($hargaMenu + $hargaTopping + $hargaLevel) * $item->jumlah;
                                @endphp
                                <tr>
                                    <td>{{ $item->menu->nama_menu ?? 'Menu' }}</td>
                                    <td>{{ $item->topping->nama_topping ?? '-' }}</td>
                                    <td>{{ $item->levelPedas->nama_level ?? '-' }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Keranjang belanja Anda masih kosong.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Total Pembayaran --}}
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                    <span class="fw-bold">Total Pembayaran:</span>
                    <span class="fs-4 fw-bold text-success">
                        Rp{{ number_format($totalHarga, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Form Kirim Pesanan --}}
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label fw-semibold">Pilih Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="E-Wallet">E-Wallet (QRIS / GoPay / OVO)</option>
                            <option value="COD">Bayar di Tempat (COD)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" {{ $keranjangItems->isEmpty() ? 'disabled' : '' }}>
                        Konfirmasi Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
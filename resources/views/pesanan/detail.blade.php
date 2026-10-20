{{-- resources/views/pesanan/detail.blade.php --}}

@extends('anggota2.layout')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Detail Pesanan #{{ $pesanan->id }}</h2>
            <a href="{{ route('pesanan.riwayat') }}" class="btn btn-outline-secondary btn-sm">&laquo; Kembali ke Riwayat</a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <p class="mb-1"><strong>Tanggal Pesanan:</strong> {{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                <p class="mb-1">
                    <strong>Status Pesanan:</strong> 
                    <span class="badge bg-{{ $pesanan->status == 'selesai' ? 'success' : ($pesanan->status == 'batal' ? 'danger' : 'warning') }}">
                        {{ ucfirst($pesanan->status) }}
                    </span>
                </p>
                <p class="mb-0">
                    <strong>Metode Pembayaran:</strong> {{ $pesanan->pembayaran->metode_pembayaran ?? '-' }} 
                    (<span class="badge bg-{{ optional($pesanan->pembayaran)->status_pembayaran == 'lunas' ? 'success' : 'secondary' }}">
                        {{ ucfirst(optional($pesanan->pembayaran)->status_pembayaran ?? 'Belum Dibayar') }}
                    </span>)
                </p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">Rincian Menu</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
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
                            @foreach($pesanan->detailPesanan as $detail)
                                <tr>
                                    <td>{{ $detail->menu->nama_menu ?? '-' }}</td>
                                    <td>{{ $detail->topping->nama_topping ?? '-' }}</td>
                                    <td>{{ $detail->levelPedas->nama_level ?? '-' }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end align-items-center mt-3 pt-3 border-top">
                    <h5 class="mb-0 me-3">Total:</h5>
                    <h4 class="mb-0 text-success fw-bold">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
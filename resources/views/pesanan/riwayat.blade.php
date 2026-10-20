{{-- resources/views/pesanan/riwayat.blade.php --}}

@extends('anggota2.layout')

@section('content')
    <div class="container my-4">
        <h2 class="mb-3">Riwayat Pesanan Saya</h2>
        <p class="text-muted">Daftar pesanan dan status pembayaran Anda.</p>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#ID Pesanan</th>
                                <th>Total Harga</th>
                                <th>Status Pesanan</th>
                                <th>Status Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanans as $pesanan)
                                <tr>
                                    <td>#{{ $pesanan->getKey() }}</td>
                                    <td>Rp{{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pesanan->status == 'selesai' ? 'success' : ($pesanan->status == 'batal' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($pesanan->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ optional($pesanan->pembayaran)->status_pembayaran == 'lunas' ? 'success' : 'secondary' }}">
                                            {{ ucfirst(optional($pesanan->pembayaran)->status_pembayaran ?? 'Belum Dibayar') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pesanan.detail', $pesanan->getKey()) }}" class="btn btn-sm btn-info text-white">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada riwayat pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
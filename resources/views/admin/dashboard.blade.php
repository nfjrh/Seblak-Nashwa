@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('heading', 'Dashboard Admin')
@section('subheading', 'Selamat datang di panel pengelolaan Seblak Nashwa.')

@section('content')
    <section class="stats">
        <div class="stat-card">
            <div class="label">Total Pesanan</div>
            <h2>{{ $totalPesanan }}</h2>
            <small>Pesanan pelanggan</small>
        </div>

        <div class="stat-card">
            <div class="label">Total Menu</div>
            <h2>{{ $totalMenu }}</h2>
            <small>Menu yang tersedia</small>
        </div>

        <div class="stat-card">
            <div class="label">Total Kategori</div>
            <h2>{{ $totalKategori }}</h2>
            <small>Kategori menu</small>
        </div>
    </section>

    <section class="panel">
        <h2>Pesanan Terbaru</h2>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pesananTerbaru as $pesanan)
                    <tr>
                        <td>{{ $pesanan->id_pesanan }}</td>
                        <td>{{ $pesanan->user->nama ?? '-' }}</td>
                        <td>{{ $pesanan->tanggal_pesanan?->format('d M Y, H:i') }}</td>
                        <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        <td><span class="badge badge-{{ $pesanan->status_pesanan }}">{{ ucfirst($pesanan->status_pesanan) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty">Belum ada data pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
@extends('layouts.admin')
@section('title', 'Pesanan Masuk')
@section('heading', 'Pesanan Masuk')
@section('subheading', 'Pantau pesanan dan perbarui statusnya.')

@section('content')
<div class="panel">
    <div class="page-actions">
        <h2 style="margin:0">Daftar Pesanan</h2>
        <div>
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm {{ $status ? '' : 'btn-primary' }}">Semua</a>
            @foreach ($daftarStatus as $s)
                <a href="{{ route('admin.pesanan.index', ['status' => $s]) }}"
                   class="btn btn-sm {{ $status === $s ? 'btn-primary' : '' }}">{{ ucfirst($s) }}</a>
            @endforeach
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Pesanan</th><th>Pelanggan</th><th>Tanggal</th><th>Item</th>
                <th>Total</th><th>Pembayaran</th><th>Status</th><th style="width:90px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanans as $p)
                <tr>
                    <td>#{{ $p->id_pesanan }}</td>
                    <td>{{ $p->user->nama ?? '-' }}</td>
                    <td>{{ optional($p->tanggal_pesanan)->format('d M Y, H:i') }}</td>
                    <td>{{ $p->detail_pesanans_count }}</td>
                    <td>{{ $p->total_rupiah }}</td>
                    <td>{{ ucfirst($p->pembayaran->status_pembayaran ?? '-') }}</td>
                    <td><span class="badge badge-{{ $p->status_pesanan }}">{{ $p->label_status }}</span></td>
                    <td><a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}" class="btn btn-sm">Detail</a></td>
                </tr>
            @empty
                <tr><td colspan="8" class="empty">Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

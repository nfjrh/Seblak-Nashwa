@extends('layouts.admin')
@section('title', 'Pesanan #' . $pesanan->id_pesanan)
@section('heading', 'Pesanan #' . $pesanan->id_pesanan)
@section('subheading', 'Detail pesanan dan pembaruan status.')

@section('content')
@if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif
@if (session('galat'))
    <div class="alert alert-error">{{ session('galat') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-error">{{ $errors->first() }}</div>
@endif

<div class="panel">
    <div class="page-actions">
        <h2 style="margin:0">Ringkasan</h2>
        <a href="{{ route('admin.pesanan.index') }}" class="btn btn-sm">&larr; Semua pesanan</a>
    </div>
    <p>Pelanggan: <strong>{{ $pesanan->user->nama ?? '-' }}</strong> ({{ $pesanan->user->nomor_hp ?? '-' }})</p>
    <p>Tanggal: {{ optional($pesanan->tanggal_pesanan)->format('d M Y, H:i') }}</p>
    <p>Pengambilan: {{ ucfirst($pesanan->metode_pengambilan) }}</p>
    @if ($pesanan->alamat) <p>Alamat: {{ $pesanan->alamat }}</p> @endif
    @if ($pesanan->catatan) <p>Catatan: {{ $pesanan->catatan }}</p> @endif
    <p>Status: <span class="badge badge-{{ $pesanan->status_pesanan }}">{{ $pesanan->label_status }}</span></p>
    <p>Total: <strong>{{ $pesanan->total_rupiah }}</strong></p>
</div>

<div class="panel">
    <h2>Item pesanan</h2>
    <table>
        <thead><tr><th>Menu</th><th>Level</th><th>Topping</th><th>Jumlah</th><th>Subtotal</th></tr></thead>
        <tbody>
            @foreach ($pesanan->detailPesanans as $d)
                <tr>
                    <td>{{ $d->menu->nama_menu ?? '-' }}</td>
                    <td>{{ $d->levelPedas->nama_level ?? '-' }}</td>
                    <td>{{ $d->toppings->pluck('nama_topping')->join(', ') ?: '-' }}</td>
                    <td>{{ $d->jumlah }}</td>
                    <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="panel">
    <h2>Pembayaran</h2>
    @if ($pesanan->pembayaran)
        <p>Metode: {{ ucfirst($pesanan->pembayaran->metode_pembayaran) }}</p>
        <p>Jumlah: {{ $pesanan->pembayaran->jumlah_rupiah }}</p>
        <p>Status: <strong>{{ ucfirst($pesanan->pembayaran->status_pembayaran) }}</strong></p>

        @if ($pesanan->pembayaran->status_pembayaran === \App\Models\Pembayaran::STATUS_MENUNGGU)
            <form action="{{ route('admin.pesanan.pembayaran', $pesanan->id_pesanan) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <input type="hidden" name="keputusan" value="{{ \App\Models\Pembayaran::STATUS_LUNAS }}">
                <button class="btn btn-primary btn-sm">Tandai lunas</button>
            </form>
            <form action="{{ route('admin.pesanan.pembayaran', $pesanan->id_pesanan) }}" method="POST" style="display:inline">
                @csrf @method('PATCH')
                <input type="hidden" name="keputusan" value="{{ \App\Models\Pembayaran::STATUS_DITOLAK }}">
                <button class="btn btn-danger btn-sm">Tolak</button>
            </form>
        @endif
    @else
        <p>Belum ada data pembayaran.</p>
    @endif
</div>

<div class="panel">
    <h2>Ubah status pesanan</h2>
    @forelse ($pilihanStatus as $s)
        <form action="{{ route('admin.pesanan.status', $pesanan->id_pesanan) }}" method="POST" style="display:inline">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="{{ $s }}">
            <button class="btn btn-sm {{ $s === \App\Models\Pesanan::STATUS_BATAL ? 'btn-danger' : 'btn-primary' }}">{{ ucfirst($s) }}</button>
        </form>
    @empty
        <p>Pesanan ini sudah final, status tidak bisa diubah lagi.</p>
    @endforelse
</div>
@endsection

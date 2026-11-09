@extends('layouts.panel')

@section('title', 'Pesanan')
@section('heading', 'Pesanan')
@section('subheading', 'Pantau antrean, periksa rincian, dan proses pesanan pelanggan.')

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    // Tombol aksi berikutnya untuk tiap status: [status tujuan, tulisan tombol]
    $aksi = [
        'baru'     => ['diproses', 'Terima'],
        'diproses' => ['siap', 'Siap'],
        'siap'     => ['selesai', 'Selesaikan'],
    ];
    $label = ['baru' => 'Baru', 'diproses' => 'Disiapkan', 'siap' => 'Siap', 'selesai' => 'Selesai', 'batal' => 'Dibatalkan'];
@endphp

{{-- Kartu angka --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3"><div class="pn-stat"><i class="bi bi-receipt pn-stat-ico"></i><small>Pesanan hari ini</small><div class="pn-val">{{ $ringkasan['hariIni'] }}</div><small>{{ $ringkasan['selesaiHariIni'] }} selesai · {{ $ringkasan['hariIni'] - $ringkasan['selesaiHariIni'] }} lainnya</small></div></div>
    <div class="col-6 col-xl-3"><div class="pn-stat"><i class="bi bi-bell pn-stat-ico"></i><small>Pesanan baru</small><div class="pn-val">{{ $ringkasan['baru'] }}</div><small>Menunggu konfirmasi kedai</small></div></div>
    <div class="col-6 col-xl-3"><div class="pn-stat"><i class="bi bi-cup-hot pn-stat-ico"></i><small>Sedang disiapkan</small><div class="pn-val">{{ $ringkasan['diproses'] }}</div><small>Dalam antrean dapur</small></div></div>
    <div class="col-6 col-xl-3"><div class="pn-stat"><i class="bi bi-box-seam pn-stat-ico"></i><small>Siap diserahkan</small><div class="pn-val">{{ $ringkasan['siap'] }}</div><small>Ambil sendiri / pengantaran</small></div></div>
</div>

<div class="nw-card p-3 p-md-4 mb-4">
    <h2 class="h5 mb-3">Semua pesanan</h2>

    {{-- Pencarian dan tanggal --}}
    <form action="{{ route('admin.pesanan.index') }}" method="GET" class="row g-2 align-items-end mb-3">
        @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
        <div class="col-12 col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nomor atau pelanggan">
            </div>
        </div>
        <div class="col-6 col-md-3"><input type="date" name="dari" value="{{ request('dari') }}" class="form-control" aria-label="Dari tanggal"></div>
        <div class="col-6 col-md-3"><input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control" aria-label="Sampai tanggal"></div>
        <div class="col-12 col-md-2"><button class="btn btn-primary w-100">Terapkan</button></div>
    </form>

    {{-- Filter status --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="{{ route('admin.pesanan.index', request()->except('status', 'page')) }}" class="nw-chip {{ $status ? '' : 'active' }}">Semua ({{ $jumlahPerStatus->sum() }})</a>
        @foreach ($daftarStatus as $s)
            <a href="{{ route('admin.pesanan.index', array_merge(request()->except('page'), ['status' => $s])) }}"
               class="nw-chip {{ $status === $s ? 'active' : '' }}">{{ $label[$s] }} ({{ $jumlahPerStatus[$s] ?? 0 }})</a>
        @endforeach
    </div>

    <div class="table-responsive">
        <table class="table pn-table align-middle">
            <thead>
                <tr><th>Pesanan</th><th>Pelanggan</th><th>Layanan</th><th>Total</th><th>Pembayaran</th><th>Status</th><th class="text-end">Tindakan</th></tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $p)
                    <tr>
                        <td><div class="fw-bold">#{{ $p->nomor_pesanan }}</div><div class="small text-muted">{{ optional($p->tanggal_pesanan)->format('d M · H.i') }}</div></td>
                        <td><div class="fw-bold small">{{ $p->nama_penerima ?? $p->user->nama ?? '-' }}</div><div class="small text-muted">{{ $p->detail_pesanans_count }} menu</div></td>
                        <td class="small">{{ $p->metode_pengambilan === 'antar' ? 'Pengantaran' : 'Ambil sendiri' }}</td>
                        <td class="fw-bold">{{ $p->total_rupiah }}</td>
                        <td><span class="st st-{{ $p->pembayaran->status_pembayaran ?? 'menunggu' }}">{{ ucfirst($p->pembayaran->status_pembayaran ?? '-') }}</span></td>
                        <td><span class="st st-{{ $p->status_pesanan }}">{{ $label[$p->status_pesanan] ?? $p->status_pesanan }}</span></td>
                        <td class="text-end text-nowrap">
                            @if (isset($aksi[$p->status_pesanan]))
                                <form action="{{ route('admin.pesanan.status', $p->id_pesanan) }}" method="POST" class="d-inline">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $aksi[$p->status_pesanan][0] }}">
                                    <button class="btn btn-primary btn-sm">{{ $aksi[$p->status_pesanan][1] }}</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}" class="btn btn-outline-dark btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Belum ada pesanan yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($pesanans->hasPages())
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
            <small class="text-muted">Menampilkan {{ $pesanans->firstItem() }}–{{ $pesanans->lastItem() }} dari {{ $pesanans->total() }} pesanan</small>
            {{ $pesanans->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<div class="nw-card p-3 p-md-4">
    <h2 class="h5">Alur penanganan pesanan</h2>
    <p class="text-muted small">Bantu tim dapur menjaga setiap pesanan tetap terpantau.</p>
    <div class="row g-3">
        <div class="col-12 col-md-4 d-flex gap-3"><span class="nw-num">01</span><div><strong>Terima</strong><div class="small text-muted">Konfirmasi menu dan pembayaran.</div></div></div>
        <div class="col-12 col-md-4 d-flex gap-3"><span class="nw-num">02</span><div><strong>Siapkan</strong><div class="small text-muted">Racik sesuai level pedas dan catatan.</div></div></div>
        <div class="col-12 col-md-4 d-flex gap-3"><span class="nw-num">03</span><div><strong>Serahkan</strong><div class="small text-muted">Kirim atau serahkan, lalu selesaikan.</div></div></div>
    </div>
</div>
@endsection
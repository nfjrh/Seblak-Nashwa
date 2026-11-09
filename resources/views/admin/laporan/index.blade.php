@extends('layouts.panel')

@section('title', 'Laporan Penjualan')
@section('heading', 'Laporan Penjualan')
@section('subheading', 'Lihat performa menu dan rincian nilai pesanan pada periode yang dipilih.')

@section('aksi')
    <a href="#" class="btn btn-outline-dark js-segera"><i class="bi bi-download me-1"></i> Ekspor laporan</a>
@endsection

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $tertinggi = max($penjualanPerJam) ?: 1;
    $jamTertinggi = array_search(max($penjualanPerJam), $penjualanPerJam);
    $terlaris = $menuTerlaris->max('nilai') ?: 1;
    $label = ['baru' => 'Baru', 'diproses' => 'Diproses', 'siap' => 'Siap', 'selesai' => 'Selesai'];
@endphp

{{-- Rentang tanggal --}}
<form action="{{ route('admin.laporan.index') }}" method="GET" class="nw-card p-3 mb-4">
    <div class="row g-2 align-items-end">
        <div class="col-6 col-md-3">
            <label for="dari" class="form-label small mb-1">Dari tanggal</label>
            <input type="date" name="dari" id="dari" value="{{ $dari }}" class="form-control">
        </div>
        <div class="col-6 col-md-3">
            <label for="sampai" class="form-label small mb-1">Sampai tanggal</label>
            <input type="date" name="sampai" id="sampai" value="{{ $sampai }}" class="form-control @error('sampai') is-invalid @enderror">
            @error('sampai')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12 col-md-2"><button class="btn btn-primary w-100">Terapkan</button></div>
        <div class="col-12 col-md-4 small text-muted text-md-end">Pesanan yang dibatalkan tidak dihitung.</div>
    </div>
</form>

{{-- Kartu angka --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3"><div class="pn-stat"><i class="bi bi-wallet2 pn-stat-ico"></i><small>Penjualan menu + topping</small><div class="pn-val">{{ $rp($ringkasan['penjualan']) }}</div><small>Tidak termasuk ongkir dan biaya layanan</small></div></div>
    <div class="col-6 col-xl-3"><div class="pn-stat"><i class="bi bi-receipt pn-stat-ico"></i><small>Pesanan masuk</small><div class="pn-val">{{ $ringkasan['jumlah'] }}</div><small>{{ $ringkasan['selesai'] }} selesai · {{ $ringkasan['jumlah'] - $ringkasan['selesai'] }} masih aktif</small></div></div>
    <div class="col-6 col-xl-3"><div class="pn-stat"><i class="bi bi-graph-up-arrow pn-stat-ico"></i><small>Rata-rata nilai menu</small><div class="pn-val">{{ $rp($ringkasan['rataRata']) }}</div><small>Per transaksi</small></div></div>
    <div class="col-6 col-xl-3"><div class="pn-stat"><i class="bi bi-check2-circle pn-stat-ico"></i><small>Pesanan selesai</small><div class="pn-val">{{ $ringkasan['selesai'] }}</div><small>{{ $ringkasan['jumlah'] > 0 ? round($ringkasan['selesai'] / $ringkasan['jumlah'] * 100) : 0 }}% dari pesanan masuk</small></div></div>
</div>

<div class="row g-4 mb-4">
    {{-- Penjualan per jam --}}
    <div class="col-12 col-lg-8">
        <div class="nw-card p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">Penjualan per jam</h2>
                <span class="small text-muted">10.00–21.00</span>
            </div>
            <div class="pn-bars">
                @foreach ($penjualanPerJam as $jam => $nilai)
                    <div class="pn-bar-col">
                        @if ($nilai > 0)<div class="pn-bar-val">{{ $rp($nilai) }}</div>@endif
                        <div class="pn-bar {{ $nilai > 0 && $jam === $jamTertinggi ? 'top' : '' }}" style="height: {{ round($nilai / $tertinggi * 100) }}%"></div>
                        <div class="pn-bar-jam">{{ str_pad($jam, 2, '0', STR_PAD_LEFT) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Komposisi nilai --}}
    <div class="col-12 col-lg-4">
        <div class="nw-card p-3 p-md-4 h-100">
            <h2 class="h5">Komposisi nilai pesanan</h2>
            <p class="small text-muted">Pisahkan nilai menu dari biaya pengantaran.</p>
            <div class="nw-card-soft p-3 mb-3">
                <div class="small text-muted">Total tagihan {{ $ringkasan['jumlah'] }} pesanan</div>
                <div class="nw-price fs-4">{{ $rp($ringkasan['tagihan']) }}</div>
            </div>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Menu + topping</span><strong>{{ $rp($ringkasan['penjualan']) }}</strong></div>
            <div class="d-flex justify-content-between small mb-2"><span class="text-muted">Ongkir</span><strong>{{ $rp($ringkasan['ongkir']) }}</strong></div>
            <div class="d-flex justify-content-between small"><span class="text-muted">Biaya layanan</span><strong>{{ $rp($ringkasan['layanan']) }}</strong></div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Menu terlaris --}}
    <div class="col-12 col-lg-6">
        <div class="nw-card p-3 p-md-4 h-100">
            <h2 class="h5">Menu terlaris</h2>
            <p class="small text-muted">Diurutkan menurut nilai penjualan pada periode ini.</p>
            @forelse ($menuTerlaris as $r)
                <div class="mb-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <strong>{{ $r->menu->nama_menu ?? 'Menu dihapus' }}</strong>
                        <span>{{ $r->porsi }} porsi · {{ $rp($r->nilai) }}</span>
                    </div>
                    <div class="progress" style="height:8px"><div class="progress-bar" style="width: {{ round($r->nilai / $terlaris * 100) }}%; background: var(--nw-merah)"></div></div>
                </div>
            @empty
                <div class="text-muted small">Belum ada penjualan pada periode ini.</div>
            @endforelse
        </div>
    </div>

    {{-- Catatan --}}
    <div class="col-12 col-lg-6">
        <div class="nw-card p-3 p-md-4 h-100">
            <h2 class="h5">Catatan periode</h2>
            <p class="small text-muted">Cara membaca laporan hari ini.</p>
            <p class="small mb-2">Nilai penjualan dihitung dari harga menu dan topping. Ongkir dan biaya layanan dipisah karena bukan pendapatan menu.</p>
            <p class="small mb-0">Pesanan yang dibatalkan tidak dihitung sama sekali. Ubah rentang tanggal di bagian atas untuk melihat hari atau minggu lain.</p>
        </div>
    </div>
</div>

{{-- Rincian transaksi --}}
<div class="nw-card p-3 p-md-4">
    <h2 class="h5">Rincian transaksi</h2>
    <p class="small text-muted">{{ $rincian->count() }} pesanan terbaru pada periode ini.</p>
    <div class="table-responsive">
        <table class="table pn-table align-middle">
            <thead><tr><th>Pesanan</th><th>Pelanggan</th><th class="text-end">Menu + topping</th><th class="text-end">Ongkir</th><th class="text-end">Layanan</th><th class="text-end">Total</th><th>Status</th></tr></thead>
            <tbody>
                @forelse ($rincian as $p)
                    <tr>
                        <td><a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}" class="fw-bold">#{{ $p->nomor_pesanan }}</a><div class="small text-muted">{{ $p->tanggal_pesanan->format('d M H.i') }}</div></td>
                        <td>{{ $p->nama_penerima ?? ($p->user->nama ?? '-') }}</td>
                        <td class="text-end">{{ $rp($p->subtotal_menu) }}</td>
                        <td class="text-end">{{ $rp($p->ongkir) }}</td>
                        <td class="text-end">{{ $rp($p->biaya_layanan) }}</td>
                        <td class="text-end fw-bold">{{ $rp($p->total_harga) }}</td>
                        <td><span class="st st-{{ $p->status_pesanan }}">{{ $label[$p->status_pesanan] ?? ucfirst($p->status_pesanan) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada pesanan pada periode ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

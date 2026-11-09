@extends('layouts.panel')

@section('title', 'Ringkasan')
@section('heading', 'Selamat datang, ' . (auth()->user()->nama ?? 'Admin'))
@section('subheading', 'Yuk, cek pesanan dan pastikan dapur tetap lancar hari ini.')

@section('aksi')
    <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-dark"><i class="bi bi-calendar3 me-1 text-danger"></i> Hari ini</a>
@endsection

@section('content')
@php
    $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.');
    $tertinggi = max($penjualanPerJam) ?: 1;
    $jamTertinggi = array_search(max($penjualanPerJam), $penjualanPerJam);
@endphp

{{-- Kartu angka --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="pn-stat">
            <i class="bi bi-wallet2 pn-stat-ico"></i><small>Penjualan hari ini</small>
            <div class="pn-val">{{ $rp($penjualanHariIni) }}</div>
            <small>Total nilai menu terjual</small>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="pn-stat">
            <i class="bi bi-receipt pn-stat-ico"></i><small>Pesanan masuk</small>
            <div class="pn-val">{{ $pesananHariIni }}</div>
            <small>{{ $selesaiHariIni }} selesai · {{ $pesananHariIni - $selesaiHariIni }} masih aktif</small>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="pn-stat">
            <i class="bi bi-cup-hot pn-stat-ico"></i><small>Sedang disiapkan</small>
            <div class="pn-val">{{ $jumlahStatus['diproses'] ?? 0 }}</div>
            <small>{{ $jumlahStatus['baru'] ?? 0 }} baru · {{ $jumlahStatus['siap'] ?? 0 }} siap</small>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="pn-stat">
            <i class="bi bi-graph-up-arrow pn-stat-ico"></i><small>Rata-rata pesanan</small>
            <div class="pn-val">{{ $rp($rataRata) }}</div>
            <small>Nilai menu per transaksi</small>
        </div>
    </div>
</div>

{{-- Penjualan per jam --}}
<div class="nw-card p-3 p-md-4 mb-4">
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
    <hr>
    <p class="small text-muted mb-0">Total {{ $rp($penjualanHariIni) }} dari {{ $pesananHariIni }} pesanan. Tidak termasuk biaya layanan dan ongkir.</p>
</div>

<div class="row g-4">
    {{-- Menu dan topping --}}
    <div class="col-12 col-lg-6">
        <div class="nw-card p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h2 class="h5 mb-0">Menu &amp; topping</h2>
                    <div class="small text-muted">{{ $menuTersedia }} menu tersedia · {{ $jumlahTopping }} pilihan topping</div>
                </div>
                <a href="{{ route('menu.index') }}" class="fw-bold small">Kelola menu <i class="bi bi-arrow-up-right"></i></a>
            </div>
            @forelse ($menuUnggulan as $m)
                <div class="d-flex gap-3 align-items-center mb-3">
                    <div style="width:64px;flex:none"><x-foto-menu :menu="$m" rasio="1x1" class="rounded-3" /></div>
                    <div>
                        <div class="fw-bold">{{ $m->nama_menu }}</div>
                        <div class="small text-muted">{{ $rp($m->harga) }} · Menu tersedia</div>
                    </div>
                </div>
            @empty
                <p class="text-muted small">Belum ada menu.</p>
            @endforelse
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="fw-bold">{{ $daftarTopping->take(4)->join(' · ') ?: 'Belum ada topping' }}</div>
                    <div class="small text-muted">Cek stok sebelum jam ramai berikutnya.</div>
                </div>
                <a href="{{ route('admin.topping.index') }}" class="fw-bold small">Atur topping <i class="bi bi-arrow-up-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Pesanan terbaru --}}
    <div class="col-12 col-lg-6">
        <div class="nw-card p-3 p-md-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">Pesanan terbaru</h2>
                <a href="{{ route('admin.pesanan.index') }}" class="fw-bold small">Lihat semua <i class="bi bi-arrow-up-right"></i></a>
            </div>
            @forelse ($pesananTerbaru as $p)
                <a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}" class="d-flex justify-content-between align-items-center py-2 border-bottom text-reset">
                    <div>
                        <div class="fw-bold small">#{{ $p->nomor_pesanan }}</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $p->nama_penerima ?? $p->user->nama ?? '-' }} · {{ optional($p->tanggal_pesanan)->format('H.i') }}</div>
                    </div>
                    <div class="text-end">
                        <div class="small fw-bold">{{ $p->total_rupiah }}</div>
                        <span class="st st-{{ $p->status_pesanan }}">{{ $p->label_status }}</span>
                    </div>
                </a>
            @empty
                <p class="text-muted small mb-0">Belum ada pesanan.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
@extends('layouts.panel')

@section('title', 'Kelola Menu')
@section('heading', 'Kelola Menu')
@section('subheading', 'Atur hidangan, harga, dan ketersediaan di halaman pelanggan.')

@section('aksi')
    <a href="{{ route('menu.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah menu</a>
@endsection

@section('content')
@php $rp = fn ($v) => 'Rp' . number_format($v, 0, ',', '.'); @endphp

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4"><div class="pn-stat"><small>Menu aktif</small><div class="pn-val">{{ $ringkasan['aktif'] }}</div><small>Seluruh menu tersedia</small></div></div>
    <div class="col-6 col-md-4"><div class="pn-stat"><small>Varian seblak</small><div class="pn-val">{{ $ringkasan['seblak'] }}</div><small>Pilihan level pedas 0–5</small></div></div>
    <div class="col-6 col-md-4"><div class="pn-stat"><small>Minuman</small><div class="pn-val">{{ $ringkasan['minuman'] }}</div><small>Teman makan pedas</small></div></div>
</div>

<div class="nw-card p-3 p-md-4">
    <form action="{{ route('menu.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-12 col-md-5">
            <div class="input-group">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama menu">
            </div>
        </div>
        <div class="col-6 col-md-3">
            <select name="kategori" class="form-select">
                <option value="">Semua kategori</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id_kategori }}" {{ (string) request('kategori') === (string) $k->id_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-6 col-md-2">
            <select name="status" class="form-select">
                <option value="">Semua status</option>
                <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Habis</option>
            </select>
        </div>
        <div class="col-12 col-md-2"><button class="btn btn-outline-dark w-100">Terapkan</button></div>
    </form>

    <div class="d-grid gap-3">
        @forelse ($menu as $m)
            <div class="pn-menu-row">
                <x-foto-menu :menu="$m" rasio="1x1" />
                <div class="flex-grow-1">
                    <div class="small text-uppercase fw-bold text-muted">{{ $m->kategori->nama_kategori ?? 'Tanpa kategori' }}</div>
                    <div class="h5 mb-0">{{ $m->nama_menu }}</div>
                    <div class="small text-muted">{{ $m->deskripsi }}</div>
                    <div class="nw-price">{{ $rp($m->harga) }}</div>
                </div>
                <div class="d-flex align-items-center gap-3 ms-auto">
                    <span class="st st-{{ $m->status }}">{{ ucfirst($m->status) }}</span>

                    {{-- Saklar: mengubah tersedia atau habis --}}
                    <form action="{{ route('menu.status', $m->id_menu) }}" method="POST" class="form-check form-switch m-0 p-0 d-flex">
                        @csrf @method('PATCH')
                        <input class="form-check-input m-0" type="checkbox" role="switch" {{ $m->status === 'tersedia' ? 'checked' : '' }}
                               onchange="this.form.submit()" aria-label="Ubah ketersediaan {{ $m->nama_menu }}">
                    </form>

                    <a href="{{ route('menu.edit', $m->id_menu) }}" class="btn btn-outline-dark btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                    <form action="{{ route('menu.destroy', $m->id_menu) }}" method="POST" class="form-konfirmasi"
                          data-judul="Hapus menu ini?" data-teks="{{ $m->nama_menu }} akan dihapus permanen." data-tombol="Ya, hapus">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm" aria-label="Hapus"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">Belum ada menu yang cocok.</div>
        @endforelse
    </div>
</div>
@endsection
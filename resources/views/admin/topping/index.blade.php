@extends('layouts.panel')

@section('title', 'Kelola Topping')
@section('heading', 'Kelola Topping')
@section('subheading', 'Pastikan topping favorit selalu siap untuk setiap racikan seblak.')

@section('aksi')
    <a href="{{ route('admin.topping.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah topping</a>
@endsection

@section('content')
@php
    // Angka ringkasan dihitung dari seluruh topping, bukan hanya dari hasil filter
    $semua = \App\Models\Topping::all();
    $perluRestok = $semua->where('stok', '<=', \App\Models\Topping::STOK_MENIPIS);
@endphp

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4"><div class="pn-stat"><small>Pilihan topping</small><div class="pn-val">{{ $semua->count() }}</div><small>Tampil di halaman racik seblak</small></div></div>
    <div class="col-6 col-md-4"><div class="pn-stat"><small>Total stok</small><div class="pn-val">{{ $semua->sum('stok') }} porsi</div><small>Gabungan semua topping</small></div></div>
    <div class="col-6 col-md-4"><div class="pn-stat"><small>Perlu restok</small><div class="pn-val">{{ $perluRestok->count() }} topping</div><small>{{ $perluRestok->pluck('nama_topping')->take(3)->join(', ') ?: 'Semua stok aman' }}</small></div></div>
</div>

<div class="nw-card p-3 p-md-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Semua topping</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.topping.index') }}" class="nw-chip {{ request('stok') === 'menipis' ? '' : 'active' }}">Semua</a>
            <a href="{{ route('admin.topping.index', ['stok' => 'menipis']) }}" class="nw-chip {{ request('stok') === 'menipis' ? 'active' : '' }}">Stok menipis</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table pn-table align-middle">
            <thead><tr><th style="width:60px">No</th><th>Topping</th><th>Harga</th><th>Stok</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse ($toppings as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $t->nama_topping }}</td>
                        <td>{{ $t->harga_rupiah }}</td>
                        <td>{{ $t->stok }} porsi</td>
                        <td><span class="st st-{{ strtolower($t->status_stok) }}">{{ $t->status_stok }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.topping.edit', $t->id_topping) }}" class="btn btn-outline-dark btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="{{ route('admin.topping.destroy', $t->id_topping) }}" method="POST" class="d-inline form-konfirmasi"
                                  data-judul="Hapus topping ini?" data-teks="{{ $t->nama_topping }} akan dihapus." data-tombol="Ya, hapus">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" aria-label="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada topping yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
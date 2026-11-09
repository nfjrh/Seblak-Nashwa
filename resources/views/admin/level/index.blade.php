@extends('layouts.panel')

@section('title', 'Level Pedas')
@section('heading', 'Level Pedas')
@section('subheading', 'Atur pilihan level pedas dan tambahan harganya.')

@section('aksi')
    <a href="{{ route('admin.level.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah level</a>
@endsection

@section('content')
<div class="nw-card p-3 p-md-4">
    <div class="d-flex gap-2 mb-3">
        <a href="{{ route('admin.level.index') }}" class="nw-chip {{ request('urut') === 'harga' ? '' : 'active' }}">Urutan awal</a>
        <a href="{{ route('admin.level.index', ['urut' => 'harga']) }}" class="nw-chip {{ request('urut') === 'harga' ? 'active' : '' }}">Urut harga</a>
    </div>
    <div class="table-responsive">
        <table class="table pn-table align-middle">
            <thead><tr><th style="width:60px">No</th><th>Nama level</th><th>Tambahan harga</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse ($levels as $l)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $l->nama_level }}</td>
                        <td>{{ $l->tambahan_harga_rupiah }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.level.edit', $l->id_level) }}" class="btn btn-outline-dark btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="{{ route('admin.level.destroy', $l->id_level) }}" method="POST" class="d-inline form-konfirmasi"
                                  data-judul="Hapus level ini?" data-teks="{{ $l->nama_level }} akan dihapus." data-tombol="Ya, hapus">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" aria-label="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada level pedas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
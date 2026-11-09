@extends('layouts.panel')

@section('title', 'Kategori')
@section('heading', 'Kategori')
@section('subheading', 'Kelompokkan menu ke dalam kategori.')

@section('aksi')
    <a href="{{ route('kategori.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i> Tambah kategori</a>
@endsection

@section('content')
<div class="nw-card p-3 p-md-4">
    <div class="table-responsive">
        <table class="table pn-table align-middle">
            <thead><tr><th style="width:70px">No</th><th>Nama kategori</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
                @forelse ($kategori as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-bold">{{ $k->nama_kategori }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('kategori.edit', $k->id_kategori) }}" class="btn btn-outline-dark btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                            <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" class="d-inline form-konfirmasi"
                                  data-judul="Hapus kategori ini?" data-teks="{{ $k->nama_kategori }} akan dihapus." data-tombol="Ya, hapus">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" aria-label="Hapus"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
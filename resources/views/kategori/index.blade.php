@extends('anggota2.layout')
@section('title', 'Kategori')
 
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Daftar Kategori</h3>
    <a href="{{ route('kategori.create') }}" class="btn btn-danger">+ Tambah Kategori</a>
</div>
 
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="width:60px">No</th>
            <th>Nama Kategori</th>
            <th style="width:180px">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($kategori as $k)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $k->nama_kategori }}</td>
                <td>
                    <a href="{{ route('kategori.edit', $k->id_kategori) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center">Belum ada kategori.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
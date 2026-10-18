@extends('layouts.admin')
@section('title', 'Kategori')
@section('heading', 'Kategori')
@section('subheading', 'Kelompokkan menu ke dalam kategori.')

@section('content')
<div class="panel">
    <div class="page-actions">
        <h2 style="margin:0">Daftar Kategori</h2>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
    </div>

    <table>
        <thead>
            <tr><th style="width:60px">No</th><th>Nama Kategori</th><th style="width:170px">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse ($kategori as $k)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $k->nama_kategori }}</td>
                    <td>
                        <a href="{{ route('kategori.edit', $k->id_kategori) }}" class="btn btn-sm">Edit</a>
                        <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="empty">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

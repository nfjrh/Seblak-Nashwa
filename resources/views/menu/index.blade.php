@extends('anggota2.layout')
@section('title', 'Menu')
 
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>Daftar Menu</h3>
    <a href="{{ route('menu.create') }}" class="btn btn-danger">+ Tambah Menu</a>
</div>
 
<table class="table table-bordered align-middle">
    <thead>
        <tr>
            <th style="width:60px">No</th>
            <th style="width:100px">Gambar</th>
            <th>Nama Menu</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Status</th>
            <th style="width:180px">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($menu as $m)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if ($m->gambar)
                        <img src="{{ asset('storage/' . $m->gambar) }}" width="80" class="rounded">
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>{{ $m->nama_menu }}</td>
                <td>{{ $m->kategori->nama_kategori ?? '-' }}</td>
                <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                <td>
                    @if ($m->status == 'tersedia')
                        <span class="badge bg-success">Tersedia</span>
                    @else
                        <span class="badge bg-secondary">Habis</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('menu.edit', $m->id_menu) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('menu.destroy', $m->id_menu) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus menu ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center">Belum ada menu.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
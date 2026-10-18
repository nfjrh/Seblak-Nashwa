@extends('layouts.admin')
@section('title', 'Menu Seblak')
@section('heading', 'Menu Seblak')
@section('subheading', 'Kelola menu yang dijual di kedai.')

@section('content')
<div class="panel">
    <div class="page-actions">
        <h2 style="margin:0">Daftar Menu</h2>
        <a href="{{ route('menu.create') }}" class="btn btn-primary">+ Tambah Menu</a>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th style="width:90px">Gambar</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
                <th style="width:170px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($menu as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($m->fotoUrl())
                            <img src="{{ $m->fotoUrl() }}" alt="{{ $m->nama_menu }}" style="width:70px;height:52px;object-fit:cover;border-radius:8px">
                        @else
                            <span style="color:#88756a">-</span>
                        @endif
                    </td>
                    <td>{{ $m->nama_menu }}</td>
                    <td>{{ $m->kategori->nama_kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($m->harga, 0, ',', '.') }}</td>
                    <td>
                        @if ($m->status == 'tersedia')
                            <span class="badge badge-siap">Tersedia</span>
                        @else
                            <span class="badge badge-selesai">Habis</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('menu.edit', $m->id_menu) }}" class="btn btn-sm">Edit</a>
                        <form action="{{ route('menu.destroy', $m->id_menu) }}" method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus menu ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">Belum ada menu.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

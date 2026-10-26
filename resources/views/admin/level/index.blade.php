@extends('layouts.admin')
@section('title', 'Level Pedas')
@section('heading', 'Level Pedas')
@section('subheading', 'Kelola pilihan tingkat kepedasan.')

@section('content')
<div class="panel">
    <div class="page-actions">
        <h2 style="margin:0">Daftar Level Pedas</h2>
        <a href="{{ route('admin.level.create') }}" class="btn btn-primary">+ Tambah Level</a>
    </div>

    <table>
        <thead>
            <tr><th style="width:60px">No</th><th>Nama Level</th><th>Tambahan Harga</th><th style="width:170px">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse ($levels as $l)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $l->nama_level }}</td>
                    <td>{{ $l->tambahan_harga > 0 ? '+ Rp ' . number_format($l->tambahan_harga, 0, ',', '.') : 'Gratis' }}</td>
                    <td>
                        <a href="{{ route('admin.level.edit', $l->id_level) }}" class="btn btn-sm">Edit</a>
                        <form action="{{ route('admin.level.destroy', $l->id_level) }}" method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus level ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty">Belum ada level pedas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

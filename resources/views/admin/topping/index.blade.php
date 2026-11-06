@extends('layouts.admin')
@section('title', 'Topping')
@section('heading', 'Topping')
@section('subheading', 'Kelola topping tambahan untuk seblak.')

@section('content')
<div class="panel">
    <div class="page-actions">
        <h2 style="margin:0">Daftar Topping</h2>
        <a href="{{ route('admin.topping.create') }}" class="btn btn-primary">+ Tambah Topping</a>
    </div>

    <table>
        <thead>
            <tr><th style="width:60px">No</th><th>Nama</th><th>Harga</th><th>Stok</th><th style="width:170px">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse ($toppings as $t)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t->nama_topping }}</td>
                    <td>Rp {{ number_format($t->harga, 0, ',', '.') }}</td>
                    <td>{{ $t->stok }}</td>
                    <td>
                        <a href="{{ route('admin.topping.edit', $t->id_topping) }}" class="btn btn-sm">Edit</a>
                        <form action="{{ route('admin.topping.destroy', $t->id_topping) }}" method="POST" style="display:inline"
                              onsubmit="return confirm('Hapus topping ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">Belum ada topping.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

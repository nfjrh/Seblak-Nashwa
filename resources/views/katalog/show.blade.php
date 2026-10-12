@extends('anggota2.layout')
@section('title', $menu->nama_menu)
 
@section('content')
<div class="row">
    <div class="col-md-5">
        @if ($menu->gambar)
            <img src="{{ asset('storage/' . $menu->gambar) }}" class="img-fluid rounded">
        @endif
    </div>
    <div class="col-md-7">
        <h2>{{ $menu->nama_menu }}</h2>
        <h4 class="text-danger">Rp {{ number_format($menu->harga, 0, ',', '.') }}</h4>
        <p>{{ $menu->deskripsi }}</p>
 
        @if ($menu->status != 'tersedia')
            <div class="alert alert-warning">Menu ini sedang habis.</div>
        @endif
 
        {{-- Anggota 3: tambahkan pilihan topping dan level pedas di sini --}}
 
        <a href="{{ route('katalog.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
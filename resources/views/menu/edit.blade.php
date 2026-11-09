@extends('layouts.panel')

@section('title', 'Ubah Menu')
@section('heading', 'Ubah Menu')
@section('subheading', 'Perubahan baru tampil di halaman pelanggan setelah disimpan.')

@section('content')
<div class="nw-card p-3 p-md-4">
    <form action="{{ route('menu.update', $menu->id_menu) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('menu._form')
    </form>
</div>
@endsection

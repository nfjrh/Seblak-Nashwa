@extends('anggota2.layout')
@section('title', 'Tambah Kategori')
 
@section('content')
<h3>Tambah Kategori</h3>
<form action="{{ route('kategori.store') }}" method="POST">
    @csrf
    @include('kategori._form')
</form>
@endsection
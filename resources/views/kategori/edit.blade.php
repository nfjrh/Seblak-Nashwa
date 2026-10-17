@extends('anggota2.layout')
@section('title', 'Edit Kategori')
 
@section('content')
<h3>Edit Kategori</h3>
<form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
    @csrf
    @method('PUT')
    @include('kategori._form')
</form>
@endsection
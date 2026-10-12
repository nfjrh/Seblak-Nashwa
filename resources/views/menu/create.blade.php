@extends('anggota2.layout')
@section('title', 'Tambah Menu')
 
@section('content')
<h3>Tambah Menu</h3>
<form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('menu._form')
</form>
@endsection
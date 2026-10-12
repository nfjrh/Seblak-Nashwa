@extends('anggota2.layout')
@section('title', 'Edit Menu')
 
@section('content')
<h3>Edit Menu</h3>
<form action="{{ route('menu.update', $menu->id_menu) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('menu._form')
</form>
@endsection
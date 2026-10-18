@extends('layouts.admin')
@section('title', 'Edit Menu')
@section('heading', 'Edit Menu')
@section('subheading', 'Ubah data menu.')

@section('content')
<div class="panel" style="max-width:640px">
    <form action="{{ route('menu.update', $menu->id_menu) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('menu._form')
    </form>
</div>
@endsection

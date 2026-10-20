@extends('layouts.admin')
@section('title', 'Tambah Menu')
@section('heading', 'Tambah Menu')
@section('subheading', 'Isi data menu baru.')

@section('content')
<div class="panel" style="max-width:640px">
    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('menu._form')
    </form>
</div>
@endsection

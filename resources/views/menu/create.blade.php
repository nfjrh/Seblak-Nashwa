@extends('layouts.panel')

@section('title', 'Tambah Menu')
@section('heading', 'Tambah Menu')
@section('subheading', 'Isi data menu baru.')

@section('content')
<div class="nw-card p-3 p-md-4">
    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('menu._form')
    </form>
</div>
@endsection

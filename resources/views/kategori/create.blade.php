@extends('layouts.admin')
@section('title', 'Tambah Kategori')
@section('heading', 'Tambah Kategori')
@section('subheading', 'Isi nama kategori baru.')

@section('content')
<div class="panel" style="max-width:560px">
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        @include('kategori._form')
    </form>
</div>
@endsection

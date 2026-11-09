@extends('layouts.panel')

@section('title', 'Tambah Kategori')
@section('heading', 'Tambah Kategori')
@section('subheading', 'Isi nama kategori baru.')

@section('content')
<div class="nw-card p-3 p-md-4" style="max-width:560px">
    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        
        @include('kategori._form')
    </form>
</div>
@endsection

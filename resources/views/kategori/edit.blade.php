@extends('layouts.panel')

@section('title', 'Ubah Kategori')
@section('heading', 'Ubah Kategori')
@section('subheading', 'Perbarui nama kategori.')

@section('content')
<div class="nw-card p-3 p-md-4" style="max-width:560px">
    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
        @csrf
        @method('PUT')
        @include('kategori._form')
    </form>
</div>
@endsection

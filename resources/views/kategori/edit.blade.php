@extends('layouts.admin')
@section('title', 'Edit Kategori')
@section('heading', 'Edit Kategori')
@section('subheading', 'Ubah nama kategori.')

@section('content')
<div class="panel" style="max-width:560px">
    <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
        @csrf
        @method('PUT')
        @include('kategori._form')
    </form>
</div>
@endsection

@extends('layouts.panel')

@section('title', 'Tambah Level Pedas')
@section('heading', 'Tambah Level Pedas')
@section('subheading', 'Isi data level baru.')

@section('content')
<div class="nw-card p-3 p-md-4" style="max-width:640px">
    <form action="{{ route('admin.level.store') }}" method="POST">
        @csrf
        @include('admin.level._form')
    </form>
</div>
@endsection
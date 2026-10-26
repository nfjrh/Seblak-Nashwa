@extends('layouts.admin')
@section('title', 'Tambah Level Pedas')
@section('heading', 'Tambah Level Pedas')
@section('subheading', 'Isi data level baru.')

@section('content')
<div class="panel" style="max-width:560px">
    <form action="{{ route('admin.level.store') }}" method="POST">
        @csrf
        @include('admin.level._form')
    </form>
</div>
@endsection

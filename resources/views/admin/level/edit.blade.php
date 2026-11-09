@extends('layouts.panel')

@section('title', 'Ubah Level Pedas')
@section('heading', 'Ubah Level Pedas')
@section('subheading', 'Perbarui data level.')

@section('content')
<div class="nw-card p-3 p-md-4" style="max-width:640px">
    <form action="{{ route('admin.level.update', $level->id_level) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.level._form')
    </form>
</div>
@endsection
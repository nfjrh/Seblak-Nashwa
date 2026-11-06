@extends('layouts.admin')
@section('title', 'Edit Level Pedas')
@section('heading', 'Edit Level Pedas')
@section('subheading', 'Ubah data level.')

@section('content')
<div class="panel" style="max-width:560px">
    <form action="{{ route('admin.level.update', $level->id_level) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.level._form')
    </form>
</div>
@endsection

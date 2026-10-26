@extends('layouts.admin')
@section('title', 'Tambah Topping')
@section('heading', 'Tambah Topping')
@section('subheading', 'Isi data topping baru.')

@section('content')
<div class="panel" style="max-width:560px">
    <form action="{{ route('admin.topping.store') }}" method="POST">
        @csrf
        @include('admin.topping._form')
    </form>
</div>
@endsection

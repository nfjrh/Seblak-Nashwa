@extends('layouts.panel')

@section('title', 'Tambah Topping')
@section('heading', 'Tambah Topping')
@section('subheading', 'Isi data topping baru.')

@section('content')
<div class="nw-card p-3 p-md-4" style="max-width:640px">
    <form action="{{ route('admin.topping.store') }}" method="POST">
        @csrf
        @include('admin.topping._form')
    </form>
</div>
@endsection
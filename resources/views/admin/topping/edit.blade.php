@extends('layouts.panel')

@section('title', 'Ubah Topping')
@section('heading', 'Ubah Topping')
@section('subheading', 'Perbarui harga dan stok topping.')

@section('content')
<div class="nw-card p-3 p-md-4" style="max-width:640px">
    <form action="{{ route('admin.topping.update', $topping->id_topping) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.topping._form')
    </form>
</div>
@endsection
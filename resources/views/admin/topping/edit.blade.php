@extends('layouts.admin')
@section('title', 'Edit Topping')
@section('heading', 'Edit Topping')
@section('subheading', 'Ubah data topping.')

@section('content')
<div class="panel" style="max-width:560px">
    <form action="{{ route('admin.topping.update', $topping->id_topping) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.topping._form')
    </form>
</div>
@endsection

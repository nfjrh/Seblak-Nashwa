<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KatalogController;

Route::get('/', function () {
    return view('welcome');
});

// ===== Anggota 2: Kategori, Menu, Katalog =====
Route::resource('kategori', KategoriController::class)->except('show');
Route::resource('menu', MenuController::class)->except('show');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{menu}', [KatalogController::class, 'show'])->name('katalog.show');
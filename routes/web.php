<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananController;

Route::get('/', function () {
    return view('welcome');
});

// ===== Anggota 2: Kategori, Menu, Katalog =====
Route::resource('kategori', KategoriController::class)->except('show');
Route::resource('menu', MenuController::class)->except('show');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{menu}', [KatalogController::class, 'show'])->name('katalog.show'); 

// ===== Anggota 5: Checkout & Pesanan =====
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/pesanan/riwayat', [PesananController::class, 'riwayat'])->name('pesanan.riwayat');
Route::get('/pesanan/{id}', [PesananController::class, 'detail'])->name('pesanan.detail');
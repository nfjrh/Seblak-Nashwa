<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthPelangganController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman pelanggan
|--------------------------------------------------------------------------
*/
Route::get('/', [BerandaController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    // nama 'login' dipakai Laravel untuk mengarahkan tamu yang belum masuk
    Route::get('/masuk', [AuthPelangganController::class, 'form'])->name('login');

    Route::post('/masuk', [AuthPelangganController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('login.submit');

    Route::post('/daftar', [AuthPelangganController::class, 'daftar'])
        ->middleware('throttle:10,1')
        ->name('register.submit');
});

Route::post('/keluar', [AuthPelangganController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Halaman admin (tidak diubah)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::post('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login.submit');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard');

Route::post('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Anggota 2: Kategori, Menu, Katalog
|--------------------------------------------------------------------------
*/
Route::resource('kategori', KategoriController::class)->except('show');
Route::resource('menu', MenuController::class)->except('show');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{menu}', [KatalogController::class, 'show'])->name('katalog.show'); 

// ===== Anggota 5: Checkout & Pesanan =====
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/pesanan/riwayat', [PesananController::class, 'riwayat'])->name('pesanan.riwayat');
Route::get('/pesanan/{id}', [PesananController::class, 'detail'])->name('pesanan.detail');
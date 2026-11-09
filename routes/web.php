<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\AuthPelangganController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LevelPedasController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ToppingController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PengaturanController;

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
// Kelola kategori dan menu hanya untuk admin (sebelumnya terbuka untuk siapa saja)
Route::middleware(AdminOnly::class)->group(function () {
    Route::resource('kategori', KategoriController::class)->except('show');
    Route::patch('menu/{menu}/status', [MenuController::class, 'ubahStatus'])->name('menu.status');
    Route::resource('menu', MenuController::class)->except('show');
});
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{menu}', [KatalogController::class, 'show'])->name('katalog.show');

/*
|--------------------------------------------------------------------------
| Keranjang, checkout, dan pesanan (harus login sebagai pelanggan)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::patch('/keranjang/{id}', [KeranjangController::class, 'ubah'])->whereNumber('id')->name('keranjang.ubah');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus'])->whereNumber('id')->name('keranjang.hapus');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    Route::get('/pesanan/riwayat', [PesananController::class, 'riwayat'])->name('pesanan.riwayat');
    Route::get('/pesanan/{id}', [PesananController::class, 'detail'])->whereNumber('id')->name('pesanan.detail');
});

/*
|--------------------------------------------------------------------------
| Anggota 3: Topping dan Level Pedas (khusus admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(AdminOnly::class)->group(function () {
    Route::resource('topping', ToppingController::class)->except('show');
    Route::resource('level', LevelPedasController::class)->except('show');

    // Pesanan masuk (admin)
    Route::get('pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('pesanan/{id}', [AdminPesananController::class, 'show'])->whereNumber('id')->name('pesanan.show');
    Route::patch('pesanan/{id}/status', [AdminPesananController::class, 'ubahStatus'])->whereNumber('id')->name('pesanan.status');
    Route::patch('pesanan/{id}/pembayaran', [AdminPesananController::class, 'verifikasiPembayaran'])->whereNumber('id')->name('pesanan.pembayaran');

    // Laporan penjualan dan pengaturan kedai
    Route::get('laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::view('pengaturan', 'admin.pengaturan')->name('pengaturan');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('admin.pengaturan');
    Route::put('/pengaturan', [PengaturanController::class, 'update'])->name('admin.pengaturan.update');
});
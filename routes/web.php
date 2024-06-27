<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
// use App\Http\Middleware\IsAdmin;


// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});

// middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('user', UserController::class);
    Route::resource('akun', AkunController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('transaksi', TransaksiController::class);
});

// middleware admin
// Route::middleware(['auth', IsAdmin::class])->group(function () {
//     Route::resource('user', UserController::class);
//     Route::resource('akun', AkunController::class);
//     Route::resource('customer', CustomerController::class);
// });

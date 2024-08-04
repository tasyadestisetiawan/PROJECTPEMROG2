<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;

// Login
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route to redirect to login
Route::redirect('/', '/login');

// Middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Middleware untuk superadmin
    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('customer', CustomerController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('produk', ProdukController::class);
        Route::resource('transaksi', TransaksiController::class);
        Route::resource('pembayaran', PembayaranController::class);
        Route::get('transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::post('transaksi/print', [TransaksiController::class, 'generatePDF'])->name('transaksi.print');
    });

    // Middleware untuk admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('customer', CustomerController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
        Route::resource('kategori', KategoriController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
        Route::resource('produk', ProdukController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
        Route::resource('transaksi', TransaksiController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
        Route::resource('pembayaran', PembayaranController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
        Route::get('transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::post('transaksi/print', [TransaksiController::class, 'generatePDF'])->name('transaksi.print');
    });
});


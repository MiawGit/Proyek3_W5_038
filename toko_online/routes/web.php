<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\RoleController;

Route::get('/', fn () => redirect()->route('produk.index'));

Route::get('/produk', [ProductController::class, 'index'])
    ->name('produk.index');

// Login dan registrasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.submit');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Keranjang dan checkout hanya untuk customer (BR-07)
Route::middleware(['auth', 'can:use-cart'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])
        ->name('keranjang.index');

    Route::post('/keranjang/{id}', [CartController::class, 'tambah'])
        ->name('keranjang.tambah');

    Route::patch('/keranjang/{id}', [CartController::class, 'update'])
        ->name('keranjang.update');

    Route::delete('/keranjang/{id}', [CartController::class, 'hapus'])
        ->name('keranjang.hapus');

    Route::get('/checkout', [OrderController::class, 'checkoutForm'])
        ->name('checkout');

    Route::post('/checkout', [OrderController::class, 'checkout'])
        ->name('checkout.proses');
});

// Riwayat pesanan hanya untuk pengguna login
Route::middleware('auth')->group(function () {
    Route::get('/pesanan', [OrderController::class, 'index'])
        ->name('pesanan.index');
});

// Halaman khusus staff: melihat stok produk
Route::middleware(['auth', 'can:adjust-stock'])->group(function () {
    Route::get('/staff/stok', [StockController::class, 'index'])
        ->name('staff.stok.index');
});

// Halaman khusus admin: mengubah role user dan mengelola produk
Route::middleware(['auth', 'can:manage-roles'])->group(function () {
    Route::get('/admin/users', [RoleController::class, 'index'])
        ->name('admin.users.index');

    Route::patch('/admin/users/{user}/role', [RoleController::class, 'update'])
        ->name('admin.users.role.update');
});

Route::middleware(['auth', 'can:manage-products'])->group(function () {
    Route::get('/admin/products', [ProductController::class, 'manage'])
        ->name('admin.products.index');

    Route::patch('/admin/products/{product}/stok', [ProductController::class, 'updateStok'])
        ->name('admin.products.stok.update');
});

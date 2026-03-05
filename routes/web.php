<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProductController;

// ══════════════════════════════════════════════════════
// PUBLIC ROUTES
// ══════════════════════════════════════════════════════

Route::get('/', [HomeController::class, 'index'])->name('home');

// Browse UMKM
Route::get('/umkm', [StoreController::class, 'index'])->name('stores.index');
Route::get('/umkm/{umkm}', [StoreController::class, 'show'])->name('stores.show');
Route::get('/umkm/{umkm}/produk/{product}', [StoreController::class, 'product'])->name('stores.product');

// ══════════════════════════════════════════════════════
// AUTH ROUTES
// ══════════════════════════════════════════════════════

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ══════════════════════════════════════════════════════
// OWNER ROUTES (pemilik)
// ══════════════════════════════════════════════════════

Route::middleware(['auth', 'role:pemilik,admin'])->prefix('pemilik')->name('owner.')->group(function () {
    Route::get('/', [OwnerController::class, 'dashboard'])->name('dashboard');

    // UMKM management
    Route::get('/umkm/buat', [OwnerController::class, 'createUmkm'])->name('createUmkm');
    Route::post('/umkm', [OwnerController::class, 'storeUmkm'])->name('storeUmkm');
    Route::get('/umkm/edit', [OwnerController::class, 'editUmkm'])->name('editUmkm');
    Route::put('/umkm', [OwnerController::class, 'updateUmkm'])->name('updateUmkm');
    Route::post('/umkm/toggle-status', [OwnerController::class, 'toggleStoreStatus'])->name('toggleStoreStatus');

    // Product management
    Route::get('/produk', [OwnerController::class, 'products'])->name('products');
    Route::get('/produk/tambah', [OwnerController::class, 'createProduct'])->name('createProduct');
    Route::post('/produk', [OwnerController::class, 'storeProduct'])->name('storeProduct');
    Route::get('/produk/{product}/edit', [OwnerController::class, 'editProduct'])->name('editProduct');
    Route::put('/produk/{product}', [OwnerController::class, 'updateProduct'])->name('updateProduct');
    Route::delete('/produk/{product}', [OwnerController::class, 'deleteProduct'])->name('deleteProduct');
    Route::post('/produk/{product}/toggle-status', [OwnerController::class, 'toggleProductStatus'])->name('toggleProductStatus');
});

// ══════════════════════════════════════════════════════
// ADMIN ROUTES
// ══════════════════════════════════════════════════════

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [UmkmController::class, 'index'])->name('dashboard');

    // UMKM CRUD (admin)
    Route::get('/umkm/create', [UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/{umkm}/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/umkm/{umkm}', [UmkmController::class, 'update'])->name('umkm.update');
    Route::delete('/umkm/{umkm}', [UmkmController::class, 'destroy'])->name('umkm.destroy');

    // Admin: verify UMKM
    Route::post('/umkm/{umkm}/verify', [UmkmController::class, 'verify'])->name('umkm.verify');

    // Product CRUD (admin, nested under UMKM)
    Route::resource('umkm.products', ProductController::class);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\ProductController;

// READ
Route::get('/', [UmkmController::class, 'index'])->name('umkm.index');
Route::resource('umkm.products', ProductController::class);
Route::resource('umkm.products', ProductController::class);

// CREATE
Route::get('/umkm/create', [UmkmController::class, 'create'])->name('umkm.create');
Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store');

// UPDATE
Route::get('/umkm/{umkm}/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
Route::put('/umkm/{umkm}', [UmkmController::class, 'update'])->name('umkm.update');

// DELETE
Route::delete('/umkm/{umkm}', [UmkmController::class, 'destroy'])->name('umkm.destroy');

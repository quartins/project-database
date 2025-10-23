<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CollectionController;


// หน้าแรก (ทุกคนเข้าดูได้)
Route::get('/', [ProductController::class, 'index'])->name('home');

// about real-time search 
Route::get('/search', [ProductController::class, 'search'])->name('search');

// หน้า Collection 
Route::get('/collections', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collections/{category}', [CollectionController::class, 'show'])->name('collection.show');

// ป้องกันการเข้าถึง cart/profile โดยยังไม่ login
Route::middleware(['auth'])->group(function () {

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // Profile pages
    Route::get('/myprofile', function () {
        return view('myprofile.profile'); 
    })->name('profile.custom');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
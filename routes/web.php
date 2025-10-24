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

    // 1. หน้าสำหรับโชว์ QR Code (GET)
    Route::get('/payment', function () {
        return view('payment.index'); 
    })->name('payment.show');

    // 2. route สำหรับรับการ "ยืนยันการชำระเงิน" (POST)
    Route::post('/payment/confirm', function () {
        // 📍 นี่คือจุดที่จะเขียน Logic ตรวจสอบการจ่ายเงินในอนาคต
        // แต่ตอนนี้ เราจะ redirect ไปหน้า Thank You เลย
        return redirect()->route('payment.thankyou');
    })->name('payment.confirm');

    // 3. หน้า Thank You (GET)
    Route::get('/thank-you', function () {
        return view('payment.thankyou');
    })->name('payment.thankyou');
});

require __DIR__.'/auth.php';
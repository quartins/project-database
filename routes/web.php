<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileOrderController;
use App\Http\Controllers\ProfileAddressController;
use Illuminate\Support\Facades\Route;

/* -------------------------------------------------------------------------- */
/*  Public (เข้าถึงได้ทุกคน)                                         */
/* -------------------------------------------------------------------------- */

// หน้าแรก
Route::get('/', [ProductController::class, 'index'])->name('home');

// หน้า About & Contact
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');

// ค้นหาสินค้าแบบเรียลไทม์
Route::get('/search', [ProductController::class, 'search'])->name('search');

// หน้า Collection ทั้งหมด + รายหมวดหมู่
Route::get('/collections', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collections/{category}', [CollectionController::class, 'show'])->name('collection.show');

// รายละเอียดสินค้า
Route::get('/products/{idSlug}', [ProductController::class, 'show'])
    ->where('idSlug', '[0-9]+(?:-[A-Za-z0-9\-]+)?')
    ->name('products.show');

// Add To Cart (ตรวจ login ภายใน Controller เอง)
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add')
    ->withoutMiddleware('auth');

/* -------------------------------------------------------------------------- */
/* 💳 Checkout Flow                                                           */
/* -------------------------------------------------------------------------- */

// BUY NOW → สร้าง order draft → Summary
Route::get('/buy/{product}', [CheckoutController::class, 'createFromProduct'])->name('checkout.buy');

// Summary (กรอกที่อยู่ + คูปอง)
Route::get('/checkout/{order}', [CheckoutController::class, 'summary'])->name('checkout.summary');
Route::post('/checkout/{order}', [CheckoutController::class, 'update'])->name('checkout.update');
Route::post('/checkout/{order}/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');

// Payment & Thank You
Route::get('/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/payment/{order}/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
Route::get('/thank-you', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');

/* -------------------------------------------------------------------------- */
/*  (ต้องล็อกอิน)                                               */
/* -------------------------------------------------------------------------- */

Route::middleware(['auth'])->group(function () {

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Profile pages
    Route::get('/myprofile', fn() => redirect()->route('profile.edit'))->name('profile.custom');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Orders & Address
    Route::get('/orders', [ProfileOrderController::class, 'index'])->name('orders.index');
    Route::get('/profile/address', [ProfileAddressController::class, 'edit'])->name('address.edit');
    Route::patch('/profile/address', [ProfileAddressController::class, 'update'])->name('address.update');
});

/* -------------------------------------------------------------------------- */
/* Authentication Routes (register, login, logout)                         */
/* -------------------------------------------------------------------------- */
require __DIR__.'/auth.php';

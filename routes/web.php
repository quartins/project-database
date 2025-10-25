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
/* 🌸 Public Routes (เข้าถึงได้ทุกคน)                                         */
/* -------------------------------------------------------------------------- */

// 🏠 หน้าแรก
Route::get('/', [ProductController::class, 'index'])->name('home');

// 📄 Static Pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// 🔍 Search
Route::get('/search', [ProductController::class, 'search'])->name('search');

// 🧸 Collections
Route::get('/collections', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collections/{category}', [CollectionController::class, 'show'])->name('collection.show');

// 🛍 Product Details
Route::get('/products/{idSlug}', [ProductController::class, 'show'])
    ->where('idSlug', '[0-9]+(?:-[A-Za-z0-9\-]+)?')
    ->name('products.show');

// 🛒 Add to Cart (ไม่ต้องล็อกอิน)
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add')
    ->withoutMiddleware('auth');

/* -------------------------------------------------------------------------- */
/* 💳 Checkout Flow                                                           */
/* -------------------------------------------------------------------------- */

Route::get('/buy/{product}', [CheckoutController::class, 'createFromProduct'])->name('checkout.buy');
Route::get('/checkout/{order}', [CheckoutController::class, 'summary'])->name('checkout.summary');
Route::post('/checkout/{order}', [CheckoutController::class, 'update'])->name('checkout.update');
Route::post('/checkout/{order}/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
Route::get('/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/payment/{order}/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
Route::get('/thank-you', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');

/* -------------------------------------------------------------------------- */
/* 🔐 Authenticated Routes (ต้องล็อกอินก่อนเข้าได้)                            */
/* -------------------------------------------------------------------------- */

Route::middleware(['auth'])->group(function () {
    // 🛒 Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Profile
    Route::get('/myprofile', fn() => redirect()->route('profile.edit'))->name('profile.custom');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Orders & Address
    Route::get('/orders', [ProfileOrderController::class, 'index'])->name('orders.index');
    Route::get('/profile/address', [ProfileAddressController::class, 'edit'])->name('address.edit');
    Route::patch('/profile/address', [ProfileAddressController::class, 'update'])->name('address.update');

    Route::post('/profile/address/add', [ProfileAddressController::class, 'store'])->name('address.add');
    Route::post('/profile/address/{address}/default', [ProfileAddressController::class, 'setDefault'])->name('address.setDefault');
    Route::delete('/profile/address/{address}', [ProfileAddressController::class, 'destroy'])->name('address.delete');


});

require __DIR__.'/auth.php';

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
/* Public Routes (เข้าถึงได้ทุกคน)                                         */
/* -------------------------------------------------------------------------- */

//  หน้าแรก
Route::get('/', [ProductController::class, 'index'])->name('home');

//  Static Pages
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

//  Search
Route::get('/search', [ProductController::class, 'search'])->name('search');

//  Collections
Route::get('/collections', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collections/{category}', [CollectionController::class, 'show'])->name('collection.show');

// Product Details
Route::get('/products/{idSlug}', [ProductController::class, 'show'])
    ->where('idSlug', '[0-9]+(?:-[A-Za-z0-9\-]+)?')
    ->name('products.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/buy/{product}', [CheckoutController::class, 'createFromProduct'])->name('checkout.buy');
    Route::get('/checkout/{order}', [CheckoutController::class, 'summary'])->name('checkout.summary');
    Route::post('/checkout/{order}', [CheckoutController::class, 'update'])->name('checkout.update');
    Route::post('/checkout/{order}/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
    Route::post('/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/payment/{order}/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::get('/thank-you', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');
    Route::post('/cart/check-stock', [CartController::class, 'checkStock']);
    Route::get('/cart/get-stock/{id}', [CartController::class, 'getStock']);
    Route::get('/cart/get-item/{id}', [CartController::class, 'getItem']);
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

});

Route::middleware(['auth'])->group(function () {

    /* ------------------------------  CART ------------------------------ */
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    /* -----------------------------  PROFILE ----------------------------- */
    Route::get('/myprofile', fn() => redirect()->route('profile.edit'))->name('profile.custom');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* -------------------------  ORDERS & ADDRESS ------------------------ */
    Route::get('/orders', [ProfileOrderController::class, 'index'])->name('orders.index');
    Route::get('/profile/address', [ProfileAddressController::class, 'showPage'])
    ->name('profile.address.page');

    //  Address Management (Chamora style)
   Route::get('/profile/address/list', [ProfileAddressController::class, 'index'])->name('profile.address.list');
    Route::post('/profile/address', [ProfileAddressController::class, 'store'])->name('profile.address.store');
    Route::put('/profile/address/{address}', [ProfileAddressController::class, 'update'])->name('profile.address.update');
    Route::delete('/profile/address/{address}', [ProfileAddressController::class, 'destroy'])->name('profile.address.delete');
    Route::post('/profile/address/{address}/default', [ProfileAddressController::class, 'setDefault'])->name('profile.address.default');
    
    Route::post('/checkout/{order}/address', [CheckoutController::class, 'updateAddress'])
    ->name('checkout.updateAddress');
    // ยกเลิกคำสั่งซื้อ
    Route::post('/orders/{order}/cancel', [\App\Http\Controllers\CheckoutController::class, 'cancel'])
    ->name('checkout.cancel');

});

Route::middleware('auth')->get('/api/address/{id}', function ($id) {
    $address = \App\Models\UserAddress::where('user_id', auth()->id())->findOrFail($id);
    return response()->json($address);
});

require __DIR__.'/auth.php';

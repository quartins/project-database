<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;


Route::get('/products/{key}', [ProductController::class,'show'])
     ->where('key', '[0-9]+(?:-[A-Za-z0-9\-]+)?')
     ->name('products.show');

// --- หน้าสาธารณะที่ทุกคนเข้าได้ ---

// หน้าแรก


Route::get('/', [ProductController::class, 'index'])->name('home');

// หน้า Collection 
Route::get('/collections', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collections/{category}', [CollectionController::class, 'show'])->name('collection.show');


// รายละเอียดสินค้า: /products/{id}-{slug}
Route::get('/products/{idSlug}', [ProductController::class,'show'])->name('products.show');

// BUY NOW → สร้าง order draft → Summary
Route::get ('/buy/{product}',           [CheckoutController::class,'createFromProduct'])->name('checkout.buy');

// Summary (กรอกที่อยู่ + คูปอง)
Route::get ('/checkout/{order}',        [CheckoutController::class,'summary'])->name('checkout.summary');
Route::post('/checkout/{order}',        [CheckoutController::class,'update'])->name('checkout.update');

Route::post('/checkout/{order}/coupon', [CheckoutController::class, 'applyCoupon'])
    ->name('checkout.applyCoupon');

// Payment (จำลอง) & Thank You
Route::get ('/payment/{order}',         [CheckoutController::class,'payment'])->name('checkout.payment');
Route::post('/payment/{order}/confirm', [CheckoutController::class,'confirm'])->name('checkout.confirm');
Route::get ('/thank-you',               [CheckoutController::class,'thankyou'])->name('checkout.thankyou');



// --- โซนสำหรับสมาชิกเท่านั้น (ต้องล็อกอิน) ---


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
    // เด้งไปหน้า /profile ที่ใช้ Controller และส่ง $user ถูกต้องแล้ว
    return redirect()->route('profile.edit');
})->name('profile.custom');

require __DIR__.'/auth.php';

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

   
});
 
require __DIR__.'/auth.php';

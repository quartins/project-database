<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (ไม่ต้อง login)
|--------------------------------------------------------------------------
*/

// หน้าแรก
Route::get('/', [ProductController::class, 'index'])->name('home');

// ค้นหาแบบเรียลไทม์
Route::get('/search', [ProductController::class, 'search'])->name('search');

// หน้า Collection และหมวดหมู่สินค้า
Route::get('/collections', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collections/{category}', [CollectionController::class, 'show'])->name('collection.show');

// รายละเอียดสินค้า (แสดงสินค้าเดี่ยว)
Route::get('/products/{idSlug}', [ProductController::class, 'show'])
    ->where('idSlug', '[0-9]+(?:-[A-Za-z0-9\-]+)?')
    ->name('products.show');

// ซื้อสินค้า (Buy Now) → สร้างออเดอร์ → Summary
Route::get('/buy/{product}', [CheckoutController::class, 'createFromProduct'])->name('checkout.buy');

// Summary (กรอกที่อยู่ + คูปอง)
Route::get('/checkout/{order}', [CheckoutController::class, 'summary'])->name('checkout.summary');
Route::post('/checkout/{order}', [CheckoutController::class, 'update'])->name('checkout.update');

// ใช้คูปองส่วนลด
Route::post('/checkout/{order}/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');

// หน้าชำระเงิน & หน้ายืนยันการชำระ
Route::get('/payment/{order}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/payment/{order}/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');

// หน้าขอบคุณ (หลังจ่ายเงินเสร็จ)
Route::get('/thank-you', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');


/*
|--------------------------------------------------------------------------
| Protected Routes (ต้องล็อกอินก่อน)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 🛒 Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // 👤 Profile routes
    Route::get('/myprofile', function () {
        // เด้งไปหน้า profile ที่ถูกต้อง
        return redirect()->route('profile.edit');
    })->name('profile.custom');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📦 Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes (login, register, logout)
|--------------------------------------------------------------------------
|
| ต้องอยู่ "นอก" middleware('auth') เพื่อให้ผู้ใช้ที่ยังไม่ login เข้าถึงได้
| Laravel จะใช้ redirect()->intended() กลับไปยังหน้าก่อน login ให้อัตโนมัติ
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

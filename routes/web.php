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

/*
|--------------------------------------------------------------------------
| Public routes (ไม่ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/

// หน้าแรก
Route::get('/', [ProductController::class, 'index'])->name('home');

// ค้นหา
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Collection
Route::get('/collections', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/collections/{category}', [CollectionController::class, 'show'])->name('collection.show');

// รายละเอียดสินค้า: รองรับทั้ง "123" หรือ "123-some-slug"
Route::get('/products/{key}', [ProductController::class,'show'])
    ->where('key', '[0-9]+(?:-[A-Za-z0-9\-]+)?')
    ->name('products.show');

// หน้า static
Route::get('/contact', fn () => view('contact'))->name('contact');
Route::get('/about',   fn () => view('about'))->name('about');

// Thank You (จะให้สาธารณะเข้าถึงได้เพื่อให้แชร์ลิงก์ได้; ถ้าต้องล็อกอินก่อนค่อยย้ายเข้า auth group)
Route::get('/thank-you', [CheckoutController::class,'thankyou'])->name('checkout.thankyou');


/*
|--------------------------------------------------------------------------
| Auth required (ต้องล็อกอิน)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Cart
    Route::get ('/cart',        [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',    [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::get ('/cart/count',  [CartController::class, 'count'])->name('cart.count');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Checkout flow ทั้งหมดต้องล็อกอิน
    Route::get ('/buy/{product}',           [CheckoutController::class,'createFromProduct'])->name('checkout.buy');

    Route::get ('/checkout/{order}',        [CheckoutController::class,'summary'])->name('checkout.summary');
    Route::post('/checkout/{order}',        [CheckoutController::class,'update'])->name('checkout.update');
    Route::post('/checkout/{order}/coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');

    // Payment
    Route::get ('/payment/{order}',         [CheckoutController::class,'payment'])->name('checkout.payment');
    Route::post('/payment/{order}/confirm', [CheckoutController::class,'confirm'])->name('checkout.confirm');

    // Profile → เด้งจาก /myprofile ไป /profile
    Route::get('/myprofile', fn () => redirect()->route('profile.edit'))->name('profile.custom');

    Route::get   ('/profile',         [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch ('/profile',         [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',         [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get   ('/orders',          [ProfileOrderController::class, 'index'])->name('orders.index');

    Route::get   ('/profile/address', [ProfileAddressController::class, 'edit'])->name('address.edit');
    Route::patch ('/profile/address', [ProfileAddressController::class, 'update'])->name('address.update');
});

// auth routes (วางท้ายไฟล์ครั้งเดียว)
require _DIR_.'/auth.php';
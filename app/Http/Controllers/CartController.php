<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // แสดงหน้าตะกร้า
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to view your cart.');
        }

        $user = Auth::user();
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $items = $cart->cartItems()->with('product')->get();

        $subtotal = $items->sum(fn($i) => $i->product->price * $i->quantity);

        return view('cartpage.cart', compact('items', 'subtotal'));
    }

    // เพิ่มสินค้า ตรง icon cart
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please login first'], 401);
        }

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($item) {
            $item->quantity += 1;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        $count = CartItem::where('cart_id', $cart->id)->sum('quantity');

        return response()->json([
            'message' => 'เพิ่มสินค้าในตะกร้าแล้ว',
            'cart_count' => $count
        ]);
    }

    // ลบสินค้า
    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Not logged in'], 401);
        }

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) return response()->json(['cart_count' => 0]);

        CartItem::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->delete();

        $count = CartItem::where('cart_id', $cart->id)->sum('quantity');

        return response()->json([
            'message' => 'ลบสินค้าแล้ว',
            'cart_count' => $count
        ]);
    }

    // อัปเดตจำนวนสินค้า
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Not logged in'], 401);
        }

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) return response()->json(['cart_count' => 0]);

        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($item) {
            $item->quantity = max(1, $request->quantity);
            $item->save();
        }

        $subtotal = $cart->cartItems()->with('product')->get()
                         ->sum(fn($i) => $i->product->price * $i->quantity);

        $count = $cart->cartItems()->sum('quantity');

        return response()->json([
            'subtotal' => $subtotal,
            'cart_count' => $count
        ]);
    }

    // ดึงจำนวนสินค้า (ใช้ตอนโหลดหน้า Home)
    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $cart = Cart::where('user_id', Auth::id())->first();
        $count = $cart ? $cart->cartItems()->sum('quantity') : 0;

        return response()->json(['count' => $count]);
    }
}

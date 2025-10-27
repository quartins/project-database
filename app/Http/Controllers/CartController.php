<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

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

        // สร้างหรือดึงข้อมูล order ของผู้ใช้ ถ้าไม่มี order จะสร้างใหม่
        $order = Order::where('user_id', $user->id)->first();

        if (!$order) {
            // สร้าง order ใหม่ ถ้ายังไม่มี
            $order = Order::create([
                'user_id' => $user->id,
                'subtotal' => 0, // คำนวณ subtotal จากตะกร้า
                'shipping_fee' => 0, // ค่าจัดส่งที่ตั้งไว้
                'total' => 0, // ราคาทั้งหมด
            ]);
        }

        // คำนวณ subtotal จากสินค้าที่อยู่ในตะกร้า
        $subtotal = $items->sum(fn($i) => $i->product->price * $i->quantity);

        // ส่งข้อมูลไปยังวิว
        return view('cartpage.cart', compact('items', 'subtotal', 'order'));
    }

    public function add(Request $request)
    {
        // ถ้ายังไม่ login
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json(['ok' => false, 'need_login' => true], 401);
            }
            return redirect()->route('login')->with('error', 'กรุณาล็อกอินก่อน');
        }

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // ✅ ดึงจำนวนจาก request (qty หรือ quantity)
        $qty = max(1, (int) ($request->input('qty') ?? $request->input('quantity', 1)));

        // ✅ ตรวจว่ามี item เดิมไหม
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => $qty,
            ]);
        }

        // ✅ คำนวณจำนวนรวมใหม่
        $count = CartItem::where('cart_id', $cart->id)->sum('quantity');

        // ✅ ถ้าเป็น AJAX (fetch) → ส่ง JSON
        if ($request->ajax()) {
            return response()->json([
                'ok' => true,
                'cart_count' => $count,
                'message' => "เพิ่มสินค้า {$qty} ชิ้นในตะกร้าแล้ว!"
            ]);
        }

        // ✅ ถ้าเป็น form POST → redirect ไปหน้าตะกร้า
        return redirect()
            ->route('cart.index')
            ->with('success', "เพิ่มสินค้า {$qty} ชิ้นในตะกร้าแล้ว!");
    }

    // ✅ ลบสินค้า
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

    // ✅ อัปเดตจำนวนสินค้า
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

    // ✅ ดึงจำนวนสินค้า (ใช้ตอนโหลดหน้า Home)
    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $cart = Cart::where('user_id', Auth::id())->first();
        $count = $cart ? $cart->cartItems()->sum('quantity') : 0;

        return response()->json(['count' => $count]);
    }

    // App\Http\Controllers\CartController.php
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'กรุณาล็อกอินก่อนที่จะดำเนินการต่อ');
        }

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            return redirect('/cart')->with('error', 'ตะกร้าของคุณว่างเปล่า');
        }

        // ✅ รับเฉพาะรายการที่ "ติ๊กเลือก" มาจากฟอร์ม
        $payload = json_decode($request->input('items', '[]'), true);
        if (empty($payload) || !is_array($payload)) {
            return redirect('/cart')->with('error', 'กรุณาเลือกสินค้าอย่างน้อย 1 รายการ');
        }

        $selectedIds = collect($payload)->pluck('product_id')->map(fn($v)=> (int)$v)->values();
        $qtyMap = collect($payload)->mapWithKeys(function ($row) {
            $pid = (int)($row['product_id'] ?? 0);
            $q   = max(1, (int)($row['qty'] ?? 1));
            return [$pid => $q];
        });

        // ✅ ดึงรายการในตะกร้าตามที่เลือกเท่านั้น
        $items = $cart->cartItems()
                    ->whereIn('product_id', $selectedIds)
                    ->with('product')
                    ->get();

        if ($items->isEmpty()) {
            return redirect('/cart')->with('error', 'ไม่พบสินค้าที่เลือก');
        }

        // ✅ คำนวณยอดรวมตามจำนวนที่เลือกจริง
        $subtotal = 0;
        foreach ($items as $ci) {
            $qty = $qtyMap[$ci->product_id] ?? $ci->quantity ?? 1;
            $subtotal += $ci->product->price * $qty;
        }

        $shipping = 35.00;

        // ✅ สร้างออเดอร์
        $order = Order::create([
            'user_id'      => $user->id,
            'subtotal'     => $subtotal,
            'shipping_fee' => $shipping,
            'total'        => $subtotal + $shipping,
            'status'       => 'draft',
        ]);

        foreach ($items as $ci) {
            $qty = $qtyMap[$ci->product_id] ?? $ci->quantity ?? 1;
            $order->items()->create([
                'product_id' => $ci->product_id,
                'qty'        => $qty, // ✅ ใช้ 'qty' ให้ตรง DB
                'unit_price' => $ci->product->price,
            ]);
        }


        // (ถ้ามีเมธอด $order->recalc()) จะยิ่งชัวร์:
        if (method_exists($order, 'recalc')) {
            $order->recalc();
        }

        // ✅ ลบเฉพาะรายการที่ "เลือกแล้ว" ออกจากตะกร้า (ไม่ลบทั้งตะกร้า)
        //$cart->cartItems()->whereIn('product_id', $selectedIds)->delete();

        return redirect()->route('checkout.summary', ['order' => $order]);
    }

    public function getStock($id)
    {
        $product = \App\Models\Product::find($id);
        if (!$product) {
            return response()->json(['error' => true, 'message' => 'Product not found'], 404);
        }
        return response()->json(['stock_qty' => $product->stock_qty]);
    }
    
    public function getItem($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => true, 'message' => 'Not logged in'], 401);
        }

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            return response()->json(['current_qty' => 0]);
        }

        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $id)
                        ->first();

        $qty = $item ? $item->quantity : 0;

        return response()->json(['current_qty' => $qty]);
    }


    public function checkStock(Request $request)
    {
        $items = $request->input('items', []);
        foreach ($items as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if (!$product) {
                return response()->json(['error' => true, 'message' => 'Product not found'], 404);
            }
            if ($item['qty'] > $product->stock_qty) {
                return response()->json([
                    'error' => true,
                    'message' => "Sorry, {$product->name} only has {$product->stock_qty} left in stock."
                ], 400);
            }
        }
        return response()->json(['ok' => true]);
    }

}

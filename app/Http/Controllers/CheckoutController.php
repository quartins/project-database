<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /* 🛒 1. สร้าง Order จากการซื้อสินค้าทันที                                  */
    /* -------------------------------------------------------------------------- */
    public function createFromProduct(Product $product, Request $request)
    {
        $qty = max(1, (int) $request->get('qty', 1));
        $max = (int) $product->stock_qty;

        // ❗ ถ้าเกินสต็อก ให้เตือนและเด้งกลับหน้าสินค้า
        if ($qty > $max) {
            $back = $request->get(
                'return',
                route('products.show', [
                    'key' => $product->id . '-' . \Illuminate\Support\Str::slug($product->name)
                ])
            );

            return redirect()->to($back)
                ->with('flash_err', "ขออภัย จำนวนที่ต้องการ ($qty) มากกว่าสินค้าที่เหลือในสต็อก ($max) ชิ้น")
                ->with('suggested_qty', $max);
        }

        // ✅ สร้างคำสั่งซื้อ
        $order = Order::create([
            'user_id'      => auth()->id(),
            'status'       => 'draft',
            'shipping_fee' => 35.00,
        ]);

        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'qty'        => $qty,
            'unit_price' => $product->price,
        ]);

        $order->recalc();

        if ($request->filled('return')) {
            session()->put("order_return_{$order->id}", $request->get('return'));
        }

        return redirect()->route('checkout.summary', $order);
    }

    /* -------------------------------------------------------------------------- */
    /* 🧾 2. แสดงหน้า Order Summary                                             */
    /* -------------------------------------------------------------------------- */
    public function summary(Order $order)
{
    // ✅ โหลดสัมพันธ์ที่ต้องใช้ทั้งหมด
    $order->load(['items.product', 'shippingAddress']);

    // 🔹 ตรวจสอบจำนวนสต็อกก่อนแสดง
    foreach ($order->items as $it) {
        if ($it->qty > $it->product->stock_qty) {
            $back = route('products.show', [
                'key' => $it->product->id . '-' . \Illuminate\Support\Str::slug($it->product->name)
            ]);
            return redirect()->to($back)
                ->with('flash_err', "ตอนนี้สินค้า {$it->product->name} เหลือ {$it->product->stock_qty} ชิ้น")
                ->with('suggested_qty', $it->product->stock_qty);
        }
    }

    // 🔹 ดึงที่อยู่เริ่มต้นของผู้ใช้ (default address)
    $defaultAddress = null;
    if (auth()->check()) {
        $defaultAddress = auth()->user()
            ->addresses()
            ->where('is_default', true)
            ->first();
    }

    // 🔹 หาหน้ากลับ (return URL)
    $returnUrl =
        session("order_return_{$order->id}") ?:
        url()->previous() ?:
        ($order->items->first()
            ? route('products.show', [
                'key' => $order->items->first()->product->id . '-' .
                         \Illuminate\Support\Str::slug($order->items->first()->product->name)
              ])
            : url('/'));

    // ✅ ส่งตัวแปรไปยัง view ให้ครบ
    return view('checkout.summary', compact('order', 'returnUrl', 'defaultAddress'));
}


    /* -------------------------------------------------------------------------- */
    /* 🏠 3. อัปเดตข้อมูลที่อยู่ / คูปอง / ค่าขนส่ง                             */
    /* -------------------------------------------------------------------------- */
    public function update(Order $order, Request $req)
    {
        $data = $req->validate([
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'nullable|string|max:30',
            'address_line1'  => 'required|string|max:255',
            'address_line2'  => 'nullable|string|max:255',
            'district'       => 'nullable|string|max:100',
            'province'       => 'nullable|string|max:100',
            'postcode'       => 'nullable|string|max:10',
            'country'        => 'nullable|string|max:100',
            'shipping_fee'   => 'required|numeric|min:0',
            'coupon_code'    => 'nullable|string|max:50',
        ]);

        $order->fill($data);

        // ประมวลผลคูปองถ้ามี
        $order->discount = 0;
        if (filled($order->coupon_code) && strtolower(trim($order->coupon_code)) === 'chamora') {
            $order->discount = round($order->subtotal * 0.15, 2);
        }

        $order->recalc();

        return redirect()->route('checkout.payment', $order);
    }


     public function applyCoupon(Order $order, Request $req)
        {
            $addressKeys = [
                'recipient_name','phone','address_line1','address_line2',
                'district','province','postcode','country','shipping_fee'
            ];
            $draft = $req->only($addressKeys);
            if (!empty(array_filter($draft))) {
                $order->fill($draft);
            }

            $code = strtolower(trim($req->input('coupon_code', '')));
            $order->coupon_code = $code ?: null;
            $order->discount = 0;

            $msgKey = 'coupon_info';
            $msgVal = 'นำคูปองออกแล้ว';

            if ($code === 'chamora') {
                // ✅ ลดทุกสินค้า 15%
                $order->discount = round($order->subtotal * 0.15, 2);
                $msgKey = 'coupon_ok';
                $msgVal = 'ใช้โค้ด chamora สำเร็จ — ลด 15% ของค่าสินค้าทั้งหมด';
            } 
            elseif ($code === 'collection10') {
                // ✅ ลดเฉพาะหมวดหมู่ 3 (Kuromi) และ 4 (Hirono)
                $eligibleIds = [3, 4];
                $eligibleTotal = 0;

                foreach ($order->items as $item) {
                    if (in_array($item->product->category_id, $eligibleIds)) {
                        $eligibleTotal += $item->unit_price * $item->qty;
                    }
                }

                if ($eligibleTotal > 0) {
                    $order->discount = round($eligibleTotal * 0.10, 2);
                    $msgKey = 'coupon_ok';
                    $msgVal = 'ใช้โค้ด collection10 สำเร็จ — ลด 10% สำหรับสินค้า Kuromi และ Hirono';
                } else {
                    // ❌ ไม่มีสินค้าที่ใช้ได้
                    $msgKey = 'coupon_err';
                    $msgVal = 'คูปองนี้ใช้ได้เฉพาะกับสินค้า Kuromi และ Hirono เท่านั้น';
                }
            }

            $order->recalc();
            $order->save();

            return back()->with($msgKey, $msgVal)->withInput();
        }


    public function payment(Order $order)
    {
        if ($order->status === 'draft') {

            DB::transaction(function () use ($order) {
                $order->load('items.product');

                // ✅ ตรวจสอบ stock ก่อนหัก
                foreach ($order->items as $item) {
                    $p = $item->product;
                    if ($p->stock_qty < $item->qty) {
                        abort(409, "สินค้า {$p->name} คงเหลือไม่พอ");
                    }
                }

                // ✅ หัก stock จริง
                foreach ($order->items as $item) {
                    $item->product->decrement('stock_qty', $item->qty);
                }

                // ✅ เปลี่ยนสถานะเป็น pending_payment (รอจ่าย)
                $order->status = 'pending';
                $order->save();
            });
        }

        // ✅ โหลดข้อมูลสินค้ามาแสดง
        $order->load('items.product');

        $returnUrl = session("order_return_{$order->id}")
            ?? ($order->items->first()
                ? route('products.show', [
                    'idSlug' => $order->items->first()->product->id . '-' .
                                \Illuminate\Support\Str::slug($order->items->first()->product->name)
                ])
                : url('/'));

        return view('checkout.payment', compact('order', 'returnUrl'));
    }

    
     public function confirm(Request $request, Order $order)
        {
            if ($order->status === 'paid') {
                return redirect()->route('checkout.thankyou');
            }

            if ($order->status !== 'pending') {
                return redirect()->route('checkout.payment', $order)
                    ->with('flash_err', 'Invalid order status.');
            }

            // ✅ อัปเดตเป็นชำระเงินแล้ว
            $order->status  = 'paid';
            $order->paid_at = now();
            $order->save();
            $order->recalc();

            // ✅ เมื่อลูกค้าชำระเงินแล้ว ค่อยลบสินค้าที่อยู่ในตะกร้า
            $cart = \App\Models\Cart::where('user_id', $order->user_id)->first();
            if ($cart) {
                foreach ($order->items as $item) {
                    $cart->cartItems()->where('product_id', $item->product_id)->delete();
                }
            }

            // ✅ เคลียร์ session เดิม
            session()->forget("order_return_{$order->id}");

            // ✅ ไปหน้า Thank You
            return redirect()->route('checkout.thankyou')
                ->with('flash_ok', 'Payment successful! Your order has been confirmed.');
        }



    /* -------------------------------------------------------------------------- */
    /* 🎉 7. หน้า Thank You                                                      */
    /* -------------------------------------------------------------------------- */
    public function thankyou()
    {
        return view('checkout.thankyou');
    }

    public function updateAddress(Request $request, Order $order)
    {
        // ✅ ตรวจสอบสิทธิ์ว่า order เป็นของ user คนนี้
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order');
        }

        // ✅ ตรวจสอบ address ที่ส่งมา
        $data = $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        $address = \App\Models\Address::where('user_id', auth()->id())
            ->where('id', $data['address_id'])
            ->firstOrFail();

        // ✅ อัปเดตเฉพาะ order นี้ (ไม่แตะ default)
        $order->shipping_address_id = $address->id;
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Shipping address updated for this order.',
            'address' => $address,
        ], 200);
    }

    public function cancel(Order $order)
    {
        // ✅ ตรวจสอบสิทธิ์ผู้ใช้
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // ✅ ยกเลิกได้เฉพาะ order ที่ยัง pending
        if ($order->status !== 'pending') {
            return back()->with('flash_err', 'This order cannot be cancelled.');
        }

        // ✅ คืน stock ให้สินค้า
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock_qty', $item->qty);
            }
        }

        // ✅ เปลี่ยนสถานะเป็น cancelled (ไม่ต้องมี column เพิ่ม)
        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index', ['status' => 'pending'])
            ->with('flash_ok', 'Order cancelled successfully.');
    }

}

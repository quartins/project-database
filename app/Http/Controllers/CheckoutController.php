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

    public function createFromProduct(Product $product, Request $request)
    {
        $qty = max(1, (int) $request->get('qty', 1));
        $max = (int) $product->stock_qty;

          // If requested quantity exceeds stock
        if ($qty > $max) {
            $back = $request->get(
                'return',
                route('products.show', [
                    'key' => $product->id . '-' . \Illuminate\Support\Str::slug($product->name)
                ])
            );

            return redirect()->to($back)
                ->with('flash_err', "Sorry, the requested quantity ($qty) exceeds available stock ($max) units.")
                ->with('suggested_qty', $max);
        }

        // Create new order
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

    
    public function summary(Order $order)
    {
        $order->load(['items.product', 'shippingAddress']);

        // Verify stock before showing summary
        foreach ($order->items as $it) {
            if ($it->qty > $it->product->stock_qty) {
                $back = route('products.show', [
                    'key' => $it->product->id . '-' . \Illuminate\Support\Str::slug($it->product->name)
                ]);
                return redirect()->to($back)
                    ->with('flash_err', "The product {$it->product->name} now has only {$it->product->stock_qty}  items left.")
                    ->with('suggested_qty', $it->product->stock_qty);
            }
        }

        // Default address
        $defaultAddress = null;
        if (auth()->check()) {
            $defaultAddress = auth()->user()
                ->addresses()
                ->where('is_default', true)
                ->first();
        }

        $returnUrl =
            session("order_return_{$order->id}") ?:
            url()->previous() ?:
            ($order->items->first()
                ? route('products.show', [
                    'key' => $order->items->first()->product->id . '-' .
                            \Illuminate\Support\Str::slug($order->items->first()->product->name)
                ])
                : url('/'));

        return view('checkout.summary', compact('order', 'returnUrl', 'defaultAddress'));
    }

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
            $msgVal = 'Coupon removed.';

            /* -------------------------------------------------------------------------- */
            /*  1. โค้ด chamora — ลดทุกสินค้า 15%                                      */
            /* -------------------------------------------------------------------------- */
            if ($code === 'chamora') {
                $order->discount = round($order->subtotal * 0.15, 2);
                $msgKey = 'coupon_ok';
                $msgVal = 'Coupon CHAMORA applied — 15% discount on all items.';
            }

            elseif (in_array($code, ['kurolove', 'prince10', 'friendship10'])) {

                $eligibleTotal = 0;
                $hasKuromi = false;
                $hasHirono = false;

                //  ตรวจสอบสินค้าทั้งหมดในคำสั่งซื้อ
                foreach ($order->items as $item) {
                    $cat = $item->product->category_id;

                    // หมวดหมู่สินค้า
                    if ($cat === 3) $hasKuromi = true; // Kuromi
                    if ($cat === 4) $hasHirono = true; // Hirono

                    // kurolove → ลดเฉพาะ Kuromi
                    if ($code === 'kurolove' && $cat === 3) {
                        $eligibleTotal += $item->unit_price * $item->qty;
                    }

                    // prince10 → ลดเฉพาะ Hirono
                    if ($code === 'prince10' && $cat === 4) {
                        $eligibleTotal += $item->unit_price * $item->qty;
                    }

                    // friendship10 → ลดเมื่อมีทั้งคู่
                    if ($code === 'friendship10' && in_array($cat, [3, 4])) {
                        $eligibleTotal += $item->unit_price * $item->qty;
                    }
                }

                //  เงื่อนไขพิเศษ: friendship10 ต้องมีทั้งคู่
                if ($code === 'friendship10' && !($hasKuromi && $hasHirono)) {
                    $eligibleTotal = 0; // ไม่มีครบ → ใช้ไม่ได้
                }

                //  ถ้ามีสินค้าที่เข้าเงื่อนไข
                if ($eligibleTotal > 0) {
                    $order->discount = round($eligibleTotal * 0.10, 2);
                    $msgKey = 'coupon_ok';
                    $msgVal = match ($code) {
                        'kurolove'     => 'Coupon KUROLOVE applied — 10% off Kuromi collection.',
                        'prince10'     => 'Coupon PRINCE10 applied — 10% off Hirono collection.',
                        'friendship10' => 'Coupon FRIENDSHIP10 applied — 10% off Kuromi and Hirono collections.',
                    };
                } else {
                    //  ไม่มีสินค้าที่เข้าเงื่อนไข
                    $msgKey = 'coupon_err';
                    $msgVal = match ($code) {
                        'kurolove'     => 'This coupon is valid only for Kuromi collection.',
                        'prince10'     => 'This coupon is valid only for Hirono collection.',
                        'friendship10' => 'This coupon requires both Kuromi and Hirono items in the order.',
                    };
                }
            }

            elseif (!empty($code)) {
                $msgKey = 'coupon_err';
                $msgVal = 'Coupon code not found.';
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

                //  ตรวจสอบ stock ก่อนหัก
                foreach ($order->items as $item) {
                    $p = $item->product;
                    if ($p->stock_qty < $item->qty) {
                        abort(409, "สินค้า {$p->name} คงเหลือไม่พอ");
                    }
                }
                //  หัก stock จริง
                foreach ($order->items as $item) {
                    $item->product->decrement('stock_qty', $item->qty);
                }
                // เมื่อลูกค้าชำระเงินแล้ว ค่อยลบสินค้าที่อยู่ในตะกร้า
                $cart = \App\Models\Cart::where('user_id', $order->user_id)->first();
                if ($cart) {
                    foreach ($order->items as $item) {
                        $cart->cartItems()->where('product_id', $item->product_id)->delete();
                    }
                }

                $order->status = 'pending';
                $order->save();
            });
        }

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

            $order->status  = 'paid';
            $order->paid_at = now();
            $order->save();
            $order->recalc();

            // เคลียร์ session เดิม
            session()->forget("order_return_{$order->id}");

            // ไปหน้า Thank You
            return redirect()->route('checkout.thankyou')
                ->with('flash_ok', 'Payment successful! Your order has been confirmed.');
        }
 
    public function thankyou()
    {
        return view('checkout.thankyou');
    }

    public function updateAddress(Request $request, Order $order)
    {
        // ตรวจสอบสิทธิ์ว่า order เป็นของ user คนนี้
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this order');
        }

        // ตรวจสอบ address ที่ส่งมา
        $data = $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        $address = \App\Models\Address::where('user_id', auth()->id())
            ->where('id', $data['address_id'])
            ->firstOrFail();

        // อัปเดตเฉพาะ order นี้ (ไม่แตะ default)
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
        // ตรวจสอบสิทธิ์ผู้ใช้
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // ยกเลิกได้เฉพาะ order ที่ยัง pending
        if ($order->status !== 'pending') {
            return back()->with('flash_err', 'This order cannot be cancelled.');
        }

        // คืน stock ให้สินค้า
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock_qty', $item->qty);
            }
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index', ['status' => 'pending'])
            ->with('flash_ok', 'Order cancelled successfully.');
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    

    /**
     * ป้องกันการเข้าถึงออเดอร์ของคนอื่น
     * - ถ้า order มี user_id แล้วและไม่ใช่ของเรา -> 403
     * - ถ้า order ยังไม่มี user_id ให้ผูกกับผู้ใช้ปัจจุบัน
     */
    private function ensureOwn(Order $order): void
    {
        $uid = auth()->id();
        if ($order->user_id && $order->user_id !== $uid) {
            abort(403, 'Forbidden');
        }
        if (!$order->user_id) {
            $order->user_id = $uid;
            $order->save();
        }
    }

    public function createFromProduct(Product $product, Request $request)
    {
        $qty = max(1, (int) $request->get('qty', 1));
        $max = (int) $product->stock_qty;

        // ❗ ถ้าเกินสต็อก ให้เตือนและเด้งกลับหน้าสินค้า
        if ($qty > $max) {
            $back = $request->get(
                'return',
                route('products.show', ['key' => $product->id . '-' . Str::slug($product->name)])
            );

            return redirect()->to($back)
                ->with('flash_err', "ขออภัย จำนวนที่ต้องการ ($qty) มากกว่าสินค้าที่เหลือในสต็อก ($max) ชิ้น")
                ->with('suggested_qty', $max);
        }

        // สร้าง order draft
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

    public function summary(Request $request, Order $order)
{
    $this->ensureOwn($order);

    // โหลดสินค้าที่จำเป็น
    $order->load('items.product');

    // ถ้าจำนวนที่สั่งเกิน stock → เด้งกลับหน้ารายละเอียดสินค้านั้น พร้อมแจ้งเตือน
    foreach ($order->items as $it) {
        if ($it->qty > $it->product->stock_qty) {
            $back = route('products.show', [
                'key' => $it->product->id.'-'.Str::slug($it->product->name)
            ]);

            return redirect()->to($back)
                ->with('flash_err', "ตอนนี้สินค้า {$it->product->name} เหลือ {$it->product->stock_qty} ชิ้น")
                ->with('suggested_qty', $it->product->stock_qty);
        }
    }

    // --- จัดการ return URL ---
    // ถ้ามี ?return= มากับ request ให้จำไว้ใน session (ครั้งแรกที่เข้าหน้านี้)
    if ($request->filled('return')) {
        session(['return_to' => $request->query('return')]);
    }

    // สร้าง $fallback เป็นหน้าสินค้าตัวแรกในออเดอร์ หากไม่มี ให้ใช้หน้าแรก
    $fallback = $order->items->first()
        ? route('products.show', [
            'key' => $order->items->first()->product->id.'-'.Str::slug($order->items->first()->product->name)
          ])
        : url('/');

    // ลำดับความสำคัญ: query → session → fallback
    $returnUrl = $request->query('return') ?? session('return_to') ?? $fallback;

    return view('checkout.summary', compact('order', 'returnUrl'));
}

    public function update(Order $order, Request $req)
    {
        $this->ensureOwn($order);

        // กรอกที่อยู่ → คูปองเป็น "ไม่บังคับ"
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

    /**
     * APPLY เฉพาะคูปอง (ไม่ต้องกรอกที่อยู่)
     */
    public function applyCoupon(Order $order, Request $req)
    {
        $this->ensureOwn($order);

        // 1) ถ้ามีฟิลด์ที่อยู่มากับคูปอง → เก็บใส่ order ไว้เป็นร่าง
        $addressKeys = [
            'recipient_name','phone','address_line1','address_line2',
            'district','province','postcode','country','shipping_fee'
        ];
        $draft = $req->only($addressKeys);
        if (!empty(array_filter($draft))) {
            $order->fill($draft);
        }

        // 2) ประมวลผลคูปอง
        $code = strtolower(trim($req->input('coupon_code', '')));
        $order->coupon_code = $code ?: null;
        $order->discount    = 0;
        if ($code === 'chamora') {
            $order->discount = round($order->subtotal * 0.15, 2);
            $msgKey = 'coupon_ok';
            $msgVal = 'ใช้คูปองสำเร็จ — ลด 15% ของค่าสินค้า';
        } else {
            $msgKey = 'coupon_info';
            $msgVal = 'นำคูปองออกแล้ว';
        }

        $order->recalc();
        $order->save();

        // 3) กลับหน้าเดิม + flash input ทั้งหมดกลับไป
        return back()->with($msgKey, $msgVal)->withInput();
    }

    public function payment(Order $order)
    {
        $this->ensureOwn($order);

        if ($order->status === 'draft') {
            $order->status = 'pending_payment';
            $order->save();
        }

        $order->load('items.product');

        // ✅ แก้ param ให้ตรงกับ route('products.show') => ใช้ 'key'
        $returnUrl = session("order_return_{$order->id}")
            ?? ( $order->items->first()
                    ? route('products.show', [
                        'key' => $order->items->first()->product->id . '-' . Str::slug($order->items->first()->product->name)
                      ])
                    : url('/') );

        return view('checkout.payment', compact('order','returnUrl'));
    }

    public function confirm(Request $request, Order $order)
    {
        $this->ensureOwn($order);

        if ($order->status === 'paid') {
            return redirect()->route('checkout.thankyou');
        }

        DB::transaction(function () use ($order) {
            $order->load('items.product');

            foreach ($order->items as $item) {
                $p = $item->product;
                if ($p->stock_qty < $item->qty) {
                    abort(409, "สินค้า {$p->name} คงเหลือไม่พอ");
                }
            }
            foreach ($order->items as $item) {
                $item->product->decrement('stock_qty', $item->qty);
            }

            $order->user_id = $order->user_id ?: auth()->id();
            $order->status  = 'paid';
            $order->paid_at = now();
            $order->save();
            $order->recalc();

            session()->forget("order_return_{$order->id}");
        });

        return redirect()->route('checkout.thankyou');
    }

    public function thankyou()
    {
        return view('checkout.thankyou');
    }
}
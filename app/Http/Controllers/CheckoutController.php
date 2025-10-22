<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
   public function createFromProduct(Product $product, Request $request)
{
    $qty = max(1, (int) $request->get('qty', 1));
    $max = (int) $product->stock_qty;

    // ❗ ถ้าเกินสต็อก ให้เตือนและเด้งกลับหน้าสินค้า
    if ($qty > $max) {
        $back = $request->get(
            'return',
            // กรณีไม่มี return parameter
            route('products.show', ['key' => $product->id . '-' . \Illuminate\Support\Str::slug($product->name)])
        );

        return redirect()->to($back)
            ->with('flash_err', "ขออภัย จำนวนที่ต้องการ ($qty) มากกว่าสินค้าที่เหลือในสต็อก ($max) ชิ้น")
            ->with('suggested_qty', $max);
    }

    // … ของเดิมต่อ
    $order = Order::create([
        'user_id' => auth()->id(),
        'status' => 'draft',
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
    $order->load('items.product');

    foreach ($order->items as $it) {
        if ($it->qty > $it->product->stock_qty) {
            // เด้งกลับหน้าสินค้าตัวแรกพร้อมเตือน
            $back = route('products.show', ['key' => $it->product->id . '-' . \Illuminate\Support\Str::slug($it->product->name)]);
            return redirect()->to($back)
                ->with('flash_err', "ตอนนี้สินค้า {$it->product->name} เหลือ {$it->product->stock_qty} ชิ้น")
                ->with('suggested_qty', $it->product->stock_qty);
        }
    }

     $returnUrl =
        session("order_return_{$order->id}") ?:
        url()->previous() ?:
        ($order->items->first()
            ? route('products.show', [
                'key' => $order->items->first()->product->id.'-'.\Illuminate\Support\Str::slug($order->items->first()->product->name)
              ])
            : url('/'));

    return view('checkout.summary', compact('order','returnUrl'));
}


   public function update(Order $order, Request $req)
{
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
        // คูปองไม่บังคับ (จะมาก็ได้ ไม่มาก็ได้)
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
 * กดปุ่ม APPLY เฉพาะคูปอง (ไม่ต้องกรอกที่อยู่)
 */
public function applyCoupon(Order $order, Request $req)
{
    // 1) ถ้า request มีฟิลด์ที่อยู่มากับคูปอง → เก็บใส่ order ไว้เป็นร่าง (ไม่จ่ายเงิน)
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
        if ($order->status === 'draft') {
            $order->status = 'pending_payment';
            $order->save();
        }

        $order->load('items.product');

        $returnUrl = session("order_return_{$order->id}")
            ?? ( $order->items->first()
                 ? route('products.show', ['idSlug' => $order->items->first()->product->route_key_composite])
                 : url('/') );

        return view('checkout.payment', compact('order','returnUrl'));
    }

    public function confirm(Request $request, Order $order)
    {
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

            $order->status = 'paid';
            $order->paid_at = now();
            $order->save();

            session()->forget("order_return_{$order->id}");
        });

        return redirect()->route('checkout.thankyou');
    }

    public function thankyou()
    {
        return view('checkout.thankyou');
    }
}
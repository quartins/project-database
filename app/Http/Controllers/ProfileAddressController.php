<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ProfileAddressController extends Controller
{
    public function edit()
    {
        $userId = auth()->id();

        // ใช้ลำดับความสำคัญ:
        // 1) ออเดอร์ที่ยังไม่จ่าย (draft/pending_payment) ล่าสุด
        // 2) ถ้าไม่มี ให้ fallback ไปออเดอร์ที่จ่ายแล้วล่าสุด (paid)
        $draftOrPending = Order::where('user_id', $userId)
            ->whereIn('status', ['draft','pending_payment'])
            ->latest('updated_at')
            ->first();

        $paidLatest = Order::where('user_id', $userId)
            ->where('status', 'paid')
            ->latest('updated_at')
            ->first();

        $source = $draftOrPending ?: $paidLatest;

        $form = [
            'recipient_name' => old('recipient_name', $source?->recipient_name),
            'phone'          => old('phone',          $source?->phone),
            'address_line1'  => old('address_line1',  $source?->address_line1),
            'address_line2'  => old('address_line2',  $source?->address_line2),
            'district'       => old('district',       $source?->district),
            'province'       => old('province',       $source?->province),
            'postcode'       => old('postcode',       $source?->postcode),
            'country'        => old('country',        $source?->country),
        ];

        return view('profile.address', compact('form'));
    }

    public function update(Request $request)
    {
        $userId = auth()->id();

        $data = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'nullable|string|max:30',
            'address_line1'  => 'required|string|max:255',
            'address_line2'  => 'nullable|string|max:255',
            'district'       => 'nullable|string|max:100',
            'province'       => 'nullable|string|max:100',
            'postcode'       => 'nullable|string|max:10',
            'country'        => 'nullable|string|max:100',
        ]);

        // หาออเดอร์ที่ปลอดภัยให้แก้ไข:
        // - เอา draft/pending ล่าสุดมาก่อน
        // - ถ้าไม่มี ให้ "สร้าง" draft ใหม่เพื่อเก็บที่อยู่
        $order = Order::where('user_id', $userId)
            ->whereIn('status', ['draft','pending_payment'])
            ->latest('updated_at')
            ->first();

        if (!$order) {
            $order = Order::create([
                'user_id'      => $userId,
                'status'       => 'draft',
                'shipping_fee' => 35.00,
            ]);
        }

        $order->fill($data)->save();

        return back()->with('ok', 'บันทึกที่อยู่เรียบร้อยแล้ว (บันทึกไว้กับคำสั่งซื้อล่าสุดของคุณ)');
    }
}

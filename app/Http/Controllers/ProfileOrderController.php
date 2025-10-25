<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ProfileOrderController extends Controller
{
    public function index(Request $request)
    {
        // ✅ รับพารามิเตอร์ status จาก URL เช่น /orders?status=paid
        $status = $request->get('status', 'pending'); // default คือ pending

        // ✅ Query ออเดอร์เฉพาะของ user ที่ล็อกอิน
        $query = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->latest();

        // ✅ กรองตามสถานะ (รองรับ cancelled ด้วย)
        if (in_array($status, ['pending', 'paid', 'cancelled'])) {
            $query->where('status', $status);
        }

        // ✅ ดึงข้อมูล (แบ่งหน้า)
        $orders = $query->paginate(10);

        // ✅ ส่งไป view
        return view('profile.orders', compact('orders', 'status'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;

class ProfileOrderController extends Controller
{
    public function index()
    {
        // ดึงเฉพาะออเดอร์ของ user ที่ล็อกอิน
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('profile.orders', compact('orders'));
    }
}

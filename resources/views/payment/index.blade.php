@extends('layouts.app')

@section('content')
<div class="bg-white py-12">

    {{-- 
        ============================================================
        ⬇️ 1. สร้างกล่องใหญ่ (max-w-7xl) ขึ้นมาครอบ Heading
           เพื่อให้ "Payment" ชิดซ้ายตามแนวเดียวกับ Navbar
        ============================================================
    --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-serif font-bold text-gray-800 mb-2">Payment</h1>
        <hr class="border-gray-300 mb-8">
    </div>

    {{-- 
        ============================================================
        ⬇️ 2. กล่องเล็ก (max-w-md) จะเหลือไว้ครอบแค่ Form
           (ลบ H1 และ HR ออกจากตรงนี้)
        ============================================================
    --}}
    <div class="container mx-auto max-w-md px-4">

        <form action="{{ route('payment.confirm') }}" method="POST">
            @csrf
            
            <div class="p-6 flex flex-col items-center text-center">
                
                <img src="{{ asset('images/qr_payment.png') }}" alt="Payment QR Code" class="w-64 h-64 border-2 border-black p-2 rounded-lg">

                <p class="text-2xl font-bold text-gray-800 mt-4">
                    ฿ 535.0 
                </p>

                <p class="text-sm text-gray-600 mt-4">
                  " Please complete your payment within 10 minutes <br>
                    and press 'Confirm Payment' after you've paid. "
                </p>

                <button type="submit" 
                        class="mt-6 w-full max-w-xs bg-gradient-to-r from-[#7B4B3A] to-[#A17E6E] text-white 
                               font-bold text-lg py-3 px-6 rounded-full shadow-lg
                               hover:opacity-90 transition duration-300 ease-in-out
                               focus:outline-none focus:ring-2 focus:ring-[#7B4B3A] focus:ring-opacity-50">
                    Confirm Payment
                </button>
                
            </div>
        </form>

    </div>
</div>
@endsection
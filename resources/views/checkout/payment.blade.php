@extends('layouts.app')

@section('content')
<div class="bg-white py-12">

    {{-- Header ชิดซ้ายตามแนว Navbar (สไตล์เพื่อน) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h1 class="text-4xl font-serif font-bold text-gray-800 mb-2">Payment</h1>

            {{-- ลิงก์กลับหน้าเดิมของเธอ --}}
            @isset($returnUrl)
          <a href="{{ route('checkout.summary', $order) }}"
   class="text-[#5a362e] underline hover:opacity-80">
  ← กลับไปหน้า Order Summary
</a>
          @endisset
        </div>
        <hr class="border-gray-300 mb-8">
    </div>

    {{-- กล่อง form แบบเพื่อน --}}
    <div class="container mx-auto max-w-md px-4">
        <form action="{{ route('checkout.confirm', $order) }}" method="POST">
            @csrf

            <div class="p-6 flex flex-col items-center text-center">
                @php
                    $qrNew = asset('images/qr_payment.png'); // ของเพื่อน
                    $qrOld = asset('images/qr.png');         // ของเก่า (สำรอง)
                @endphp

                <img src="{{ $qrNew }}"
                     alt="Payment QR Code"
                     class="w-64 h-64 border-2 border-black p-2 rounded-lg object-contain"
                     onerror="this.onerror=null;this.src='{{ $qrOld }}'">

                {{-- ใช้ยอดจริงจาก order เดิม --}}
                <p class="text-2xl font-bold text-gray-800 mt-4">
                    ฿ {{ number_format($order->total, 2) }}
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

                <p class="text-center text-xs text-gray-500 mt-4">
                    * Demo only — กด Confirm Payment เพื่อจบออเดอร์ *
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
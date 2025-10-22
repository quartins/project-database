@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-3xl font-semibold">Payment</h2>
    <a href="{{ $returnUrl }}" class="text-[#5a362e] underline hover:opacity-80">← กลับไปหน้า Detail</a>
  </div>

  <div class="flex flex-col items-center gap-6">
    <div class="bg-white p-6 rounded-xl shadow">
      <img src="{{ asset('images/qr.png') }}" class="w-64 h-64 object-contain mx-auto" alt="QR">
      <div class="text-center mt-3">฿ {{ number_format($order->total,2) }}</div>
    </div>

    <p class="text-center text-sm text-gray-600">* Demo only — กด Confirm Payment เพื่อจบออเดอร์ *</p>

    <form method="POST" action="{{ route('checkout.confirm',$order) }}">
      @csrf
      <button class="bg-green-600 hover:bg-green-700 text-white px-8 py-2 rounded-lg shadow">Confirm Payment</button>
    </form>
  </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">

  {{--  Back button (history) --}}
  <button onclick="history.back()" 
          class="flex items-center text-[#5a362e] hover:text-[#8B5E45] mb-6 transition">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
         stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-1">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
    </svg>
    <span class="text-sm font-medium">Back</span>
  </button>

  {{--  Title --}}
  <h2 class="text-3xl font-bold text-center text-[#3b2c28] mb-2">Payment</h2>
  <div class="w-24 h-[2px] bg-[#8B5E45] mx-auto mb-10"></div>

  {{--  QR Section --}}
  <div class="flex flex-col items-center gap-6">
    <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm hover:shadow-md transition">
      <img src="{{ asset('images/qr.png') }}" 
           alt="QR Payment"
           class="w-64 h-64 object-contain mx-auto rounded-xl">
      <div class="text-center text-lg font-semibold text-[#3b2c28] mt-3">
        ฿ {{ number_format($order->total, 2) }}
      </div>
    </div>

    {{--  Instruction --}}
    <p class="text-center text-sm text-gray-600 leading-relaxed">
      Please complete your payment within <span class="font-medium text-[#8B5E45]">10 minutes</span><br>
      and press <strong>“Confirm Payment”</strong> after you’ve made your payment.
    </p>

    {{--  Confirm button --}}
    <form method="POST" action="{{ route('checkout.confirm', $order) }}">
      @csrf
      <button type="submit"
              class="mt-2 bg-[#5a362e] hover:bg-[#8B5E45] text-white px-10 py-3 rounded-xl font-semibold 
                     shadow-md hover:shadow-lg transition">
        Confirm Payment
      </button>
    </form>
  </div>
</div>
@endsection

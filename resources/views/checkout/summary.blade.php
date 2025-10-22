{{-- resources/views/checkout/summary.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="grid lg:grid-cols-3 gap-8">

  {{-- LEFT: Address + Coupon (แยกฟอร์ม ไม่ซ้อนกัน) --}}
  <div class="lg:col-span-2 space-y-6">

    <div class="flex items-center justify-between">
      <h2 class="text-3xl font-semibold">Order Summary</h2>
      <a href="{{ $returnUrl }}" class="text-[#5a362e] underline hover:opacity-80">
        ← กลับไปหน้า Detail
      </a>
    </div>

    {{-- แจ้งเตือนจากฝั่ง server (เช่น stock ไม่พอ) --}}
    @if(session('flash_err'))
      <div class="p-3 rounded-lg bg-rose-50 text-rose-700 border border-rose-200">
        {{ session('flash_err') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="p-3 rounded-lg bg-rose-50 text-rose-700 border border-rose-200">
        กรุณาตรวจสอบข้อมูลให้ครบถ้วน
      </div>
    @endif

    {{-- ========== ฟอร์มที่อยู่ (ฟอร์มหลัก) ========== --}}
    <form id="addressForm" class="bg-white rounded-2xl shadow p-6 space-y-5"
          action="{{ route('checkout.update',$order) }}" method="POST">
      @csrf
      <div class="text-lg font-semibold mb-1">Shipping Address</div>
      <p class="text-sm text-gray-500 -mt-2">กรอกแค่ช่องที่มี * ก็เพียงพอ (เหมือนเว็บใหญ่ ๆ)</p>

      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm text-gray-600 mb-1">Full name *</label>
          <input name="recipient_name" class="input" autocomplete="name"
                 value="{{ old('recipient_name', $order->recipient_name) }}" required>
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Phone</label>
          <input name="phone" class="input" autocomplete="tel"
                 value="{{ old('phone', $order->phone) }}">
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm text-gray-600 mb-1">Address line 1 *</label>
          <input name="address_line1" class="input" autocomplete="address-line1"
                 value="{{ old('address_line1', $order->address_line1) }}" required>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm text-gray-600 mb-1">Address line 2</label>
          <input name="address_line2" class="input" autocomplete="address-line2"
                 value="{{ old('address_line2', $order->address_line2) }}">
        </div>

        <div>
          <label class="block text-sm text-gray-600 mb-1">District</label>
          <input name="district" class="input" autocomplete="address-level2"
                 value="{{ old('district', $order->district) }}">
        </div>

        <div>
          <label class="block text-sm text-gray-600 mb-1">Province</label>
          <input name="province" class="input" autocomplete="address-level1"
                 value="{{ old('province', $order->province) }}">
        </div>

        <div>
          <label class="block text-sm text-gray-600 mb-1">Postcode</label>
          <input name="postcode" class="input" inputmode="numeric" pattern="[0-9]*"
                 autocomplete="postal-code" value="{{ old('postcode', $order->postcode) }}">
        </div>

        <div>
          <label class="block text-sm text-gray-600 mb-1">Country</label>
          <input name="country" class="input" autocomplete="country-name"
                 value="{{ old('country', $order->country ?? 'Thailand') }}">
        </div>
      </div>

      {{-- Delivery --}}
      <div class="mt-4 bg-gradient-to-r from-rose-50 to-pink-50 rounded-xl p-4 border border-pink-100">
        <div class="flex items-center gap-2">
          <input type="hidden" name="shipping_fee" value="35.00">
          <span class="px-4 py-2 rounded border bg-white">Express</span>
          <span class="ml-auto text-sm text-gray-700">฿ 35.00</span>
        </div>
      </div>
    </form>

    {{-- ========== ฟอร์มคูปอง (ฟอร์มแยก) ========== --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
      <div class="flex items-center justify-between mb-3">
        <div class="text-lg font-semibold">COUPON (optional)</div>
        @if($order->discount > 0)
          <span class="text-green-700 text-sm">ใช้คูปองแล้ว ✔︎</span>
        @endif
      </div>

      {{-- Alerts --}}
      @if(session('coupon_ok'))
        <div class="p-3 rounded-lg bg-green-50 text-green-700 border border-green-200 mb-3">
          {{ session('coupon_ok') }}
        </div>
      @endif
      @if(session('coupon_err'))
        <div class="p-3 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 mb-3">
          {{ session('coupon_err') }}
        </div>
      @endif
      @if(session('coupon_info'))
        <div class="p-3 rounded-lg bg-blue-50 text-blue-700 border border-blue-200 mb-3">
          {{ session('coupon_info') }}
        </div>
      @endif

      <form id="couponForm" class="flex gap-3" method="POST" action="{{ route('checkout.applyCoupon',$order) }}">
        @csrf
        <input name="coupon_code" class="input flex-1" autocomplete="one-time-code"
               placeholder="Enter code (e.g., chamora)"
               value="{{ old('coupon_code', $order->coupon_code) }}">
        <button type="submit"
                class="px-6 rounded-lg text-white font-semibold bg-[#5a362e] hover:opacity-90">
          APPLY
        </button>
      </form>
      <p class="text-sm text-gray-500 mt-2">ไม่ใส่ก็ได้ — ใช้โค้ด <b>chamora</b> ลด 15% ของค่าสินค้า</p>
    </div>

  </div>

  {{-- RIGHT: Sticky Order Summary + ปุ่มไปหน้าชำระเงิน (ส่งฟอร์มที่อยู่) --}}
  <aside class="bg-white rounded-2xl shadow p-5 h-fit lg:sticky lg:top-6">
    <div class="text-xl font-semibold mb-3">Order Summary</div>

    <div class="space-y-2 text-sm">
      <div class="flex justify-between"><span>Subtotal</span><span>฿ {{ number_format($order->subtotal,2) }}</span></div>
      <div class="flex justify-between"><span>Shipping</span><span>฿ {{ number_format($order->shipping_fee,2) }}</span></div>
      <div class="flex justify-between"><span>Discount</span><span>- ฿ {{ number_format($order->discount,2) }}</span></div>
      <hr>
      <div class="flex justify-between font-semibold text-lg">
        <span>Total</span><span>฿ {{ number_format($order->total,2) }} <span class="text-xs">THB</span></span>
      </div>
    </div>

    <div class="mt-4 text-sm">
      <div class="font-semibold mb-2">Your Order {{ $order->items->count() }} item</div>
      @foreach($order->items as $it)
        <div class="flex items-center gap-3 text-sm py-2 border-b last:border-0">
          <img class="w-14 h-14 object-contain rounded" src="{{ asset($it->product->image_url) }}">
          <div class="flex-1">
            <div>{{ $it->product->name }}</div>
            <div class="text-gray-500">฿ {{ number_format($it->unit_price,0) }}</div>
          </div>
          <div class="text-gray-500">QTY: {{ $it->qty }}</div>
        </div>
      @endforeach
    </div>

    {{-- ปุ่มเดียว ส่งฟอร์มที่อยู่ (addressForm) --}}
    <button form="addressForm"
            class="mt-5 w-full bg-gradient-to-r from-pink-500 to-rose-500 text-white py-3 rounded-xl shadow
                   hover:shadow-md hover:scale-[1.01] transition">
      ไปหน้าชำระเงิน
    </button>
  </aside>
</div>

<style>
  .input{ @apply w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300; }
</style>

{{-- คัดลอกค่าจากฟอร์มที่อยู่ไปฟอร์มคูปอง ก่อน submit เพื่อให้ค่าไม่หาย --}}
<script>
  document.getElementById('couponForm').addEventListener('submit', function () {
    const src = document.getElementById('addressForm').elements;
    for (const el of src) {
      if (!el.name) continue;
      let h = this.querySelector('input[type="hidden"][name="'+el.name+'"]');
      if (!h) {
        h = document.createElement('input');
        h.type = 'hidden';
        h.name = el.name;
        this.appendChild(h);
      }
      h.value = el.value;
    }
  });
</script>
@endsection

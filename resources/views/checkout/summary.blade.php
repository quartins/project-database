{{-- resources/views/checkout/summary.blade.php --}}
@extends('layouts.app')

@section('content')
@php
  // ดึงลิงก์ย้อนกลับแบบปลอดภัย: มาก่อนคือ ?return=, ถ้าไม่มีลอง session, สุดท้าย fallback = หน้าสินค้าตัวแรกในออเดอร์
  $returnUrl = request('return')
    ?? session('return_to')
    ?? optional($order->items->first())->product
          ? route('products.show', $order->items->first()->product->id.'-'.\Illuminate\Support\Str::slug($order->items->first()->product->name))
          : url()->previous();
@endphp

<div class="grid lg:grid-cols-3 gap-8">

  {{-- LEFT: Address + Coupon --}}
  <div class="lg:col-span-2 space-y-6">

    <div class="flex items-center justify-between mb-4">
  {{-- หัวข้อสไตล์การ์ตูน --}}
  <div class="relative">
    <h2 class="text-3xl font-bold text-[#5a362e] pl-5 pr-6 py-2 inline-block
               bg-white rounded-[1.25rem] shadow-sm
               border-4 border-pink-300"
        style="box-shadow:
          4px 4px 0 #fda4af,    /* เงาเหมือนสติ๊กเกอร์ */
          inset 0 0 0 6px #ffe4e6; /* ขอบด้านในสีอ่อน */
        ">
      Order Summary
    </h2>

    {{-- ริบบิ้นตกแต่งซ้ายขวา --}}
    <span class="absolute -left-3 -top-3 w-6 h-6 rounded-full bg-pink-300"></span>
    <span class="absolute -right-3 -bottom-3 w-6 h-6 rounded-full bg-amber-200"></span>
  </div>

  {{-- ลิงก์ย้อนกลับ --}}
  <a href="{{ $returnUrl }}" class="text-[#5a362e] underline hover:opacity-80">
    ← กลับไปหน้า Detail
  </a>
</div>


    {{-- alerts --}}
    @if(session('flash_err'))
      <div class="p-3 rounded-xl bg-rose-50 text-rose-700 border border-rose-200">
        {{ session('flash_err') }}
      </div>
    @endif
    @if ($errors->any())
      <div class="p-3 rounded-xl bg-rose-50 text-rose-700 border border-rose-200">
        กรุณาตรวจสอบข้อมูลให้ครบถ้วน
      </div>
    @endif

   @auth
  {{-- ปุ่มเลือกใช้ที่อยู่จากโปรไฟล์ / ล้างฟอร์ม --}}
  <div class="flex items-center gap-3 mb-2">
    <button type="button" id="applySaved"
      class="px-3 py-1.5 rounded-lg text-white bg-[#5a362e] hover:opacity-90">
      ใช้ที่อยู่ในโปรไฟล์
    </button>
    <button type="button" id="clearAddr"
      class="px-3 py-1.5 rounded-lg border border-pink-300">
      ล้างฟอร์ม
    </button>
  </div>

  @php
    $u = auth()->user();
    $saved = [
      'recipient_name' => $u->recipient_name ?? '',
      'phone'          => $u->phone ?? '',
      'address_line1'  => $u->address_line1 ?? '',
      'address_line2'  => $u->address_line2 ?? '',
      'district'       => $u->district ?? '',
      'province'       => $u->province ?? '',
      'postcode'       => $u->postcode ?? '',
      'country'        => $u->country ?? '',
    ];
  @endphp

  <script>
    const savedAddr = @json($saved);

    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('addressForm');

      document.getElementById('applySaved')?.addEventListener('click', () => {
        Object.entries(savedAddr).forEach(([k, v]) => {
          const el = form?.querySelector(`[name="${k}"]`);
          if (el) el.value = v ?? '';
        });
      });

      document.getElementById('clearAddr')?.addEventListener('click', () => {
        form?.reset();
      });
    });
  </script>
@endauth


    {{-- ========== ฟอร์มที่อยู่ ========== --}}
    <form id="addressForm"
          action="{{ route('checkout.update',$order) }}"
          method="POST"
          class="rounded-2xl p-6 border-2 border-transparent bg-white
                 [background:linear-gradient(#fff,#fff),linear-gradient(90deg,#fbcfe8,#fecaca)]
                 bg-origin-padding bg-clip-padding bg-clip-border shadow-md">
      @csrf
      <div class="text-lg font-semibold mb-1 text-[#5a362e]">Shipping Address</div>

      <div class="grid md:grid-cols-2 gap-4 mt-3">
        <div>
          <label class="block text-sm text-gray-600 mb-1">Full name *</label>
          <input name="recipient_name" required autocomplete="name"
                 value="{{ old('recipient_name', $order->recipient_name) }}"
                 class="ch-input">
        </div>
        <div>
          <label class="block text-sm text-gray-600 mb-1">Phone</label>
          <input name="phone" autocomplete="tel"
                 value="{{ old('phone', $order->phone) }}"
                 class="ch-input">
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm text-gray-600 mb-1">Address line 1 *</label>
          <input name="address_line1" required autocomplete="address-line1"
                 value="{{ old('address_line1', $order->address_line1) }}"
                 class="ch-input">
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm text-gray-600 mb-1">Address line 2</label>
          <input name="address_line2" autocomplete="address-line2"
                 value="{{ old('address_line2', $order->address_line2) }}"
                 class="ch-input">
        </div>

        <div>
          <label class="block text-sm text-gray-600 mb-1">District</label>
          <input name="district" autocomplete="address-level2"
                 value="{{ old('district', $order->district) }}"
                 class="ch-input">
        </div>

        <div>
          <label class="block text-sm text-gray-600 mb-1">Province</label>
          <input name="province" autocomplete="address-level1"
                 value="{{ old('province', $order->province) }}"
                 class="ch-input">
        </div>

        <div>
          <label class="block text-sm text-gray-600 mb-1">Postcode</label>
          <input name="postcode" inputmode="numeric" pattern="[0-9]*" autocomplete="postal-code"
                 value="{{ old('postcode', $order->postcode) }}"
                 class="ch-input">
        </div>

        <div>
          <label class="block text-sm text-gray-600 mb-1">Country</label>
          {{-- ไม่ fix Thailand อีกต่อไป --}}
          <input name="country" autocomplete="country-name" placeholder="Country"
                 value="{{ old('country', $order->country) }}"
                 class="ch-input">
        </div>
      </div>

      {{-- Delivery --}}
      <div class="mt-5 rounded-xl p-4 border border-pink-100 bg-gradient-to-r from-rose-50 to-pink-50">
        <div class="flex items-center gap-2">
          <input type="hidden" name="shipping_fee" value="35.00">
          <span class="px-4 py-2 rounded border bg-white">Express</span>
          <span class="ml-auto text-sm text-gray-700">฿ 35.00</span>
        </div>
      </div>
    </form>

    {{-- ========== ฟอร์มคูปอง ========== --}}
    <div class="rounded-2xl p-4 border-2 border-transparent bg-white
                [background:linear-gradient(#fff,#fff),linear-gradient(90deg,#fde68a,#fbcfe8)]
                bg-origin-padding bg-clip-padding bg-clip-border shadow">
      <div class="flex items-center justify-between mb-3">
        <div class="text-lg font-semibold text-[#5a362e]">COUPON (optional)</div>
        @if($order->discount > 0)
          <span class="text-green-700 text-sm">ใช้คูปองแล้ว ✔︎</span>
        @endif
      </div>

      @if(session('coupon_ok'))
        <div class="p-3 rounded-xl bg-green-50 text-green-700 border border-green-200 mb-3">
          {{ session('coupon_ok') }}
        </div>
      @endif
      @if(session('coupon_err'))
        <div class="p-3 rounded-xl bg-rose-50 text-rose-700 border border-rose-200 mb-3">
          {{ session('coupon_err') }}
        </div>
      @endif
      @if(session('coupon_info'))
        <div class="p-3 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 mb-3">
          {{ session('coupon_info') }}
        </div>
      @endif

      <form id="couponForm" method="POST" action="{{ route('checkout.applyCoupon',$order) }}" class="flex gap-3">
        @csrf
        {{-- เอาตัวอย่างออก เหลือคำกลาง ๆ --}}
        <input name="coupon_code" class="ch-input flex-1" placeholder="Enter code"
               value="{{ old('coupon_code', $order->coupon_code) }}">
        <button type="submit"
                class="px-6 rounded-lg text-white font-semibold bg-[#5a362e] hover:opacity-90">
          APPLY
        </button>
      </form>
    </div>

  </div>

  {{-- RIGHT: Order summary สไตล์มีสี --}}
  <aside class="h-fit lg:sticky lg:top-6 rounded-2xl p-0 shadow">
    <div class="rounded-2xl p-1 bg-gradient-to-r from-pink-300 via-rose-300 to-amber-200">
      <div class="bg-white rounded-xl p-5">
        <div class="text-xl font-semibold text-[#5a362e] mb-3">Order Summary</div>

        <div class="space-y-2 text-sm">
          <div class="flex justify-between"><span>Subtotal</span><span>฿ {{ number_format($order->subtotal,2) }}</span></div>
          <div class="flex justify-between"><span>Shipping</span><span>฿ {{ number_format($order->shipping_fee,2) }}</span></div>
          <div class="flex justify-between"><span>Discount</span><span>- ฿ {{ number_format($order->discount,2) }}</span></div>
          <hr>
          <div class="flex justify-between font-semibold text-lg">
            <span>Total</span>
            <span>฿ {{ number_format($order->total,2) }} <span class="text-xs">THB</span></span>
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

        <button form="addressForm"
                class="mt-5 w-full bg-gradient-to-r from-pink-500 to-rose-500 text-white py-3 rounded-xl shadow
                       hover:shadow-md hover:scale-[1.01] transition">
          ไปหน้าชำระเงิน
        </button>
      </div>
    </div>
  </aside>
</div>

{{-- สไตล์ input ให้เข้าชุด --}}
<style>
  .ch-input{
    @apply w-full rounded-xl border border-pink-200/80 bg-white/90 px-3 py-2
           focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-300 transition;
  }
</style>

{{-- คัดลอกค่าจากฟอร์มที่อยู่ไปฟอร์มคูปอง ก่อน submit เพื่อให้ค่าไม่หาย --}}
<script>
  document.getElementById('couponForm')?.addEventListener('submit', function () {
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

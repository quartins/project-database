@extends('layouts.app')

@section('content')
<div x-data="addressModal()" class="max-w-6xl mx-auto grid lg:grid-cols-3 gap-8 py-10 px-6 relative">

  {{-- LEFT CONTENT --}}
  <div class="lg:col-span-2 space-y-6">

    {{-- 🧾 TITLE --}}
    <div class="flex items-center gap-2 mt-6">
      <button onclick="history.back()" 
              class="flex items-center text-[#4B3B34] hover:text-[#8B5E45] transition">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
             class="w-6 h-6 mr-1">
          <path stroke-linecap="round" stroke-linejoin="round" 
                d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
      </button>
      <h2 class="text-3xl font-bold text-[#3A2A23]">Order Summary</h2>
    </div>

    {{-- 📦 Address --}}
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
      <div class="flex justify-between items-center mb-2">
        <h3 class="font-semibold text-lg text-gray-800">Address Book :</h3>
        <a href="javascript:void(0)" @click="openModal()" class="text-sm text-[#6B3E2E] hover:underline">Edit</a>
      </div>

      @if($order->shippingAddress)
        <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
          <p class="text-sm text-gray-800 font-semibold">
            {{ $order->shippingAddress->recipient_name }}
            {{ $order->shippingAddress->phone ? '(' . substr_replace($order->shippingAddress->phone, '*****', 2, 5) . ')' : '' }}
          </p>
          <p class="text-sm text-gray-600 mt-1">
            {{ $order->shippingAddress->address_line1 }},
            {{ $order->shippingAddress->district }},
            {{ $order->shippingAddress->province }},
            {{ $order->shippingAddress->postcode }}
          </p>
        </div>
      @elseif($defaultAddress)
        <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
          <p class="text-sm text-gray-800 font-semibold">
            {{ $defaultAddress->recipient_name }}
            {{ $defaultAddress->phone ? '(' . substr_replace($defaultAddress->phone, '*****', 2, 5) . ')' : '' }}
          </p>
          <p class="text-sm text-gray-600 mt-1">
            {{ $defaultAddress->address_line1 }},
            {{ $defaultAddress->district }},
            {{ $defaultAddress->province }},
            {{ $defaultAddress->postcode }}
          </p>
        </div>
      @else
        <p class="text-gray-500 text-sm italic">
          No address yet. 
          <a href="javascript:void(0)" @click="openModal()" class="text-[#6B3E2E] underline">Add Address</a>
        </p>
      @endif
    </div>

    {{-- 🚚 Delivery --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
      <h3 class="font-semibold mb-2 text-gray-800">Delivery :</h3>
      <div class="border border-gray-300 rounded-lg p-3 flex justify-between items-center bg-gray-50">
        <span>Express</span>
        <span>฿ {{ number_format($order->shipping_fee ?? 35, 2) }}</span>
      </div>
    </div>

    {{-- 🎟 Coupon --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
      <h3 class="font-semibold mb-2 text-gray-800">COUPON :</h3>

      @if(session('coupon_ok'))
        <p class="p-2 mb-2 rounded text-green-700 bg-green-50 border border-green-200">{{ session('coupon_ok') }}</p>
      @endif
      @if(session('coupon_err'))
        <p class="p-2 mb-2 rounded text-rose-700 bg-rose-50 border border-rose-200">{{ session('coupon_err') }}</p>
      @endif

      <form method="POST" action="{{ route('checkout.applyCoupon', $order) }}" class="flex gap-2">
        @csrf
        <input name="coupon_code"
               value="{{ old('coupon_code', $order->coupon_code) }}"
               placeholder="Please enter the coupon code"
               class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-pink-300 text-sm">
        <button type="submit"
                class="bg-[#6B3E2E] hover:bg-[#8B5E45] text-white px-6 rounded-lg font-semibold text-sm transition">
          APPLY
        </button>
      </form>
      <p class="text-xs text-gray-500 mt-2">Use code <b>chamora</b> to get 15% off your product total.</p>
    </div>
  </div>

  {{-- RIGHT SUMMARY --}}
  <aside class="bg-white rounded-2xl shadow p-6 h-fit lg:sticky lg:top-8">
    <h3 class="text-xl font-bold mb-4 text-gray-800">Order Summary</h3>
    <div class="space-y-2 text-sm">
      <div class="flex justify-between"><span>Subtotal</span><span>฿ {{ number_format($order->subtotal,2) }}</span></div>
      <div class="flex justify-between"><span>Shipping</span><span>฿ {{ number_format($order->shipping_fee ?? 35,2) }}</span></div>
      <hr class="my-2">
      <div class="flex justify-between font-semibold text-lg">
        <span>Total</span><span>฿ {{ number_format($order->total,2) }} <span class="text-xs">THB</span></span>
      </div>
    </div>

    {{-- 🧸 Order List --}}
    <div class="mt-4 text-sm">
      <div class="font-semibold mb-2 text-gray-700">Your Order {{ $order->items->count() }} item</div>
      @foreach($order->items as $it)
        <div class="flex items-center gap-3 py-2 border-b last:border-0">
          <img src="{{ asset($it->product->image_url) }}" alt="{{ $it->product->name }}" class="w-14 h-14 object-contain rounded">
          <div class="flex-1">
            <p>{{ $it->product->name }}</p>
            <p class="text-gray-500 text-sm">฿ {{ number_format($it->unit_price,0) }}</p>
          </div>
          <span class="text-gray-500 text-sm">QTY: {{ $it->qty }}</span>
        </div>
      @endforeach
    </div>

    <form action="{{ route('checkout.payment', $order) }}" method="POST" class="mt-6">
      @csrf
      <button type="submit"
              class="w-full bg-gradient-to-r from-[#8B5E45] to-[#4B3B34] text-white py-3 rounded-xl font-semibold 
                     hover:shadow-lg hover:scale-[1.02] transition">
        Check Out
      </button>
    </form>
  </aside>

  {{-- ✅ Modal --}}
  <div x-show="openAddress" 
       x-transition 
       @click.self="closeModal" 
       class="fixed inset-0 bg-black/40 flex justify-end z-50">

    <div class="bg-white w-full max-w-md h-full p-6 overflow-y-auto shadow-xl rounded-l-2xl">
      <div class="flex justify-between items-center border-b pb-3 mb-4">
        <h2 class="text-lg font-bold text-gray-700">My Address</h2>
        <button @click="closeModal" class="text-gray-500 hover:text-gray-800 text-2xl leading-none">&times;</button>
      </div>

      {{-- รายการที่อยู่ --}}
      <template x-for="addr in addresses" :key="addr.id">
        <div class="border rounded-lg p-3 mb-3 bg-gray-50 hover:bg-pink-50 transition cursor-pointer"
             @click="selectAddress(addr)">
          <div class="flex justify-between">
            <div>
              <p class="font-semibold" x-text="addr.recipient_name"></p>
              <p class="text-sm text-gray-600" x-text="addr.phone"></p>
              <p class="text-sm text-gray-600" 
                 x-text="`${addr.address_line1}, ${addr.district}, ${addr.province}, ${addr.postcode}`"></p>
            </div>
            <button @click.stop="startEdit(addr)" 
                    class="text-[#6B3E2E] text-sm underline hover:text-[#8B5E45]">Edit</button>
          </div>
        </div>
      </template>

      {{-- ปุ่ม + Add New --}}
      <div x-show="!showAddForm && !editing" class="mt-6 border-t pt-4">
        <button @click="showAddForm = true"
                class="w-full bg-[#6B3E2E] text-white py-2 rounded hover:bg-[#8B5E45]">
          + Add New Address
        </button>
      </div>

      {{-- ฟอร์มเพิ่มที่อยู่ใหม่ --}}
      <div x-show="showAddForm && !editing" x-cloak class="mt-6 border-t pt-4">
        <h3 class="font-semibold text-gray-700 mb-2">Add New Address</h3>
        <input x-model="form.recipient_name" placeholder="Name" class="border w-full mb-2 p-2 rounded">
        <input x-model="form.phone" placeholder="Phone" class="border w-full mb-2 p-2 rounded">
        <input x-model="form.address_line1" placeholder="Address line 1" class="border w-full mb-2 p-2 rounded">
        <input x-model="form.district" placeholder="District" class="border w-full mb-2 p-2 rounded">
        <input x-model="form.province" placeholder="Province" class="border w-full mb-2 p-2 rounded">
        <input x-model="form.postcode" placeholder="Postcode" class="border w-full mb-2 p-2 rounded">
        <div class="flex gap-2">
          <button @click="saveAddress()" 
                  class="w-1/2 bg-[#6B3E2E] text-white py-2 rounded hover:bg-[#8B5E45]">Save</button>
          <button @click="cancelAdd()" 
                  class="w-1/2 bg-gray-200 text-gray-700 py-2 rounded hover:bg-gray-300">Cancel</button>
        </div>
      </div>

      {{-- แก้ไขที่อยู่ --}}
      <template x-if="editing">
        <div x-cloak class="mt-6 border-t pt-4">
          <h3 class="font-semibold text-gray-700 mb-2">Edit Address</h3>
          <input x-model="editing.recipient_name" placeholder="Name" class="border w-full mb-2 p-2 rounded">
          <input x-model="editing.phone" placeholder="Phone" class="border w-full mb-2 p-2 rounded">
          <input x-model="editing.address_line1" placeholder="Address" class="border w-full mb-2 p-2 rounded">
          <input x-model="editing.postcode" placeholder="Postcode" class="border w-full mb-2 p-2 rounded">
          <div class="flex gap-2">
            <button @click="updateAddress()" class="w-1/2 bg-[#6B3E2E] text-white py-2 rounded hover:bg-[#8B5E45]">Update</button>
            <button @click="cancelEdit()" class="w-1/2 bg-gray-200 text-gray-700 py-2 rounded hover:bg-gray-300">Cancel</button>
          </div>
        </div>
      </template>

    </div>
  </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('addressModal', () => ({
    openAddress: false,
    addresses: [],
    editing: null,
    showAddForm: false,
    form: { recipient_name: '', phone: '', address_line1: '', district: '', province: '', postcode: '', country: 'Thailand' },

    openModal() { this.openAddress = true; this.loadAddresses(); this.showAddForm = false; this.editing = null; },
    closeModal() { this.openAddress = false; this.showAddForm = false; this.editing = null; },

    loadAddresses() {
      fetch('{{ route('profile.address.list') }}')
        .then(res => res.json())
        .then(data => this.addresses = data);
    },

    selectAddress(addr) {
      fetch(`/checkout/{{ $order->id }}/address`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ address_id: addr.id })
      })
      .then(async r => {
        const text = await r.text();
        try { return JSON.parse(text); } catch { throw new Error(text); }
      })
      .then(res => {
        alert(res.message || 'Address updated for this order.');
        this.closeModal();
        window.location.reload();
      })
      .catch(() => alert('Server error: unable to update address.'));
    },

    startEdit(addr) { this.editing = { ...addr }; },
    cancelEdit() { this.editing = null; },
    cancelAdd() { this.showAddForm = false; this.form = { recipient_name: '', phone: '', address_line1: '', district: '', province: '', postcode: '', country: 'Thailand' }; },

    saveAddress() {
      fetch('{{ route('profile.address.store') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify(this.form)
      })
      .then(r => r.json())
      .then(res => {
        alert(res.message);
        this.loadAddresses();
        this.cancelAdd();
      });
    },

    updateAddress() {
      fetch(`/profile/address/${this.editing.id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify(this.editing)
      })
      .then(r => r.json())
      .then(res => {
        alert(res.message);
        this.loadAddresses();
        this.cancelEdit();
      });
    }
  }))
})
</script>

@endsection

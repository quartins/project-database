@extends('layouts.app')

@section('content')
<div class="grid md:grid-cols-2 gap-10">
  {{-- รูปสินค้า --}}
  <div class="bg-white rounded-xl p-6 shadow">
    <img
      src="{{ asset($product->image_url) }}"
      alt="{{ $product->name }}"
      class="mx-auto max-h-[520px] object-contain rounded-lg shadow-md">
  </div>

  {{-- ข้อมูลสินค้า --}}
  <div>
    {{-- ชื่อ + ราคา --}}
    <div class="text-2xl font-semibold">{{ $product->name }}</div>
    <div class="text-rose-600 font-semibold text-xl mt-2">{{ $product->formatted_price }}</div>

    {{-- แจ้งเตือน --}}
    @if(session('flash_err'))
      <div class="mt-3 p-3 rounded-lg bg-rose-50 text-rose-700 border border-rose-200">
        {{ session('flash_err') }}
      </div>
    @endif

    {{-- สต็อก --}}
    <div class="mt-1 text-sm {{ $product->inStock() ? 'text-green-600':'text-rose-600' }}">
      {{ $product->inStock() ? 'มีสินค้าในสต็อก' : 'สินค้าหมดชั่วคราว' }}
    </div>
    @if($product->inStock())
      <div class="text-xs text-gray-500 mt-1">เหลือ {{ $product->stock_qty }} ชิ้น</div>
    @endif

    {{-- ควบคุมจำนวน --}}
    <div class="mt-6 space-y-3">
      <div class="text-sm font-medium">Quantity</div>
      <div class="flex items-center gap-2">
        <button type="button" class="px-3 py-1 border rounded" onclick="chg(-1)">-</button>
        <input
          id="qty"
          value="{{ session('suggested_qty', $qty ?? 1) }}"
          type="number"
          min="1"
          max="{{ $product->stock_qty }}"
          data-stock="{{ $product->stock_qty }}"
          class="w-16 text-center border rounded py-1">
        <button type="button" class="px-3 py-1 border rounded" onclick="chg(1)">+</button>
      </div>

      <div class="flex gap-4 pt-2 items-center">
        {{-- BUY NOW --}}
        <a
          id="buyNowLink"
          href="{{ route('checkout.buy', $product) }}?qty={{ session('suggested_qty', $qty ?? 1) }}&return={{ urlencode($return ?? url()->current()) }}"
          class="px-8 py-3 rounded-lg text-white font-semibold shadow-md transition-all duration-200
                 bg-gradient-to-r from-pink-500 to-rose-500 hover:scale-105 hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
          💕 BUY NOW
        </a>

        {{-- Add To Cart --}}
        @if(Route::has('cart.add'))
          <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" id="qty_cart" name="qty" value="{{ session('suggested_qty', $qty ?? 1) }}">
            <button type="submit"
                    id="btnAddToCart"
                    class="px-8 py-3 border-2 border-rose-400 rounded-lg text-rose-600 font-semibold
                           hover:bg-rose-50 hover:scale-105 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
              🛍️ Add To Cart
            </button>
          </form>
        @endif
      </div>

      <div id="qtyWarn" class="hidden text-sm text-rose-600 mt-2">❗ จำนวนที่เลือกมากกว่าสินค้าที่เหลือ</div>
    </div>

    {{-- Detail --}}
    <div class="mt-8 border-t pt-4">
      <button id="toggleDetail" type="button" class="w-full text-left flex justify-between items-center">
        <span class="font-semibold">Detail</span>
        <span id="arrow" class="transition">▾</span>
      </button>

      <div id="detailBox" class="mt-3 space-y-2">
        @if(!empty($product->formatted_size))
          <div><span class="font-semibold">Size:</span> {{ $product->formatted_size }}</div>
        @endif

        @if($product->materials && $product->materials->count())
          @php
            $parts = $product->materials->map(function($m){
              $name = $m->material_name ?? $m->material ?? null;
              $perc = $m->percentage ?? $m->percent ?? null;
              return trim($name.' '.($perc !== null ? $perc.'%' : ''));
            })->filter()->implode(' / ');
          @endphp
          @if(!empty($parts))
            <div><span class="font-semibold">Composition:</span> {{ $parts }}</div>
          @endif
        @endif

        @if(!empty($product->description))
          <div class="text-gray-700">{{ $product->description }}</div>
        @endif

        @if(!empty($product->sku))
          <div class="text-xs text-gray-400">SKU: {{ $product->sku }}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<script>
  function clampQty(q) {
    const stock = parseInt(document.getElementById('qty').dataset.stock || '0', 10);
    return Math.max(1, Math.min(q, stock));
  }

  function setButtonsDisabled(disabled) {
    const buy = document.getElementById('buyNowLink');
    const add = document.getElementById('btnAddToCart');
    const warn = document.getElementById('qtyWarn');
    if (buy) buy.toggleAttribute('disabled', disabled);
    if (add) add.toggleAttribute('disabled', disabled);
    if (warn) warn.classList.toggle('hidden', !disabled);
  }

  function syncQty(val) {
    val = clampQty(val);
    const buy = document.getElementById('buyNowLink');
    if (buy) {
      try {
        const url = new URL(buy.href, window.location.origin);
        url.searchParams.set('qty', val);
        buy.href = url.toString();
      } catch(e){}
    }
    const cartQty = document.getElementById('qty_cart');
    if (cartQty) cartQty.value = val;

    const stock = parseInt(document.getElementById('qty').dataset.stock || '0', 10);
    setButtonsDisabled(val > stock || stock <= 0);
  }

  function chg(d) {
    const el = document.getElementById('qty');
    const cur = parseInt(el.value || '1', 10) || 1;
    const next = clampQty(cur + d);
    el.value = next;
    syncQty(next);
  }

  (function(){
    const el = document.getElementById('qty');
    el.addEventListener('input', () => {
      el.value = clampQty(parseInt(el.value||'1',10)||1);
      syncQty(parseInt(el.value,10));
    });
    syncQty(parseInt(el.value || '1', 10));

    const box = document.getElementById('detailBox');
    const arrow = document.getElementById('arrow');
    const btn = document.getElementById('toggleDetail');
    btn.addEventListener('click', () => {
      box.classList.toggle('hidden');
      arrow.style.transform = box.classList.contains('hidden') ? 'rotate(-90deg)' : 'rotate(0deg)';
    });
  })();
</script>
@endsection

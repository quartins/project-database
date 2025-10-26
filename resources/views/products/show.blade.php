@extends('layouts.app')

@section('content')
{{-- 🌸 Breadcrumb Navigation --}}
<div class="max-w-6xl mx-auto px-6 mt-6 text-gray-600 text-sm font-medium">
    <nav class="flex flex-wrap items-center gap-1">
        <a href="{{ route('collection.index') }}" 
           class="hover:text-[#6B3E2E] transition-colors">Collection</a>
        <span>/</span>

        @if($product->category)
            <a href="{{ route('collection.show', ['category' => $product->category->id]) }}" 
               class="hover:text-[#6B3E2E] transition-colors">
                {{ $product->category->name }}
            </a>
            <span>/</span>
        @endif

        <span class="text-gray-800">{{ $product->name }}</span>
    </nav>
</div>

<div class="max-w-6xl mx-auto py-10 px-6 grid md:grid-cols-2 gap-12 items-start">
  
  {{-- ✅ Product Image --}}
  <div class="bg-white rounded-2xl shadow-lg p-6 flex justify-center items-center">
    <img
      src="{{ asset($product->image_url) }}"
      alt="{{ $product->name }}"
      class="mx-auto max-h-[480px] object-contain rounded-xl transition-transform duration-300 hover:scale-105">
  </div>

  {{-- ✅ Product Information --}}
  <div>
    {{-- Name + Price --}}
    <h1 class="text-3xl font-crimson font-bold text-gray-900 leading-snug">{{ $product->name }}</h1>
    <div class="text-[#C72533] font-semibold text-2xl mt-2">฿ {{ number_format($product->price, 2) }}</div>

    {{-- Stock --}}
    <div class="mt-2">
      @if($product->inStock())
        <p class="text-green-600 text-sm font-medium">In stock</p>
        <p class="text-gray-500 text-xs">Only {{ $product->stock_qty }} left</p>
      @else
        <p class="text-rose-600 text-sm font-medium">Out of stock</p>
      @endif
    </div>

    {{-- Quantity --}}
    <div class="mt-6">
      <label class="text-sm font-semibold text-gray-800">Quantity</label>
      <div class="flex items-center mt-2 gap-2">
        <button type="button" onclick="chg(-1)"
          class="w-8 h-8 flex justify-center items-center bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
          –
        </button>
        <input id="qty" value="{{ session('suggested_qty', $qty ?? 1) }}" type="number"
          min="1" max="{{ $product->stock_qty }}" data-stock="{{ $product->stock_qty }}"
          class="w-16 text-center border border-gray-300 rounded-lg py-1 focus:outline-[#6B3E2E] text-gray-800 font-medium">
        <button type="button" onclick="chg(1)"
          class="w-8 h-8 flex justify-center items-center bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
          +
        </button>
      </div>
    </div>

    {{-- Buttons --}}
    <div class="flex gap-4 mt-8">
      {{-- BUY NOW --}}
      <a id="buyNowLink"
         href="{{ route('checkout.buy', $product) }}?qty={{ session('suggested_qty', $qty ?? 1) }}&return={{ urlencode($return ?? url()->current()) }}"
         class="px-8 py-3 rounded text-white font-semibold shadow-sm transition-all duration-300
                bg-[#6B3E2E] hover:bg-[#8B5E45] border border-[#6B3E2E]
                flex items-center justify-center gap-2">
         BUY NOW
      </a>

      {{-- ✅ ADD TO CART (ใช้ logic ของเพื่อนที่รองรับ form + ajax) --}}
      @if(Route::has('cart.add'))
        <form id="addToCartForm" action="{{ route('cart.add') }}" method="POST">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" id="qty_cart" name="qty" value="{{ session('suggested_qty', $qty ?? 1) }}">
          <button type="submit"
            id="btnAddToCart"
            class="px-8 py-3 border border-[#6B3E2E] text-[#6B3E2E] font-semibold rounded 
                  hover:bg-[#6B3E2E] hover:text-white transition-all duration-300
                  flex items-center justify-center gap-2">
            Add To Cart
          </button>
        </form>
      @endif
    </div>

    <p id="qtyWarn" class="hidden text-sm text-rose-600 mt-3">
      ❗ The selected quantity exceeds available stock
    </p>

    {{-- ✅ Product Detail --}}
    <div class="mt-10 border-t pt-5">
      <button id="toggleDetail" type="button"
              class="w-full text-left flex justify-between items-center font-semibold text-gray-800">
        <span>Detail</span>
        <span id="arrow" class="transition text-gray-500">▾</span>
      </button>

      <div id="detailBox" class="mt-4 space-y-2 text-gray-700">
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
          <div class="text-gray-600">{{ $product->description }}</div>
        @endif

        @if(!empty($product->sku))
          <div class="text-xs text-gray-400 mt-3">SKU: {{ $product->sku }}</div>
        @endif
      </div>
    </div>
  </div>
</div>

{{-- ✅ Logic จากเพื่อน (ทำงานกับ CartController ใหม่ได้แน่) --}}
<script>
function clampQty(q) {
  const stock = parseInt(document.getElementById('qty').dataset.stock || '0', 10);
  return Math.max(1, Math.min(q, stock));
}

function syncQty(val) {
  val = clampQty(val);
  const buy = document.getElementById('buyNowLink');
  if (buy) {
    const url = new URL(buy.href, window.location.origin);
    url.searchParams.set('qty', val);
    buy.href = url.toString();
  }

  // ✅ อัปเดตค่า qty ที่จะส่งใน form
  const cartQty = document.getElementById('qty_cart');
  if (cartQty) cartQty.value = val;

  // ✅ ตรวจ stock เพื่อ disable ปุ่ม
  const stock = parseInt(document.getElementById('qty').dataset.stock || '0', 10);
  const addBtn = document.getElementById('btnAddToCart');
  const warn = document.getElementById('qtyWarn');
  const disabled = val > stock || stock <= 0;
  addBtn.disabled = disabled;
  warn.classList.toggle('hidden', !disabled);
}

function chg(d) {
  const el = document.getElementById('qty');
  const cur = parseInt(el.value || '1', 10) || 1;
  const next = clampQty(cur + d);
  el.value = next;
  syncQty(next);
}

document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('qty');
  el.addEventListener('input', () => {
    const val = clampQty(parseInt(el.value || '1', 10) || 1);
    el.value = val;
    syncQty(val);
  });
  syncQty(parseInt(el.value || '1', 10));

  const box = document.getElementById('detailBox');
  const arrow = document.getElementById('arrow');
  const btn = document.getElementById('toggleDetail');
  btn.addEventListener('click', () => {
    box.classList.toggle('hidden');
    arrow.style.transform = box.classList.contains('hidden') ? 'rotate(-90deg)' : 'rotate(0deg)';
  });
});
</script>

{{-- ✅ Hide number input arrows --}}
<style>
  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-[300px_1fr] gap-6">
  @include('profile.partials.sidebar')

  <section class="bg-white rounded-2xl border border-gray-200 p-6">
    <h1 class="text-2xl font-bold mb-6">Purchase Order</h1>

    {{-- 🔹 Tabs แยกสถานะ --}}
    <div class="flex gap-6 mb-6 border-b pb-2 text-sm font-medium">
        <a href="{{ route('orders.index', ['status' => 'cancelled']) }}"
         class="{{ ($status ?? '') === 'cancelled' ? 'text-rose-600 border-b-2 border-rose-600' : 'text-gray-500 hover:text-gray-800' }}">
         Cancelled Orders
      </a>  
      <a href="{{ route('orders.index', ['status' => 'pending']) }}"
          class="{{ ($status ?? 'pending') === 'pending' ? 'text-rose-600 border-b-2 border-rose-600' : 'text-gray-500 hover:text-gray-800' }}">
          Waiting for Payment
      </a>
      <a href="{{ route('orders.index', ['status' => 'paid']) }}"
         class="{{ ($status ?? '') === 'paid' ? 'text-rose-600 border-b-2 border-rose-600' : 'text-gray-500 hover:text-gray-800' }}">
         Paid Orders
      </a>

    </div>

    @php
      $orderCount = isset($orders)
        ? (method_exists($orders, 'count') ? $orders->count() : collect($orders)->count())
        : 0;
    @endphp

    @if($orderCount > 0)
      <div class="space-y-5">
        @foreach($orders as $order)
          <div class="border rounded-xl p-4 shadow-sm">
            <div class="flex items-start justify-between">
              <div>
                <div class="font-medium">Order #{{ $order->id }}</div>
                <div class="text-sm text-gray-500">{{ $order->created_at?->format('d M Y H:i') }}</div>

                {{-- สถานะ order --}}
                @if($order->status === 'paid')
                  <span class="mt-1 inline-block text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">paid</span>
                @elseif($order->status === 'pending')
                  <span class="mt-1 inline-block text-xs px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">pending</span>
                @elseif($order->status === 'cancelled')
                  <span class="mt-1 inline-block text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-600">cancelled</span>
                @else
                  <span class="mt-1 inline-block text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">{{ $order->status ?? 'draft' }}</span>
                @endif
              </div>

              <div class="text-right">
                <div class="text-sm text-gray-500">Total</div>
                <div class="text-lg font-semibold">฿ {{ number_format((float)($order->total ?? 0), 2) }}</div>
              </div>
            </div>

            {{-- รายการสินค้า --}}
            <div class="mt-4 divide-y">
              @foreach($order->items ?? [] as $it)
                @php
                  $p    = $it->product ?? null;
                  $name = $p->name ?? ('Product #'.$it->product_id);
                  $img  = $p->image_url ?? $p->image ?? $p->thumbnail ?? $p->thumbnail_url ?? asset('images/placeholder.png');
                  $line = ($it->line_total ?? 0) ?: ((float)$it->unit_price * (int)$it->qty);
                @endphp

                <div class="py-3 flex items-center gap-4">
                  <img src="{{ $img }}" class="w-20 h-20 object-cover rounded-md border" alt="product">
                  <div class="flex-1">
                    <div class="font-medium">{{ $name }}</div>
                    <div class="text-sm text-gray-500">
                      x{{ (int)$it->qty }} • ฿ {{ number_format((float)$it->unit_price, 2) }}
                    </div>
                  </div>
                  <div class="text-right text-sm">฿ {{ number_format((float)$line, 2) }}</div>
                </div>
              @endforeach
            </div>

            {{-- ปุ่มสถานะ --}}
            @php $first = ($order->items ?? collect())->first(); @endphp
            <div class="mt-4 flex justify-end gap-3">
              @if($order->status === 'pending')
                {{-- Cancel --}}
                <form method="POST" action="{{ route('checkout.cancel', $order) }}">
                  @csrf
                  <button type="submit"
                    onclick="return confirm('Are you sure you want to cancel this order?')"
                    class="px-4 py-2 rounded-lg border border-red-500 text-red-500 hover:bg-red-50 text-center font-semibold transition">
                    CANCEL
                  </button>
                </form>

                {{-- Pay Now --}}
                <a href="{{ route('checkout.payment', $order) }}"
                  class="px-4 py-2 rounded-lg bg-green-500 text-white hover:bg-green-600 text-center font-semibold transition shadow-sm">
                  PAY NOW
                </a>

              @elseif($order->status === 'paid' && $first?->product)
                {{-- Buy Again --}}
                <a href="{{ route('products.show', [
                    'idSlug' => $first->product->id . '-' . \Illuminate\Support\Str::slug($first->product->name)
                ]) }}"
                  class="px-4 py-2 rounded-lg border bg-rose-800 text-white hover:bg-rose-700 text-center font-semibold">
                  BUY AGAIN
                </a>

              @elseif($order->status === 'cancelled' && $first?->product)
                  {{-- ซื้ออีกครั้ง --}}
                  <a href="{{ route('products.show', [
                      'idSlug' => $first->product->id . '-' . \Illuminate\Support\Str::slug($first->product->name)
                  ]) }}"
                    class="px-4 py-2 rounded-lg border bg-rose-800 text-white hover:bg-rose-700 text-center font-semibold transition shadow-sm">
                    BUY AGAIN
                  </a>
              @endif

            </div>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if(method_exists($orders, 'links'))
        <div class="mt-6">{{ $orders->links() }}</div>
      @endif

    @else
      <div class="flex flex-col items-center justify-center py-16 text-gray-500">
        <svg class="w-10 h-10 mb-3" viewBox="0 0 24 24" fill="currentColor">
          <path d="M7 18c-1.1 0-2 .9-2 2h14a2 2 0 0 0-2-2H7zm11-9h-1l-1-3H8L7 9H6a2 2 0 0 0-2 2v7h2v-7h12v7h2v-7a2 2 0 0 0-2-2z"/>
        </svg>
        <p>You don’t have any orders yet.</p>
      </div>
    @endif
  </section>
</div>
@endsection

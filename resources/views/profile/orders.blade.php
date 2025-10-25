{{-- resources/views/profile/orders.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-[300px_1fr] gap-6">
  @include('profile.partials.sidebar')

  <section class="bg-white rounded-2xl border border-gray-200 p-6">
    <h1 class="text-2xl font-bold mb-6">Purchase Order</h1>

    @php
      // ให้ $orders รองรับทั้ง paginator และ collection
      $orderCount = isset($orders) ? (method_exists($orders, 'count') ? $orders->count() : collect($orders)->count()) : 0;
    @endphp

    @if($orderCount > 0)
      <div class="space-y-5">
        @foreach($orders as $order)
          <div class="border rounded-xl p-4">
            <div class="flex items-start justify-between">
              <div>
                <div class="font-medium">Order #{{ $order->id }}</div>
                <div class="text-sm text-gray-500">{{ $order->created_at?->format('d M Y H:i') }}</div>
                <span class="mt-1 inline-block text-xs px-2 py-0.5 rounded-full
                  {{ ($order->status ?? '') === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                  {{ $order->status ?? 'draft' }}
                </span>
              </div>
              <div class="text-right">
                <div class="text-sm text-gray-500">Total</div>
                <div class="text-lg font-semibold">฿ {{ number_format((float)($order->total ?? 0), 2) }}</div>
              </div>
            </div>

            <div class="mt-4 divide-y">
              @foreach($order->items ?? [] as $it)
                @php
                  $p    = $it->product ?? null; // อาจเป็น null ได้
                  $name = $p->name ?? ('Product #'.$it->product_id);
                  // รองรับหลายชื่อคอลัมน์รูป
                  $img  = $p->image_url ?? $p->image ?? $p->thumbnail ?? $p->thumbnail_url ?? null;
                  $line = ($it->line_total ?? 0) ?: ((float)$it->unit_price * (int)$it->qty);
                @endphp

                <div class="py-3 flex items-center gap-4">
                  <img src="{{ $img ?: asset('images/placeholder.png') }}"
                       class="w-20 h-20 object-cover rounded-md border" alt="product">
                  <div class="flex-1">
                    <div class="font-medium">{{ $name }}</div>
                    <div class="text-sm text-gray-500">x{{ (int)$it->qty }} • ฿ {{ number_format((float)$it->unit_price, 2) }}</div>
                  </div>
                  <div class="text-right text-sm">
                    ฿ {{ number_format((float)$line, 2) }}
                  </div>
                </div>
              @endforeach
            </div>

            @php $first = ($order->items ?? collect())->first(); @endphp
            @if($first?->product)
             <a href="{{ route('products.show', [
        'key' => $first->product->id . '-' . \Illuminate\Support\Str::slug($first->product->name)
    ]) }}"
   class="mt-4 ml-auto block w-fit px-4 py-2 rounded-lg border bg-rose-800 text-white hover:bg-rose-700 text-center">
   BUY AGAIN
</a>

            @endif
          </div>
        @endforeach
      </div>

      {{-- แสดง paginate ถ้าเป็น paginator --}}
      @if(method_exists($orders, 'links'))
        <div class="mt-6">
          {{ $orders->links() }}
        </div>
      @endif
    @else
      <div class="flex flex-col items-center justify-center py-16 text-gray-500">
        <svg class="w-10 h-10 mb-3" viewBox="0 0 24 24" fill="currentColor">
          <path d="M7 18c-1.1 0-2 .9-2 2h14a2 2 0 0 0-2-2H7zm11-9h-1l-1-3H8L7 9H6a2 2 0 0 0-2 2v7h2v-7h12v7h2v-7a2 2 0 0 0-2-2z"/>
        </svg>
        <p>You don’t have any orders yet ?</p>
      </div>
    @endif
  </section>
</div>
@endsection

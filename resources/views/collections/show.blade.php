@extends('layouts.app')

@section('content')
@php use Illuminate\Support\Str; @endphp

<div class="bg-white">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-[66rem] mx-auto">

      {{-- Category Title --}}
      <h1 class="text-4xl font-bold text-center mb-10">{{ $category->name }}</h1>

      {{-- Grid Container for Products --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

        @foreach ($products as $product)
          <div class="group relative p-5 bg-white border border-gray-300 rounded-lg shadow-sm
                      transition duration-300 ease-in-out hover:shadow-xl hover:-translate-y-1 text-center">

            {{-- ทำให้คลิกการ์ด (รูป/ชื่อ/ราคา) ไปหน้า detail --}}
            <a class="block focus:outline-none focus:ring-2 focus:ring-pink-300 rounded-lg"
               href="{{ route('products.show', ['key' => $product->id . '-' . Str::slug($product->name)]) }}">
              <img src="{{ asset($product->image_url) }}"
                   alt="{{ $product->name }}"
                   class="w-40 h-40 mx-auto object-contain mb-4">
              <h3 class="text-gray-800 font-medium mb-2">{{ $product->name }}</h3>
              <p class="text-gray-700 font-semibold mb-4">฿ {{ number_format($product->price, 2) }}</p>
            </a>

            {{-- ปุ่ม Add to Cart (แยกจากลิงก์ detail) --}}
            <button
              type="button"
              class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-full"
              data-id="{{ $product->id }}"
              data-qty="1"
              onclick="event.stopPropagation(); event.preventDefault(); addToCart({{ $product->id }})">
              Add to Cart
            </button>
          </div>
        @endforeach

      </div>
    </div>
  </div>
</div>
@endsection

@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Chamora | Sanrio Collection')

@section('content')
<div class="bg-gradient-to-b from-pink-100 to-yellow-50 min-h-screen font-serif overflow-x-hidden">

    {{-- 🌸 Banner --}}
    <section id="banner-section"
        class="relative w-screen left-1/2 right-1/2 -mx-[50vw] -mt-2 overflow-hidden 
                bg-[#FFF8F8] rounded-b-lg shadow-md">
        <img src="{{ asset('images/background.png') }}" 
            alt="Sanrio Background"
            class="w-full h-[565px] object-cover object-center">
    </section>

    {{-- 🧸 Product Section --}}
    <main class="max-w-7xl mx-auto py-12 px-6">
        {{-- 🔹 Title --}}
        <h2 id="section-title" class="text-2xl font-bold text-pink-700 text-center mb-10 tracking-wide">
            Recommended Sanrio Collections
        </h2>

        {{-- 🔍 Search Results (จะแสดงตอนค้นหา) --}}
        <div id="search-results" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8"></div>

        {{-- 🛍 Product Grid (แสดงปกติ) --}}
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($recommended as $product)
                <a href="{{ route('products.show', $product->id . '-' . Str::slug($product->name)) }}"
                   class="product-card bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-xl 
                          transition duration-300 p-5 text-center block group">

                    {{-- 🖼 รูปสินค้า --}}
                    <img src="{{ asset($product->image_url) }}" 
                         alt="{{ $product->name }}" 
                         class="w-40 h-40 mx-auto object-contain mb-4 transition-transform duration-300 group-hover:scale-105">

                    {{-- 🏷 ชื่อสินค้า + ราคา --}}
                    <h3 class="text-gray-800 font-medium mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-700 font-semibold mb-4">
                        ฿ {{ number_format($product->price, 1) }}
                    </p>

                    {{-- 🛒 ปุ่ม Add to Cart --}}
                    <button onclick="event.preventDefault(); addToCart({{ $product->id }})"
                            class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-full transition duration-200">
                        Add to Cart
                    </button>
                </a>
            @endforeach
        </div>
    </main>
</div>
@endsection

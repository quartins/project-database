@extends('layouts.app')

@section('title', $category->name . ' | Chamora Collection')

@section('content')
<div class="bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- 🩷 ชื่อหมวดหมู่ --}}
        <h1 id="section-title" class="text-4xl font-bold text-center mb-10">{{ $category->name }}</h1>

        {{-- 🔍 กล่องผลลัพธ์การค้นหา (จะโชว์เฉพาะตอนค้นหา) --}}
        <div id="search-results" class="hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 sm:gap-8"></div>

        {{-- 🧸 สินค้าในหมวด --}}
        <div id="product-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 sm:gap-8">
            @foreach ($products as $product)
            <div class="group block p-5 bg-white border border-gray-300 rounded-lg shadow-sm 
                        transition duration-300 ease-in-out 
                        hover:shadow-xl hover:-translate-y-1 text-center">

                {{-- รูปสินค้า --}}
                <img src="{{ asset($product->image_url) }}" 
                     alt="{{ $product->name }}" 
                     class="w-40 h-40 mx-auto object-contain mb-4">

                {{-- ชื่อสินค้า + ราคา --}}
                <h3 class="text-gray-800 font-medium mb-2">{{ $product->name }}</h3>
                <p class="text-gray-700 font-semibold mb-4">฿ {{ number_format($product->price, 2) }}</p>

                {{-- ปุ่มเพิ่มในตะกร้า --}}
                <button onclick="addToCart({{ $product->id }})"
                        class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-full">
                    Add to Cart
                </button>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

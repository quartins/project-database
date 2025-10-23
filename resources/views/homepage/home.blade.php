@extends('layouts.app')

@section('title', 'Chamora | Sanrio Collection')

@section('content')
<div class="bg-gradient-to-b from-pink-100 to-yellow-100 min-h-screen font-serif overflow-x-hidden">

    {{-- Banner --}}
    <section id="banner-section"
        class="relative w-screen left-1/2 right-1/2 -mx-[50vw] -mt-2 overflow-hidden 
                bg-[#FFF8F8] rounded-b-lg shadow-md">
        <img src="{{ asset('images/background.png') }}" 
            alt="Sanrio Background"
            class="w-full h-[565px] object-cover object-center">
    </section>

    {{--  Product Section --}}
    <main class="max-w-7xl mx-auto py-12 px-6">
        {{-- 🔹 เพิ่ม id เพื่อควบคุมการซ่อนตอนค้นหา --}}
        <h2 id="section-title" class="text-2xl font-bold text-pink-700 text-center mb-10 tracking-wide">
            Recommended Sanrio Collections
        </h2>

        {{--  แสดงผลลัพธ์การค้นหา --}}
        <div id="search-results" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8"></div>

        {{--  แสดงสินค้าเดิม (เมื่อยังไม่ได้ค้นหา) --}}
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($recommended as $product)
                <div class="product-card bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-xl transition duration-300 p-5 text-center">
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-40 h-40 mx-auto object-contain mb-4">
                    <h3 class="text-gray-800 font-medium mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-700 font-semibold mb-4">฿ {{ number_format($product->price, 1) }}</p>
                    <button onclick="addToCart({{ $product->id }})"
                            class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-full">
                        Add to Cart
                    </button>
                </div>
            @endforeach
        </div>
    </main>
</div>
@endsection


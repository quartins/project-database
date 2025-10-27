@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Chamora | Sanrio Collection')

@section('content')
<div class="bg-gradient-to-b from-pink-100 to-yellow-50 min-h-screen font-serif overflow-x-hidden">

   {{-- 🌸 Banner (Chamora Slideshow Refined Version) --}}
<section id="banner-section"
    class="relative w-screen left-1/2 right-1/2 -mx-[50vw] overflow-hidden 
            bg-[#FFF8F8] rounded-b-lg shadow-md">

    {{-- ✅ Swiper.js CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
        /* 🌟 ปรับสีลูกศร */
        .swiper-button-next,
        .swiper-button-prev {
            color: #b5651d; /* น้ำตาลพาสเทล */
            transition: transform 0.2s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            transform: scale(1.2);
        }

        /* 🍮 จุด pagination */
        .swiper-pagination-bullet {
            background-color: #d7a77a !important;
            opacity: 0.5;
        }

        .swiper-pagination-bullet-active {
            background-color: #b5651d !important;
            opacity: 1;
        }

        /* 🎀 เอฟเฟกต์ fade */
        .swiper-slide {
            transition: opacity 0.8s ease-in-out;
        }
    </style>

    <div class="swiper mySwiper">
        <div class="swiper-wrapper">

        {{-- 🌸 Background --}}
            <div class="swiper-slide">
                <img src="{{ asset('images/background.png') }}" 
                     alt="Chamora Background" 
                     class="w-full h-[565px] object-cover object-center">
            </div>

            {{-- 💖 Hirono --}}
            <div class="swiper-slide">
                <img src="{{ asset('images/bannerhirono.jpg') }}" 
                     alt="Hirono Collection" 
                     class="w-full h-[565px] object-cover object-center">
            </div>

            {{-- 🖤 Kuromi --}}
            <div class="swiper-slide">
                <img src="{{ asset('images/bannerkuromi.jpg') }}" 
                     alt="Kuromi Collection" 
                     class="w-full h-[565px] object-cover object-center">
            </div>

            {{-- 🎀 My Melody --}}
            <div class="swiper-slide">
                <img src="{{ asset('images/bannermymelody.jpg') }}" 
                     alt="My Melody Collection" 
                     class="w-full h-[565px] object-cover object-center">
            </div>

            {{-- 🌟 Twinkle --}}
            <div class="swiper-slide">
                <img src="{{ asset('images/bannertwinkle.jpg') }}" 
                     alt="Twinkle Collection" 
                     class="w-full h-[565px] object-cover object-center">
            </div>

        </div>

        {{-- ปุ่มเลื่อน & จุดสถานะ --}}
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <script>
  document.addEventListener("DOMContentLoaded", () => {
      new Swiper(".mySwiper", {
          loop: true,
          speed: 900, // ความเร็วตอนเลื่อน (หน่วย ms)
          autoplay: { 
              delay: 4000, 
              disableOnInteraction: false 
          },
          effect: "slide", // ใช้แบบเลื่อนนุ่มๆ
          pagination: { 
              el: ".swiper-pagination", 
              clickable: true 
          },
          navigation: {
              nextEl: ".swiper-button-next",
              prevEl: ".swiper-button-prev",
          },
      });
  });
</script>
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

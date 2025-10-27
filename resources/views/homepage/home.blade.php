@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Chamora | Sanrio Collection')

@section('content')
<div class="bg-gradient-to-b from-pink-100 to-yellow-50 min-h-screen font-serif overflow-x-hidden">

   {{--  Banner (Chamora Slideshow with Individual Height Control) --}}
        <section id="banner-section"
            class="relative w-screen left-1/2 right-1/2 -mx-[50vw] overflow-hidden 
                    bg-[#FFF8F8] rounded-b-lg shadow-md">

            {{--  Swiper.js CSS & JS --}}
            <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
            <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

            <style>
                /*  กำหนดความสูงแต่ละภาพ  */
                .banner-bg { height: 500px; object-fit: cover; object-position: center; }
                .banner-promo { height: 500px; object-fit: contain; background-color: #fff; }
                .banner-hirono { height: 500px; object-fit: contain; background-color: #fff;}
                .banner-kuromi { height: 500px; object-fit: contain; background-color: #fffafb; }
                .banner-mymelody { height: 500px; object-fit: cover; }
                .banner-kitty { height: 500px; object-fit: cover; }
                .banner-twinkle { height: 500px; object-fit: contain; background-color: #fff; }

                /* ปรับสีลูกศร */
                .swiper-button-next,
                .swiper-button-prev {
                    color: #b5651d;
                    transition: transform 0.2s ease;
                }

                .swiper-button-next:hover,
                .swiper-button-prev:hover {
                    transform: scale(1.2);
                }

                /*  จุด pagination */
                .swiper-pagination-bullet {
                    background-color: #d7a77a !important;
                    opacity: 0.5;
                }

                .swiper-pagination-bullet-active {
                    background-color: #b5651d !important;
                    opacity: 1;
                }

                /*  เอฟเฟกต์ fade */
                .swiper-slide {
                    transition: opacity 0.8s ease-in-out;
                }
            </style>

            <div class="swiper mySwiper">
                <div class="swiper-wrapper">

                    {{--  Background --}}
                    <div class="swiper-slide">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/background.png') }}" 
                                alt="Chamora Background" 
                                class="w-full banner-bg">
                        </a>
                    </div>

                    {{--  Promotion --}}
                    <div class="swiper-slide">
                        <a href="{{ route('collection.index') }}">
                            <img src="{{ asset('images/promotion.png') }}" 
                                alt="Chamora Promotion" 
                                class="w-full banner-promo">
                        </a>
                    </div>

                    {{--  Hirono (ID = 4) --}}
                    <div class="swiper-slide">
                        <a href="{{ url('/collections/4') }}">
                            <img src="{{ asset('images/bannerhirono.png') }}" 
                                alt="Hirono Collection" 
                                class="w-full banner-hirono">
                        </a>
                    </div>

                    {{--  Kuromi (ID = 3) --}}
                    <div class="swiper-slide">
                        <a href="{{ url('/collections/3') }}">
                            <img src="{{ asset('images/bannerkuromi.png') }}" 
                                alt="Kuromi Collection" 
                                class="w-full banner-kuromi">
                        </a>
                    </div>

                    {{--  My Melody (ID = 2) --}}
                    <div class="swiper-slide">
                        <a href="{{ url('/collections/2') }}">
                            <img src="{{ asset('images/bannermymelody.png') }}" 
                                alt="My Melody Collection" 
                                class="w-full banner-mymelody">
                        </a>
                    </div>

                    {{--  Hello Kitty (ID = 1) --}}
                    <div class="swiper-slide">
                        <a href="{{ url('/collections/1') }}">
                            <img src="{{ asset('images/bannerkitty.png') }}" 
                                alt="Hello Kitty Collection" 
                                class="w-full banner-kitty">
                        </a>
                    </div>

                    {{--  Twinkle (ID = 5) --}}
                    <div class="swiper-slide">
                        <a href="{{ url('/collections/5') }}">
                            <img src="{{ asset('images/bannertwinkle.png') }}" 
                                alt="Twinkle Collection" 
                                class="w-full banner-twinkle">
                        </a>
                    </div>
                </div>

                {{--  ปุ่มเลื่อนซ้ายขวา & จุด pagination --}}
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination"></div>
            </div>

            <script>
                const swiper = new Swiper(".mySwiper", {
                    loop: true,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    effect: "fade",
                    fadeEffect: {
                        crossFade: true
                    },
                });
            </script>
        </section>



        
    {{--  Product Section --}}
    <main class="max-w-7xl mx-auto py-12 px-6">
        {{--  Title --}}
        <h2 id="section-title" class="text-2xl font-bold text-pink-700 text-center mb-10 tracking-wide">
            Recommended Sanrio Collections
        </h2>

        {{--  Search Results (จะแสดงตอนค้นหา) --}}
        <div id="search-results" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8"></div>

        {{--  Product Grid (แสดงปกติ) --}}
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($recommended as $product)
                <a href="{{ route('products.show', $product->id . '-' . Str::slug($product->name)) }}"
                   class="product-card bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-xl 
                          transition duration-300 p-5 text-center block group">

                    {{--  รูปสินค้า --}}
                    <img src="{{ asset($product->image_url) }}" 
                         alt="{{ $product->name }}" 
                         class="w-40 h-40 mx-auto object-contain mb-4 transition-transform duration-300 group-hover:scale-105">

                    {{--  ชื่อสินค้า + ราคา --}}
                    <h3 class="text-gray-800 font-medium mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-700 font-semibold mb-4">
                        ฿ {{ number_format($product->price, 1) }}
                    </p>

                    {{--  ปุ่ม Add to Cart --}}
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

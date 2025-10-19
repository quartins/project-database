@extends('layouts.app')

@section('content')
    
    {{--  Banner --}}
    <section class="relative">
        <img src="{{ asset('images/background.png') }}" 
             alt="Sanrio Background" 
             class="w-full h-[565px] object-cover object-center rounded-b-lg shadow-md">
    </section>

    {{-- Product Section --}}
    <main class="max-w-7xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-bold text-pink-700 text-center mb-10 tracking-wide">
            Recommended Sanrio Collections
        </h2>
        
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @if(isset($recommended)) {{-- เพิ่มการตรวจสอบเพื่อป้องกัน Error --}}
                @foreach ($recommended as $product)
                    <div class="product-card bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-xl transition duration-300 p-5 text-center"
                         data-name="{{ strtolower(str_replace(' ', '', $product->name)) }}">
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-40 h-40 mx-auto object-contain mb-4">
                        <h3 class="text-gray-800 font-medium mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-700 font-semibold mb-4">฿ {{ number_format($product->price, 1) }}</p>
                        <button onclick="addToCart({{ $product->id }})"
                                class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-full">
                            Add to Cart
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <footer class="mt-14 bg-gray-100 py-6 text-center text-gray-600 text-sm">
        © 2025 Chamora | All Rights Reserved
    </footer>

    {{-- SCRIPT SECTION --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const searchInput = document.getElementById("search-box");
            const products = document.querySelectorAll(".product-card");

            if (searchInput) {
                searchInput.addEventListener("input", function() {
                    const query = this.value.toLowerCase().replace(/\s+/g, "");
                    products.forEach(product => {
                        const name = product.dataset.name.toLowerCase();
                        product.style.display = name.includes(query) ? "block" : "none";
                    });
                });
            }

            window.addToCart = function (productId) {
                fetch("/cart/add", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(res => {
                    if (res.status === 401) {
                        window.location.href = "/login";
                        return;
                    }
                    return res.json();
                })
                .then(data => {
                    if (data?.cart_count !== undefined) {
                        const cartCountEl = document.getElementById("cart-count");
                        const cartIconEl = document.getElementById("cart-icon");
                        cartCountEl.textContent = data.cart_count;
                        cartCountEl.classList.remove("hidden");

                        if (cartIconEl) {
                            cartIconEl.classList.add("animate-bounce");
                            setTimeout(() => cartIconEl.classList.remove("animate-bounce"), 600);
                        }
                    }
                })
                .catch(err => console.error("Add to cart failed:", err));
            };
        });
    </script>

@endsection
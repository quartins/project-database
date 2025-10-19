@extends('layouts.app')

@section('content')
    
    <div class="bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            {{-- Grid Container สำหรับจัดเรียงการ์ด --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

                {{-- วนลูปเพื่อแสดง Category Card แต่ละอัน --}}
                @foreach ($categories as $category)
                <a href="{{ route('collection.show', $category) }}" 
                   class="group block p-5 bg-white border border-gray-300 rounded-lg shadow-sm 
                          transition duration-300 ease-in-out 
                          hover:shadow-xl hover:-translate-y-1 text-center">
                    
                    {{-- รูปภาพ --}}
                    <img src="{{ asset($category->image_url) }}" 
                         alt="{{ $category->name }}" 
                         class="w-40 h-40 mx-auto object-contain mb-4">
                    
                    {{-- ชื่อ Category --}}
                    <h3 class="text-gray-800 font-medium mb-2">{{ $category->name }}</h3>
                </a>
                @endforeach
                
            </div>
        </div>
    </div>

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
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

    {{-- Product Section --}}
    <main class="max-w-7xl mx-auto py-12 px-6">
        {{-- Title --}}
        <h2 id="section-title" class="text-2xl font-bold text-pink-700 text-center mb-10 tracking-wide">
            Recommended Sanrio Collections
        </h2>

        {{-- Show Product --}}
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($recommended as $product)
                <div class="product-card bg-white border border-gray-300 rounded-lg shadow-sm hover:shadow-xl transition duration-300 p-5 text-center">
                    
                    {{-- Link to product detail --}}
                    <a href="{{ route('products.show', ['key' => $product->id . '-' . Str::slug($product->name)]) }}" class="block">
                        <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-40 h-40 mx-auto object-contain mb-4">
                        <h3 class="text-gray-800 font-medium mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-700 font-semibold mb-4">฿ {{ number_format($product->price, 1) }}</p>
                    </a>

                    {{-- Add to Cart Button --}}
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



    {{--  Script logic --}}
    @section('scripts')
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const cartCountEl = document.getElementById("cart-count");
        const cartIconEl  = document.getElementById("cart-icon");
        const searchInput = document.getElementById("search-box");
        const bannerSection = document.getElementById("banner-section");
        const titleEl = document.getElementById("section-title");
        const productGrid = document.getElementById("product-grid");
        const resultsContainer = document.getElementById("search-results");

        // ดึงจำนวนสินค้าใน cart จาก backend
        fetch("/cart/count")
            .then(res => res.ok ? res.json() : {count:0})
            .then(data => {
                const count = data.count || 0;
                if (count > 0) {
                    cartCountEl.textContent = count;
                    cartCountEl.classList.remove("hidden");
                } else {
                    cartCountEl.classList.add("hidden");
                }
            })
            .catch(() => cartCountEl.classList.add("hidden"));

        //  ฟังก์ชันเพิ่มสินค้า
        window.addToCart = function (productId) {
            fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}"
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => res.json())
            .then(data => {
                if (data?.cart_count !== undefined) {
                    cartCountEl.textContent = data.cart_count;
                    cartCountEl.classList.remove("hidden");
                    cartIconEl?.classList.add("animate-bounce");
                    setTimeout(() => cartIconEl?.classList.remove("animate-bounce"), 600);
                }
            })
            .catch(err => console.error("Add to cart failed:", err));
        };

        //  ระบบค้นหาแบบเรียลไทม์ 
        let timer;
        searchInput.addEventListener("input", () => {
            const query = searchInput.value.trim();
            clearTimeout(timer);

            timer = setTimeout(async () => {
                if (query.length === 0) {
                    // กลับสู่หน้าเดิม (แสดง banner, title, product grid)
                    resultsContainer.classList.add("hidden");
                    productGrid.classList.remove("hidden");
                    bannerSection.classList.remove("hidden");
                    titleEl.style.display = "block";
                    return;
                }

                // เริ่มค้นหา ซ่อน banner และ title
                bannerSection.classList.add("hidden");
                productGrid.classList.add("hidden");
                resultsContainer.classList.remove("hidden");
                titleEl.style.display = "none";

                try {
                    const res = await fetch(`/search?q=${encodeURIComponent(query)}`);
                    const data = await res.json();

                    if (data.length === 0) {
                        resultsContainer.innerHTML = `
                            <p class="text-center text-gray-500 italic col-span-full">No products found 💔</p>
                        `;
                        return;
                    }

                    //  แสดงผลลัพธ์สินค้าใหม่
                    resultsContainer.innerHTML = data.map(p => `
                        <div class="bg-white border border-gray-300 rounded-lg shadow-sm p-5 text-center hover:shadow-xl transition duration-300">
                            <img src="${p.image_url}" alt="${p.name}" class="w-40 h-40 mx-auto object-contain mb-4">
                            <h3 class="text-gray-800 font-medium mb-2">${p.name}</h3>
                            <p class="text-gray-700 font-semibold mb-4">
                                ฿ ${parseFloat(p.price || 0).toFixed(1)}
                            </p>
                            <button onclick="addToCart(${p.id})"
                                    class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-full">
                                Add to Cart
                            </button>
                        </div>
                    `).join("");
                } catch (err) {
                    console.error("Error fetching products:", err);
                }
            }, 300);
        });
    });
    </script>
    @endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamora | Sanrio Collection</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-gradient-to-b from-pink-100 to-yellow-100 min-h-screen font-serif">

    <!-- Header -->
    <header 
        class="shadow-md" 
        style="background: radial-gradient(circle at center, #ffffffff, #fed8eeff, #ffd1ebff)">
        <div class="max-w-7xl mx-auto grid grid-cols-3 items-center px-6 py-4">
            
            <!-- Search Box -->
            <div class="relative w-48">
                <input id="search-box" type="text" 
                    placeholder="Search..." 
                    class="w-full px-3 py-1.5 pr-8 text-sm rounded-full 
                            bg-white border border-brown-500 
                            focus:ring-brown-400 focus:border-brown-600 shadow-sm" />
                <img src="{{ asset('images/search.png') }}" 
                    alt="Search Icon" 
                    class="absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 opacity-80">
            </div>

            <!-- Center: Logo -->
            <div class="flex justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
            </div>

            <!-- Profile & Cart -->
            <div class="flex justify-end items-center space-x-4">
                <a href="/cart" class="relative hover:opacity-80 transition">
                    <img id="cart-icon" src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
                    <span id="cart-count"
                        class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">
                        0
                    </span>
                </a>
                <a href="/myprofile" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
                </a>
            </div>
        </div> 
    </header>

    {{--  navbar --}}
    @include('layouts.navigation')

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
            </div>
    </main>

    {{-- Footer --}}
    <footer class="mt-14 bg-yellow-60 py-6 text-center text-gray-600 text-sm">
        © 2025 Chamora | All Rights Reserved
    </footer>

    {{-- SCRIPT SECTION --}}

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cartCountEl = document.getElementById("cart-count");
            const cartIconEl  = document.getElementById("cart-icon");
            const searchInput = document.getElementById("search-box");
            const products = document.querySelectorAll(".product-card");

            //  ดึงจำนวนสินค้าใน cart จาก backend
            fetch("/cart/count")
                .then(res => {
                    if (res.status === 401) {
                        // ถ้า user ยังไม่ login → ซ่อนไว้
                        cartCountEl.classList.add("hidden");
                        return { count: 0 };
                    }
                    return res.json();
                })
                .then(data => {
                    const count = data.count || 0;
                    if (count > 0) {
                        cartCountEl.textContent = count;
                        cartCountEl.classList.remove("hidden");
                    } else {
                        cartCountEl.classList.add("hidden");
                    }
                })
                .catch(() => {
                    cartCountEl.classList.add("hidden");
                });

            // ฟังก์ชันเพิ่มสินค้า
            window.addToCart = function (productId) {
                fetch("/cart/add", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(res => {
                    if (res.status === 401) {
                        // ถ้า user ยังไม่ login → ไปหน้า login
                        window.location.href = "/login";
                        return;
                    }
                    return res.json();
                })
                .then(data => {
                    if (data?.cart_count !== undefined) {
                        // อัปเดต badge
                        const cartCountEl = document.getElementById("cart-count");
                        cartCountEl.textContent = data.cart_count;
                        cartCountEl.classList.remove("hidden");

                        // เอฟเฟกต์เด้งให้ feedback
                        const cartIcon = document.querySelector("#cart-icon");
                        if (cartIconEl) {
                            cartIconEl.classList.add("animate-bounce");
                            setTimeout(() => cartIconEl.classList.remove("animate-bounce"), 600);
                        }
                    }
                })
                .catch(err => console.error("Add to cart failed:", err));
            };

            // ระบบsearch (พิมพ์ติดกันก็หาเจอ)
            searchInput.addEventListener("input", function() {
                const query = this.value.toLowerCase().replace(/\s+/g, "");
                products.forEach(product => {
                    const name = product.dataset.name.toLowerCase();
                    product.style.display = name.includes(query) ? "block" : "none";
                });
            });
        });
        </script>

</body>
</html>

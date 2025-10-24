<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Chamora'))</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Mystery+Quest&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-serif min-h-screen antialiased bg-transparent overflow-x-hidden">

    {{-- Header + Navbar --}}
    <header>
        @include('layouts.header')
        @include('layouts.navigation')
    </header>

    {{-- Main --}}
    <main class="min-h-[80vh] px-0 pt-0 mt-0">
        @yield('content')
    </main>

    {{-- Footer → แสดงเฉพาะหน้า Home --}}
    @if (Request::is('/'))
        <footer class="mt-0 py-6 text-center text-gray-600 text-sm bg-yellow-100 shadow-none border-0">
            © 2025 Chamora | All Rights Reserved
        </footer>
    @endif

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

    @stack('scripts')
    @yield('scripts')
</body>
</html>
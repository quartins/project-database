<!-- resources/views/layouts/header.blade.php -->
<header class="shadow-md" style="background: radial-gradient(circle at center, #ffffff, #fed8ee, #ffd1eb)">
    <div class="max-w-7xl mx-auto grid grid-cols-3 items-center px-6 py-4">
        
        {{-- 🔍 Search Box --}}
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

        {{-- 🌸 Logo --}}
        <div class="flex justify-center">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
            </a>
        </div>

        {{-- 🛒 Cart + User --}}
        <div class="flex justify-end items-center space-x-4">
            @auth
                <a href="{{ route('cart.index') }}" class="relative hover:opacity-80 transition">
                    <img id="cart-icon" src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
                    <span id="cart-count"
                          class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full 
                                 w-5 h-5 flex items-center justify-center hidden transition-transform duration-300">0</span>
                </a>
                <a href="{{ route('profile.custom') }}" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
                </a>
            @else
                <a href="{{ route('login') }}" class="relative hover:opacity-80 transition">
                    <img id="cart-icon" src="{{ asset('images/cart.png') }}" alt="Cart (login first)" class="h-6">
                </a>
                <a href="{{ route('login') }}" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/user.png') }}" alt="Profile (login first)" class="h-5">
                </a>
            @endauth
        </div>
    </div>
</header>

{{-- 💫 Toast Popup (น่ารัก ๆ แสดงตรงกลางแล้วหายไป) --}}
<div id="toast"
     class="fixed inset-0 flex items-center justify-center opacity-0 pointer-events-none 
            transition-opacity duration-500 z-50">
    <div class="bg-green-500 text-white text-sm px-6 py-3 rounded-full shadow-lg">
        Added to cart!
    </div>
</div>

@push('scripts')
<script>
function showToast(message = "Added to cart!") {
    const toast = document.getElementById("toast");
    const inner = toast.querySelector("div");
    inner.textContent = message;

    // แสดง Toast
    toast.classList.remove("opacity-0", "pointer-events-none");
    toast.classList.add("opacity-100");

    // หายไปอัตโนมัติหลัง 1 วินาที
    setTimeout(() => {
        toast.classList.remove("opacity-100");
        toast.classList.add("opacity-0");
        setTimeout(() => {
            toast.classList.add("pointer-events-none");
        }, 500);
    }, 1000);
}

document.addEventListener("DOMContentLoaded", () => {
// 🔍 Search system (works globally, even if page doesn't have banner or grid)
const searchInput = document.getElementById("search-box");

// ตรวจสอบว่ามี search box จริงก่อนทำงาน
if (searchInput) {
    const bannerSection = document.getElementById("banner-section");
    const titleEl = document.getElementById("section-title");
    const productGrid = document.getElementById("product-grid");

    // ✅ สร้าง container สำหรับผลลัพธ์ ถ้ายังไม่มี
    let resultsContainer = document.getElementById("search-results");
    if (!resultsContainer) {
        resultsContainer = document.createElement("div");
        resultsContainer.id = "search-results";
        resultsContainer.className =
            "max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8";
        document.body.appendChild(resultsContainer);
    }

    let timer;
    searchInput.addEventListener("input", () => {
        const query = searchInput.value.trim();
        clearTimeout(timer);

        timer = setTimeout(async () => {
            if (query.length === 0) {
                // ถ้า query ว่าง ให้ซ่อนผลลัพธ์และแสดง layout เดิม (ถ้ามี)
                resultsContainer.classList.add("hidden");
                productGrid?.classList.remove("hidden");
                bannerSection?.classList.remove("hidden");
                titleEl?.classList.remove("hidden");
                return;
            }

            // ซ่อน element ที่มีเฉพาะบางหน้า ถ้ามี
            bannerSection?.classList.add("hidden");
            productGrid?.classList.add("hidden");
            titleEl?.classList.add("hidden");

            // แสดงผลลัพธ์
            resultsContainer.classList.remove("hidden");
            resultsContainer.innerHTML = `<p class='text-center text-gray-400 italic py-6'>Searching...</p>`;

            try {
                const res = await fetch(`/search?q=${encodeURIComponent(query)}`);
                const data = await res.json();

                if (!data || data.length === 0) {
                    resultsContainer.innerHTML = `<p class='text-center text-gray-500 italic py-6'>No products found.</p>`;
                    return;
                }

                resultsContainer.innerHTML = data.map(p => `
                    <div class="bg-white border border-gray-300 rounded-lg shadow-sm p-5 text-center hover:shadow-xl transition duration-300">
                        <a href="/products/${p.id}-${p.slug}" class="block">
                            <img src="${p.image_url}" alt="${p.name}" class="w-40 h-40 mx-auto object-contain mb-4">
                            <h3 class="text-gray-800 font-medium mb-2">${p.name}</h3>
                            <p class="text-gray-700 font-semibold mb-4">฿ ${parseFloat(p.price || 0).toFixed(1)}</p>
                        </a>
                        <button onclick="addToCart(${p.id})"
                                class="bg-pink-500 hover:bg-pink-600 text-white font-medium px-4 py-2 rounded-full">
                            Add to Cart
                        </button>
                    </div>
                `).join("");
            } catch (err) {
                console.error("Search failed:", err);
                resultsContainer.innerHTML = `<p class='text-center text-gray-500 italic py-6'>Search failed. Please try again.</p>`;
            }
        }, 300);
    });
}


    // 🛍 Cart System
    const cartCountEl = document.getElementById("cart-count");
    if (cartCountEl) {
        fetch("/cart/count")
            .then(res => res.ok ? res.json() : { count: 0 })
            .then(data => {
                const count = data.count || 0;
                cartCountEl.textContent = count;
                cartCountEl.classList.toggle("hidden", count <= 0);
            })
            .catch(() => cartCountEl.classList.add("hidden"));
    }

    // ✅ Add to Cart + Toast แสดงผล
    window.addToCart = async function (productId) {
        try {
            const res = await fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}"
                },
                body: JSON.stringify({ product_id: productId })
            });

            if (res.status === 401) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            const data = await res.json();
            if (data.cart_count !== undefined && cartCountEl) {
                cartCountEl.textContent = data.cart_count;
                cartCountEl.classList.remove("hidden");
                cartCountEl.classList.add("scale-125");
                setTimeout(() => cartCountEl.classList.remove("scale-125"), 200);

                // ✅ แสดง Toast น่ารัก ๆ แล้วหายไปเอง
                showToast("Added to cart!");
            }
        } catch (err) {
            console.error("Add to cart failed:", err);
        }
    };
});
</script>
@endpush

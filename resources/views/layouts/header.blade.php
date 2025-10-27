<!-- resources/views/layouts/header.blade.php -->
<header class="shadow-md" style="background: radial-gradient(circle at center, #ffffff, #fed8ee, #ffd1eb)">
    <div class="max-w-7xl mx-auto grid grid-cols-3 items-center px-6 py-4">
        
        {{--  Search Box --}}
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

        {{--  Logo --}}
        <div class="flex justify-center">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
            </a>
        </div>

        {{-- Cart + User --}}
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

@push('scripts')
<script>
function showToast(message = "Added to cart!", type = "success") {
    // ลบ toast เดิมทั้งหมดก่อน
    document.querySelectorAll(".toast-dynamic").forEach(el => el.remove());

    // สร้าง container กลางจอถ้ายังไม่มี
    let toastContainer = document.getElementById("toast-container-global");
    if (!toastContainer) {
        toastContainer = document.createElement("div");
        toastContainer.id = "toast-container-global";
        toastContainer.style.position = "fixed";
        toastContainer.style.top = "50%";
        toastContainer.style.left = "50%";
        toastContainer.style.transform = "translate(-50%, -50%)";
        toastContainer.style.zIndex = "99999";
        document.body.appendChild(toastContainer);
    }

    // สร้าง toast
    const toast = document.createElement("div");
    toast.className = `
        toast-dynamic px-6 py-3 text-white text-sm font-medium rounded-full shadow-lg
        opacity-0 transition-all duration-300 ease-in-out mb-3 text-center
    `;
    toast.textContent = message;

    // สีพื้นหลัง
    let bg = "#4CAF50";
    if (type === "error") bg = "#F44336";
    else if (type === "warning") bg = "#FF9800";
    toast.style.backgroundColor = bg;

    // เพิ่มเข้า container
    toastContainer.appendChild(toast);

    // Fade in
    requestAnimationFrame(() => {
        toast.style.opacity = "1";
        toast.style.transform = "scale(1)";
    });

    // Fade out แล้วลบทิ้งแน่หลัง 2 วิ
    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "scale(0.9)";
        setTimeout(() => {
            if (toast && toast.parentNode) toast.parentNode.removeChild(toast);
        }, 400);
    }, 2000);
}


document.addEventListener("DOMContentLoaded", () => {
    //  Search system
    const searchInput = document.getElementById("search-box");
    if (searchInput) {
        const bannerSection = document.getElementById("banner-section");
        const titleEl = document.getElementById("section-title");
        const productGrid = document.getElementById("product-grid");

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
                    resultsContainer.classList.add("hidden");
                    productGrid?.classList.remove("hidden");
                    bannerSection?.classList.remove("hidden");
                    titleEl?.classList.remove("hidden");
                    return;
                }

                bannerSection?.classList.add("hidden");
                productGrid?.classList.add("hidden");
                titleEl?.classList.add("hidden");

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

    //  Cart Count
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

    //  Add to Cart
    window.addToCart = async function (productId) {
        try {
            // 🔹 ตรวจสอบจำนวนในตะกร้าก่อน
            const checkRes = await fetch(`/cart/get-item/${productId}`, {
            credentials: "include",
            headers: { "X-Requested-With": "XMLHttpRequest" }
            });

            if (checkRes.status === 401) {
            window.location.href = "{{ route('login') }}"; 
            return;
            }

            let currentQty = 0;
            if (checkRes.ok) {
            const checkData = await checkRes.json();
            currentQty = parseInt(checkData.current_qty || 0, 10);
            }

            // 🔹 ดึงข้อมูล stock ของสินค้าจาก backend
            const stockRes = await fetch(`/cart/get-stock/${productId}`, {
            credentials: "include",
            headers: { "X-Requested-With": "XMLHttpRequest" }
            });

            if (stockRes.status === 401) {
            window.location.href = "{{ route('login') }}"; 
            return;
            }

            const stockData = await stockRes.json();
            const stock = parseInt(stockData.stock_qty || 0, 10);

            if (currentQty >= stock) {
            showToast(`You already added all ${stock} items to your cart.`, "warning");
            return;
            }

            //  ถ้ายังไม่เต็ม → เพิ่มเข้า cart ได้อีก 1 ชิ้น
            const res = await fetch("/cart/add", {
            method: "POST",
            credentials: "include",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN":
                document.querySelector('meta[name="csrf-token"]')?.content ||
                "{{ csrf_token() }}"
            },
            body: JSON.stringify({ product_id: productId, qty: 1 })
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
            showToast("Item added to cart successfully!");
            } else {
            showToast("Unable to add item.", "error");
            }
        } catch (err) {
            console.error("Add to cart failed:", err);
            window.location.href = "{{ route('login') }}"; //  เด้ง login ทันทีถ้ามี error ใด ๆ
        }
    };



});
</script>
@endpush

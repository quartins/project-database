<header 
    class="shadow-md" 
    style="background: radial-gradient(circle at center, #ffffffff, #fed8eeff, #ffd1ebff)">
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        
        <!-- Center: Logo -->
        <div class="flex-1 flex justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
        </div>

        <!-- Profile & Cart -->
        <div class="absolute right-6 flex items-center space-x-4">
            @auth
                {{-- ถ้า login แล้ว --}}
                <a href="{{ route('cart.index') }}" class="relative hover:text-pink-600 transition">
                    <img src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
                    <span id="cart-count"
                          class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full 
                                 w-5 h-5 flex items-center justify-center hidden">0</span>
                </a>
                <a href="{{ route('profile.custom') }}" class="hover:text-pink-600">
                    <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
                </a>
            @else
                {{-- ถ้ายังไม่ได้ login ให้เด้งไปหน้า login --}}
                <a href="{{ route('login') }}" class="relative hover:text-pink-600 transition">
                    <img src="{{ asset('images/cart.png') }}" alt="Cart (login first)" class="h-6">
                    <span id="cart-count"
                          class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full 
                                 w-5 h-5 flex items-center justify-center hidden">0</span>
                </a>
                <a href="{{ route('login') }}" class="hover:text-pink-600">
                    <img src="{{ asset('images/user.png') }}" alt="Profile (login first)" class="h-5">
                </a>
            @endauth
        </div>
    </div>

    {{-- ดึงจำนวนสินค้าใน cart ทุกครั้งที่โหลดหน้า --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cartCountEl = document.getElementById("cart-count");
            if (!cartCountEl) return;

            fetch("/cart/count")
                .then(res => {
                    if (res.status === 401) return { count: 0 }; // ถ้ายังไม่ได้ login
                    return res.json();
                })
                .then(data => {
                    const count = data.count || 0;
                    cartCountEl.textContent = count;

                    if (count > 0) {
                        cartCountEl.classList.remove("hidden");
                    } else {
                        cartCountEl.classList.add("hidden");
                    }
                })
                .catch(() => cartCountEl.classList.add("hidden"));
        });
    </script>
</header>

<header 
    class="shadow-md"
    style="background: radial-gradient(circle at center, #ffffff, #fed8ee, #ffd1eb)">
    
    {{-- หน้า Home --}}
    @if (Request::is('/'))
    <div class="max-w-7xl mx-auto grid grid-cols-3 items-center px-6 py-4">
        
        {{--  Search Box (ซ้าย) --}}
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

        {{--  Logo (กลาง) --}}
        <div class="flex justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
        </div>

        {{--  Cart + User (ขวา) --}}
        <div class="flex justify-end items-center space-x-4">
            @auth
                <a href="{{ route('cart.index') }}" class="relative hover:opacity-80 transition">
                    <img id="cart-icon" src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
                    <span id="cart-count"
                          class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full 
                                 w-5 h-5 flex items-center justify-center hidden">0</span>
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

    {{-- ถ้าไม่ใช่หน้า Home (เช่น /cart, /profile, /about, /contact) --}}
    @else
    <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
        
        {{--  Logo (ฝั่งซ้าย) --}}
        <div class="flex justify-start">
            <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
        </div>

        {{--  Cart + User (ขวา) --}}
        <div class="flex justify-end items-center space-x-4">
            @auth
                <a href="{{ route('cart.index') }}" class="relative hover:opacity-80 transition">
                    <img id="cart-icon" src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
                    <span id="cart-count"
                          class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full 
                                 w-5 h-5 flex items-center justify-center hidden">0</span>
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
    @endif
</header>

{{--  JS Cart Counter --}}
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const cartCountEl = document.getElementById("cart-count");
    if (!cartCountEl) return;

    fetch("/cart/count")
        .then(res => res.ok ? res.json() : { count: 0 })
        .then(data => {
            const count = data.count || 0;
            cartCountEl.textContent = count;
            cartCountEl.classList.toggle("hidden", count <= 0);
        })
        .catch(() => cartCountEl.classList.add("hidden"));
});
</script>
@endpush

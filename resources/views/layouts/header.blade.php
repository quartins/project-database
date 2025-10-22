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
                          bg-white border border-gray-300 
                          focus:ring-pink-400 focus:border-pink-500 shadow-sm" />
            <img src="{{ asset('images/search.png') }}" 
                 alt="Search Icon" 
                 class="absolute right-2 top-1/2 -translate-y-1/2 w-4 h-4 opacity-80">
        </div>

        <!-- Center: Logo -->
        <div class="flex justify-center">
            <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14"></a>
        </div>

        <!-- Profile & Cart -->
        <div class="flex justify-end items-center space-x-4">
            @auth
                {{-- ถ้า login แล้ว --}}
                <a href="{{ route('cart.index') }}" id="cart-icon" class="relative hover:opacity-80 transition">
                    <img src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">0</span>
                </a>
                <a href="{{ route('profile.custom') }}" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
                </a>
            @else
                {{-- ถ้ายังไม่ได้ login --}}
                <a href="{{ route('login') }}" class="relative hover:opacity-80 transition">
                    <img src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
                </a>
                <a href="{{ route('login') }}" class="hover:opacity-80 transition">
                    <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
                </a>
            @endauth
        </div>
    </div> 
</header>
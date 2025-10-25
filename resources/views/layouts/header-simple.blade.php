<!-- layouts/header-simple.blade.php -->
<header class="shadow-md" style="background: radial-gradient(circle at center, #ffffff, #fed8ee, #ffd1eb)">
  <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

    {{-- 🌸 Logo --}}
    <a href="/">
      <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
    </a>

    {{-- 🛒 Cart + User --}}
    <div class="flex items-center space-x-4">
      @auth
          <a href="{{ route('cart.index') }}" class="relative hover:opacity-80 transition">
              <img src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
              <span id="cart-count"
                    class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full 
                           w-5 h-5 flex items-center justify-center hidden">0</span>
          </a>
          <a href="{{ route('profile.custom') }}" class="hover:opacity-80 transition">
              <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
          </a>
      @else
          <a href="{{ route('login') }}" class="hover:opacity-80 transition">
              <img src="{{ asset('images/user.png') }}" alt="Login" class="h-5">
          </a>
      @endauth
    </div>
  </div>
</header>

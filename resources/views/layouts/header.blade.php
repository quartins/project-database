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
            <a href="/cart" class="hover:text-pink-600">
                <img src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
            </a>
            <a href="/myprofile" class="hover:text-pink-600">
                <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
            </a>
        </div>
    </div>
</header>

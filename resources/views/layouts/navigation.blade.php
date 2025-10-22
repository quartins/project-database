<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamora</title>
    @vite('resources/css/app.css') 
    @vite('resources/js/app.js')
</head>
<body class="bg-gradient-to-b from-pink-100 to-yellow-100 min-h-screen">
   

    {{-- Navbar --}}
        <nav class="bg-[#7B4B3A] shadow-sm relative z-50">
            <div class="max-w-6xl mx-auto flex justify-center space-x-14 py-3 text-base font-medium">
                <a href="/" class="text-white hover:text-pink-200 transition">Home</a>

                {{-- Collection dropdown --}}
                <div class="relative group">
                    <a href="{{ route('collection.index') }}" class="text-white hover:text-pink-200 transition">Collection</a>

                    {{--  dropdown --}}
                    <div class="absolute left-1/2 -translate-x-1/2 top-full mt-3
                                w-[700px] bg-white shadow-lg rounded-xl py-6 px-8
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                transition-all duration-300 ease-in-out">
                        
                        {{--  collection --}}
                        <div class="grid grid-cols-5 gap-6 text-center">
                            <a href="/collection/kitty" class="flex flex-col items-center hover:scale-105 transition">
                                <img src="{{ asset('collection/kitty/kitty1.png') }}" class="w-20 h-20 object-contain mb-2">
                                <span class="text-sm font-semibold text-[#7B4B3A]">Kitty</span>
                            </a>
                            <a href="/collection/mymelody" class="flex flex-col items-center hover:scale-105 transition">
                                <img src="{{ asset('collection/mymelody/mymelody1.png') }}" class="w-20 h-20 object-contain mb-2">
                                <span class="text-sm font-semibold text-[#7B4B3A]">My Melody</span>
                            </a>
                            <a href="/collection/kuromi" class="flex flex-col items-center hover:scale-105 transition">
                                <img src="{{ asset('collection/kuromi/kuromi1.png') }}" class="w-20 h-20 object-contain mb-2">
                                <span class="text-sm font-semibold text-[#7B4B3A]">Kuromi</span>
                            </a>
                            <a href="/collection/hirono" class="flex flex-col items-center hover:scale-105 transition">
                                <img src="{{ asset('collection/hirono/hirono1.png') }}" class="w-20 h-20 object-contain mb-2">
                                <span class="text-sm font-semibold text-[#7B4B3A]">Hirono</span>
                            </a>
                            <a href="/collection/twinkle" class="flex flex-col items-center hover:scale-105 transition">
                                <img src="{{ asset('collection/twinkle/twinkle1.png') }}" class="w-20 h-20 object-contain mb-2">
                                <span class="text-sm font-semibold text-[#7B4B3A]">Twinkle</span>
                            </a>
                        </div>
                    </div>
                </div>

                <a href="/about" class="text-white hover:text-pink-200 transition">About</a>
                <a href="/contact" class="text-white hover:text-pink-200 transition">Contact</a>
            </div>
        </nav>
</header>

{{--  Script: Cart Count --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const cartCountEl = document.getElementById("cart-count");
        const cartIconEl  = document.getElementById("cart-icon");

        let count = parseInt(localStorage.getItem("cartCount") || "0", 10);
        if (count > 0) {
            cartCountEl.textContent = count;
            cartCountEl.classList.remove("hidden");
        }

        window.addToCart = function () {
            count += 1;
            localStorage.setItem("cartCount", count);
            cartCountEl.textContent = count;
            cartCountEl.classList.remove("hidden");
            cartIconEl.classList.add("animate-bounce");
            setTimeout(() => cartIconEl.classList.remove("animate-bounce"), 600);
        };
    });
</script>

</body>
</html>
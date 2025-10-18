<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamora</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gradient-to-b from-pink-100 to-yellow-100 min-h-screen">
   
    <!-- Header -->
    <header 
        class="shadow-md" 
        style="background: radial-gradient(circle at center, #ffffffff, #fed8eeff, #ffd1ebff)">
        <div class="max-w-7xl mx-auto grid grid-cols-3 items-center px-6 py-4">
            
            <!-- Search Box -->
            <div class="relative w-48">
                <input type="text" 
                    placeholder="Search..." 
                    class="w-full px-3 py-1.5 pr-8 text-sm rounded-full 
                            bg-white border border-brown-500 
                            focus:ring-brown-400 focus:border-brown-600 shadow-sm" />

                <!-- Search Icon -->
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
                <a href="/cart" class="hover:text-pink-600">
                    <img src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
                </a>
                <a href="/myprofile" class="hover:text-pink-600">
                    <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->


</body>
</html>

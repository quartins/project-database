<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamora | Login</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

    <!-- Header -->
    <header 
        class="shadow-md border-b border-[#8B4513]" 
        style="background: radial-gradient(circle at center, #ffffffff, #fed8eeff, #ffd1ebff)">
        <div class="max-w-7xl mx-auto flex justify-center items-center py-4">
            <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
        </div>
    </header>


    <!-- Login Section -->
        <main class="flex-1 flex items-center justify-center px-4"
            style="background: linear-gradient(to bottom, #ffe1f2ff, #ffffffff, #fffdd6ff)">
        <div class="w-full max-w-md">

            <!-- Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <!-- หัวข้อใช้ Mystery Quest -->
                    <h2 class="text-3xl font-crimson font-bold text-center mb-8 text-gray-800">Login</h2>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-5">
                            <label for="email" class="block text-gray-700 mb-1 font-crimson">Email</label>
                            <div class="flex items-center border border-[#503434] rounded-lg px-3 shadow-md">
                                <img src="{{ asset('images/user.png') }}" alt="User Icon" class="w-4 h-4 opacity-70 mr-2">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                    class="w-full border-0 focus:ring-0 placeholder-gray-400 font-crimson" placeholder="Enter your email">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 mb-1 font-crimson">Password</label>
                            <div class="flex items-center border border-[#503434] rounded-lg px-3 shadow-md">
                                <img src="{{ asset('images/key.png') }}" alt="Lock Icon" class="w-5 h-5 opacity-70 mr-2">
                                <input id="password" type="password" name="password" required
                                    class="w-full border-0 focus:ring-0 placeholder-gray-400 font-crimson" placeholder="Enter your password">
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="text-center">
                            <button 
                                type="submit"
                                class="w-40 bg-pink-200 hover:bg-pink-300 text-gray-800 font-semibold py-2 rounded-lg shadow-md transition font-crimson">
                                Login
                            </button>
                        </div>

                    </form>

                    <!-- Register Link -->
                    <p class="mt-6 text-center text-gray-700 font-crimson">
                        Don’t have an account ?
                        <a href="{{ route('register') }}" class="font-bold text-brown-600 hover:text-pink-500">
                            Register
                        </a>
                    </p>
                </div>

            
        </div>
    </main>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        // เคลียร์ข้อมูล cart ที่ค้างอยู่ใน localStorage ทุกครั้งที่มาหน้า login
        localStorage.removeItem("cartItems");
        localStorage.removeItem("cartCount");

        // ถ้ามี session จากหน้า cart ค้างอยู่ใน Browser ก็ล้างด้วย
        sessionStorage.removeItem("cartItems");
        sessionStorage.removeItem("cartCount");
    });
</script>


</body>
</html>

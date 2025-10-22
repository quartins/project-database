<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamora | Register</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

    <!-- Register Section -->
    <main class="flex-1 flex items-center justify-center px-4"
          style="background: linear-gradient(to bottom, #ffe1f2ff, #ffffffff, #fffdd6ff)">
        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-6 items-center">

            <!-- Left: Logo + Illustration -->
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-20 mb-6">
                <img src="{{ asset('images/sanrio.png') }}" alt="Cute Illustration" class="w-72">
                <p class="font-crimson mt-6 text-gray-700">
                    Already have an account ?
                    <a href="{{ route('login') }}" class="font-bold text-brown-600 hover:text-pink-500">Login</a>
                </p>
            </div>

            <!-- Right: Card with Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-3xl font-crimson font-bold text-center mb-8 text-gray-800 ">Register</h2>
        @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc ml-5">
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
                     @endforeach
                </ul>
            </div>
        @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Username -->
                    <div class="mb-4">
                        <label for="username" class="font-crimson block text-gray-700 mb-1">Username</label>
                        <div class="flex items-center border border-[#503434] rounded-lg px-3 shadow-md focus-within:shadow-lg transition">
                            <img src="{{ asset('images/user.png') }}" alt="User Icon" class="w-4 h-4 opacity-70 mr-2">
                            <input id="username" type="text" name="username" value="{{ old('username') }}" required
                                   class="font-crimson w-full border-0 focus:ring-0 placeholder-gray-400" placeholder="username">
                        </div>
                    </div>

                    <!-- Firstname / Lastname -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="firstname" class="font-crimson block text-gray-700 mb-1">Firstname</label>
                            <div class="flex items-center border border-[#503434] rounded-lg px-3 shadow-md focus-within:shadow-lg transition">
                                <input id="firstname" type="text" name="firstname" value="{{ old('firstname') }}" required
                                       class="font-crimson w-full border-0 focus:ring-0 placeholder-gray-400" placeholder="firstname">
                            </div>
                        </div>
                        <div>
                            <label for="lastname" class="font-crimson block text-gray-700 mb-1">Lastname</label>
                            <div class="flex items-center border border-[#503434] rounded-lg px-3 shadow-md focus-within:shadow-lg transition">
                                <input id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" required
                                       class="font-crimson w-full border-0 focus:ring-0 placeholder-gray-400" placeholder="lastname">
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="font-crimson block text-gray-700 mb-1">Email</label>
                        <div class="flex items-center border border-[#503434] rounded-lg px-3 
                            shadow-md focus-within:shadow-lg transition">
                            <img src="{{ asset('images/user.png') }}" alt="Email Icon" class="w-4 h-4 opacity-70 mr-2">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="font-crimson w-full border-0 focus:ring-0 placeholder-gray-400" placeholder="email">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="font-crimson block text-gray-700 mb-1">Password</label>
                        <div class="flex items-center border border-[#503434] rounded-lg px-3 shadow-md focus-within:shadow-lg transition">
                            <img src="{{ asset('images/key.png') }}" alt="Key Icon" class="w-5 h-5 opacity-70 mr-2">
                            <input id="password" type="password" name="password" required
                                   class="font-crimson w-full border-0 focus:ring-0 placeholder-gray-400" placeholder="password">
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="font-crimson block text-gray-700 mb-1">Confirm Password</label>
                        <div class="flex items-center border border-[#503434] rounded-lg px-3 shadow-md focus-within:shadow-lg transition">
                            <img src="{{ asset('images/key.png') }}" alt="Key Icon" class="w-5 h-5 opacity-70 mr-2">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="font-crimson w-full border-0 focus:ring-0 placeholder-gray-400" placeholder="confirm password">
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="text-center">
                        <button 
                            type="submit"
                            class="w-40 bg-pink-200 hover:bg-pink-300 text-gray-800 font-semibold py-2 rounded-lg shadow-md transition font-crimson">
                            Create account
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </main>

</body>
</html>

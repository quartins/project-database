<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name', 'Chamora'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Mystery+Quest&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-serif min-h-screen antialiased bg-transparent overflow-x-hidden">

    {{-- 🌸 Header + Navbar (เลือกตามหน้า) --}}
    <header>
        @if (
            Request::is('about') || 
            Request::is('contact') || 
            Request::is('products/*') || 
            Request::is('profile*') || 
            Request::is('orders*') || 
            Request::is('order-summary*') || 
            Request::is('address*') || 
            Request::is('payment*') || 
            Request::is('checkout*') || 
            Request::is('cart*')
        )
            {{-- ✅ ใช้ header-simple ไม่มีช่อง search --}}
            @include('layouts.header-simple')
        @else
            {{-- ✅ ใช้ header ปกติ (มีช่อง search) --}}
            @include('layouts.header')
        @endif

        @include('layouts.navigation')
    </header>

    {{-- 🌼 Main --}}
    <main class="min-h-[80vh] px-0 pt-0 mt-0">
        @yield('content')
    </main>

    {{-- 🍋 Footer → แสดงเฉพาะหน้า Home --}}
    @if (Request::is('/'))
        <footer class="mt-0 py-6 text-center text-gray-600 text-sm bg-yellow-50 shadow-none border-0">
            © 2025 Chamora | All Rights Reserved
        </footer>
    @endif

    @stack('scripts')
    @yield('scripts')
</body>
</html>

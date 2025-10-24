<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Chamora'))</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Mystery+Quest&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-serif min-h-screen antialiased bg-transparent overflow-x-hidden">

    {{-- Header + Navbar --}}
    <header>
        @include('layouts.header')
        @include('layouts.navigation')
    </header>

    {{-- Main --}}
    <main class="min-h-[80vh] px-0 pt-0 mt-0">
        @yield('content')
    </main>

    {{-- Footer → แสดงเฉพาะหน้า Home --}}
    @if (Request::is('/'))
        <footer class="mt-0 py-6 text-center text-gray-600 text-sm bg-yellow-100 shadow-none border-0">
            © 2025 Chamora | All Rights Reserved
        </footer>
    @endif

    @stack('scripts')
    @yield('scripts')
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Chamora') }}</title>

        <!-- โหลดฟอนต์ -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Mystery+Quest&display=swap" rel="stylesheet">

        <!-- Scripts / CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        @include('layouts.header')
        @include('layouts.navigation')

        <main>
            @yield('content')
        </main>

         {{-- ดึงจำนวนสินค้าใน cart ทุกครั้งที่โหลดหน้า --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cartCountEl = document.getElementById("cart-count");
            if (!cartCountEl) return;

            fetch("/cart/count")
                .then(res => {
                    if (res.status === 401) return { count: 0 }; // ถ้ายังไม่ได้ login
                    return res.json();
                })
                .then(data => {
                    const count = data.count || 0;
                    cartCountEl.textContent = count;

                    if (count > 0) {
                        cartCountEl.classList.remove("hidden");
                    } else {
                        cartCountEl.classList.add("hidden");
                    }
                })
                .catch(() => cartCountEl.classList.add("hidden"));
        });
    </script>
    </body>
</html>
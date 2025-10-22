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
    <body class="antialiased font-serif">
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

        window.addToCart = function (productId) {
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // ส่ง Token ป้องกันการโจมตี
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(res => {
                if (res.status === 401) {
                    // ถ้า user ยังไม่ login ให้เด้งไปหน้า login
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                if (!res.ok) { throw new Error('Network response was not ok'); }
                return res.json();
            })
            .then(data => {
                if (data?.cart_count !== undefined) {
                    const cartCountEl = document.getElementById("cart-count");

                    // อัปเดตตัวเลขบนไอคอนตะกร้า
                    cartCountEl.textContent = data.cart_count;
                    cartCountEl.classList.remove("hidden");

                    // เพิ่มเอฟเฟกต์เด้งเพื่อเป็น Feedback
                    const cartIcon = document.getElementById("cart-icon");
                    if (cartIcon) {
                        cartIcon.classList.add("animate-bounce");
                        setTimeout(() => cartIcon.classList.remove("animate-bounce"), 600);
                    }
                }
            })
            .catch(err => {
                console.error("Add to cart failed:", err);
                alert('Failed to add product to cart.');
            });
        };
        
    </script>
    </body>
</html>
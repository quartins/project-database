<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamora | My Cart</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-[#FFF8F8] font-serif min-h-screen">
    {{-- 🩷 Header --}}
    <header class="shadow-md" style="background: radial-gradient(circle at center, #ffffff, #fed8ee, #ffd1eb)">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
            </div>
            <div class="flex items-center gap-5 relative">
                <a href="/cart" class="relative">
                    <img id="cart-icon" src="{{ asset('images/cart.png') }}" class="h-6">
                    <span id="cart-count" 
                          class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full w-5 h-5 flex justify-center items-center {{ $items->count() ? '' : 'hidden' }}">
                        {{ $items->sum('quantity') }}
                    </span>
                </a>
                <a href="/myprofile"><img src="{{ asset('images/user.png') }}" class="h-5"></a>
            </div>
        </div>
    </header>

    @include('layouts.navigation')

    {{-- 🛒 Cart Content --}}
    <main class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-[#7B4B3A] mb-6">
            My Cart ( {{ $items->count() }} )
        </h1>
        <hr class="border-[#7B4B3A] mb-10">

        @if ($items->isEmpty())
            <div class="text-center text-gray-500 italic py-10 bg-pink-50 rounded-lg shadow">Your cart is empty 💕</div>
        @else
        <div class="flex gap-10 flex-col lg:flex-row">
            {{-- Left --}}
            <div class="w-full lg:w-2/3 bg-[#FFF8F8] p-6 rounded-lg border border-gray-300 shadow-sm" id="cart-container">
                <div class="flex items-center mb-4">
                    <input id="select-all" type="checkbox" class="mr-2 w-4 h-4 accent-[#7B4B3A]">
                    <span class="text-sm text-gray-600">select all</span>
                </div>

                @foreach ($items as $item)
                    <div class="cart-item flex justify-between items-center border border-gray-300 rounded-md p-4 mb-6"
                        data-id="{{ $item->product->id }}"
                        data-price="{{ $item->product->price }}">
                        <div class="flex items-center gap-5">
                            <input type="checkbox" class="item-check accent-[#7B4B3A]">
                            <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-contain rounded-md border border-gray-200">
                            <div>
                                <h3 class="font-semibold text-[#7B4B3A]">{{ $item->product->name }}</h3>
                                <p class="text-gray-700 mt-1 font-medium">฿ {{ number_format($item->product->price, 1) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="plus-btn border border-[#7B4B3A] rounded-full w-6 h-6 flex justify-center items-center text-[#7B4B3A] hover:bg-[#7B4B3A] hover:text-white transition">+</button>
                            <span class="quantity text-gray-800 font-medium">{{ $item->quantity }}</span>
                            <button class="minus-btn border border-[#7B4B3A] rounded-full w-6 h-6 flex justify-center items-center text-[#7B4B3A] hover:bg-[#7B4B3A] hover:text-white transition">−</button>
                           <button type="button"
                                class="remove-btn text-gray-400 hover:text-pink-600 text-xl ml-4"
                                data-id="{{ $item->product->id }}">
                            &times;
                        </button>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Right --}}
            <div class="w-full lg:w-1/3 bg-[#FFF8F8] p-6 rounded-lg border border-gray-300 shadow-sm">
                <h2 class="text-xl font-semibold text-[#7B4B3A] mb-4">Order Summary</h2>
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>Subtotal</span>
                    <span id="subtotal">฿ 0.0</span>
                </div>
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>Shipping</span>
                    <span class="text-sm">calculate next step</span>
                </div>
                <div class="border-t border-gray-300 my-3"></div>
                <div class="flex justify-between font-semibold text-[#7B4B3A] text-lg mb-6">
                    <span>Total</span>
                    <span id="total">฿ 0.0 THB</span>
                </div>
                <button class="w-full bg-gradient-to-r from-[#7B4B3A] to-[#A17E6E] text-white font-semibold py-2.5 rounded-full shadow-md hover:opacity-90 transition">
                    Check Out
                </button>
            </div>
        </div>
        @endif
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const subtotalEl = document.getElementById("subtotal");
            const totalEl = document.getElementById("total");
            const selectAll = document.getElementById("select-all");
            const cartContainer = document.getElementById("cart-container");
            const cartCountEl = document.getElementById("cart-count");
            const myCartTitle = document.querySelector("h1");

            //  คำนวณ subtotal เฉพาะสินค้าที่ select
            function calcSubtotal() {
                let subtotal = 0;
                document.querySelectorAll(".cart-item").forEach(item => {
                    const check = item.querySelector(".item-check");
                    const qty = parseInt(item.querySelector(".quantity").textContent);
                    const price = parseFloat(item.dataset.price);
                    if (check.checked) subtotal += price * qty;
                });
                subtotalEl.textContent = `฿ ${subtotal.toFixed(1)}`;
                totalEl.textContent = `฿ ${subtotal.toFixed(1)} THB`;
            }

            //  อัปเดต select-all ให้ตรงกับ checkbox รายการ
            function updateSelectAllStatus() {
                const allChecks = document.querySelectorAll(".item-check");
                const checked = document.querySelectorAll(".item-check:checked");
                selectAll.checked = allChecks.length > 0 && checked.length === allChecks.length;
            }

            //  อัปเดตจำนวนรวมทั้งหมด (ไม่เกี่ยวกับ select)
            function updateCartCount() {
                let totalQty = 0;
                document.querySelectorAll(".cart-item").forEach(item => {
                    const qty = parseInt(item.querySelector(".quantity").textContent);
                    totalQty += qty;
                });

                // อัปเดตหัวข้อ My Cart (x)
                myCartTitle.textContent = `My Cart (${totalQty})`;

                // อัปเดต icon cart
                if (cartCountEl) {
                    cartCountEl.textContent = totalQty;
                    if (totalQty > 0) {
                        cartCountEl.classList.remove("hidden");
                        cartCountEl.classList.add("scale-125");
                        setTimeout(() => cartCountEl.classList.remove("scale-125"), 300);
                    } else {
                        cartCountEl.classList.add("hidden");
                    }
                }
            }

            // กด + / - / remove (x)
            cartContainer.addEventListener("click", async (e) => {
                const item = e.target.closest(".cart-item");
                if (!item) return;

                const productId = item.dataset.id;
                let qty = parseInt(item.querySelector(".quantity").textContent);

                // เพิ่มสินค้า
                if (e.target.classList.contains("plus-btn")) qty++;

                // ลดสินค้า
                if (e.target.classList.contains("minus-btn") && qty > 1) qty--;

                //  ลบสินค้า
                if (e.target.classList.contains("remove-btn")) {
                    e.preventDefault(); //  ป้องกันไม่ให้ form submit หรือ reload หน้า

                    await fetch("/cart/remove", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({ product_id: productId })
                    });
                    
                    // Fade-out effect แล้วลบ element
                    item.classList.add("opacity-0", "translate-x-4", "transition-all", "duration-300");
                    setTimeout(() => item.remove(), 300);

                    updateCartCount();
                    calcSubtotal();
                    return;
                }


                //  อัปเดตใน DB
                const res = await fetch("/cart/update", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: qty
                    })
                });

                const data = await res.json();
                item.querySelector(".quantity").textContent = qty;

                updateCartCount();
                calcSubtotal();
            });

            // เลือกทั้งหมด
            selectAll.addEventListener("change", () => {
                document.querySelectorAll(".item-check").forEach(chk => chk.checked = selectAll.checked);
                calcSubtotal();
            });

            // เปลี่ยน select รายการเดียว
            document.querySelectorAll(".item-check").forEach(chk =>
                chk.addEventListener("change", () => {
                    calcSubtotal();
                    updateSelectAllStatus();
                })
            );

            //  โหลดหน้าครั้งแรก
            updateCartCount();
            calcSubtotal();
        });
        </script>

</body>
</html>

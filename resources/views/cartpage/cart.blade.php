@extends('layouts.app')

@section('title', 'Chamora | My Cart')

@section('content')
<main class="bg-[#FFF8F8] font-serif min-h-screen">
    
    {{-- 🛒 Cart Content --}}
    <div class="max-w-7xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-[#7B4B3A] mb-6">
            My Cart ( {{ $items->count() }} )
        </h1>
        <hr class="border-[#7B4B3A] mb-10">

        @if ($items->isEmpty())
            <div class="text-center text-gray-500 italic py-10 bg-pink-50 rounded-lg shadow">
                Your cart is empty 💕
            </div>
        @else
        <div class="flex gap-10 flex-col lg:flex-row">
            {{-- Left --}}
            <div id="cart-container" class="w-full lg:w-2/3 bg-[#FFF8F8] p-6 rounded-lg border border-gray-300 shadow-sm">
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
                            <img src="{{ asset($item->product->image_url) }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-24 h-24 object-contain rounded-md border border-gray-200">
                            <div>
                                <h3 class="font-semibold text-[#7B4B3A]">{{ $item->product->name }}</h3>
                                <p class="text-gray-700 mt-1 font-medium">฿ {{ number_format($item->product->price, 1) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="minus-btn border border-[#7B4B3A] rounded-full w-6 h-6 flex justify-center items-center text-[#7B4B3A] hover:bg-[#7B4B3A] hover:text-white transition">−</button>
                            <span class="quantity text-gray-800 font-medium">{{ $item->quantity }}</span>
                            <button class="plus-btn border border-[#7B4B3A] rounded-full w-6 h-6 flex justify-center items-center text-[#7B4B3A] hover:bg-[#7B4B3A] hover:text-white transition">+</button>

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

                {{--  ปุ่ม Check Out: ส่งเฉพาะสินค้าที่ "ติ๊กเลือก" --}}
                <form id="checkoutForm" action="{{ route('cart.checkout') }}" method="POST" class="mt-2">
                    @csrf
                    {{--  Hidden input ที่ใช้ส่ง JSON --}}
                    <input type="hidden" name="items" id="itemsField">

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-[#7B4B3A] to-[#C79A8B] text-white
                               font-semibold py-3 rounded-full shadow-md hover:opacity-90 active:translate-y-[1px] transition">
                        Check Out
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</main>
@endsection


{{-- Script logic --}}
@section('scripts')
@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const subtotalEl = document.getElementById("subtotal");
    const totalEl = document.getElementById("total");
    const selectAll = document.getElementById("select-all");
    const cartContainer = document.getElementById("cart-container");
    const cartCountEl = document.getElementById("cart-count");
    const myCartTitle = document.querySelector("h1");
    const checkoutForm = document.getElementById("checkoutForm");
    const itemsField = document.getElementById("itemsField");

    /**  คำนวณ Subtotal */
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

    /**  อัปเดตสถานะ select all */
    function updateSelectAllStatus() {
        const allChecks = document.querySelectorAll(".item-check");
        const checked = document.querySelectorAll(".item-check:checked");
        selectAll.checked = allChecks.length > 0 && checked.length === allChecks.length;
    }

    /**  อัปเดตจำนวนสินค้าทั้งหมดในหัวตะกร้า */
    function updateCartCount() {
        let totalQty = 0;
        document.querySelectorAll(".cart-item").forEach(item => {
            const qty = parseInt(item.querySelector(".quantity").textContent);
            totalQty += qty;
        });

        myCartTitle.textContent = `My Cart (${totalQty})`;

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

    /**  ตรวจสอบ stock ก่อน checkout */
    if (checkoutForm) {
        checkoutForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const selected = [];
            document.querySelectorAll(".cart-item").forEach(item => {
                const chk = item.querySelector(".item-check");
                if (chk && chk.checked) {
                    const productId = parseInt(item.dataset.id, 10);
                    const qty = parseInt(item.querySelector(".quantity").textContent, 10) || 1;
                    selected.push({ product_id: productId, qty });
                }
            });

            if (selected.length === 0) {
                alert("Please select at least one item to proceed.");
                return;
            }

            try {
                const res = await fetch("/cart/check-stock", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
                    },
                    body: JSON.stringify({ items: selected })
                });

                const data = await res.json();

                if (!res.ok || data.error) {
                    alert(data.message || "Some items exceed available stock. Please adjust your cart.");
                    return;
                }

                itemsField.value = JSON.stringify(selected);
                checkoutForm.submit();
            } catch (err) {
                alert("Unable to verify stock. Please try again later.");
                console.error(err);
            }
        });
    }

    /**  จัดการคลิกภายใน cart (เพิ่ม/ลด/ลบสินค้า) */
    cartContainer.addEventListener("click", async (e) => {
        const item = e.target.closest(".cart-item");
        if (!item) return;

        const productId = item.dataset.id;
        let qty = parseInt(item.querySelector(".quantity").textContent);

        //  ตรวจ stock ก่อนเพิ่ม
        if (e.target.classList.contains("plus-btn")) {
            const resStock = await fetch(`/cart/get-stock/${productId}`);
            const data = await resStock.json();
            if (qty + 1 > data.stock_qty) {
                alert(`Sorry, only ${data.stock_qty} items left in stock.`);
                return;
            }
            qty++;
        }

        if (e.target.classList.contains("minus-btn")) {
            if (qty > 1) qty--;
            else {
                await fetch("/cart/remove", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
                    },
                    body: JSON.stringify({ product_id: productId })
                });
                item.remove();
                updateCartCount();
                calcSubtotal();
                return;
            }
        }

        if (e.target.classList.contains("remove-btn")) {
            e.preventDefault();
            const res = await fetch("/cart/remove", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
                },
                body: JSON.stringify({ product_id: productId })
            });

            if (!res.ok) return;
            item.remove();
            updateCartCount();
            calcSubtotal();
            return;
        }

        //  update quantity
        const res = await fetch("/cart/update", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name=\"csrf-token\"]').content
            },
            body: JSON.stringify({ product_id: productId, quantity: qty })
        });

        if (res.ok) {
            item.querySelector(".quantity").textContent = qty;
            updateCartCount();
            calcSubtotal();
        }
    });

    selectAll.addEventListener("change", () => {
        document.querySelectorAll(".item-check").forEach(chk => chk.checked = selectAll.checked);
        calcSubtotal();
    });

    document.querySelectorAll(".item-check").forEach(chk =>
        chk.addEventListener("change", () => {
            calcSubtotal();
            updateSelectAllStatus();
        })
    );

    updateCartCount();
    calcSubtotal();
});
</script>
@endsection

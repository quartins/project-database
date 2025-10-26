<!-- resources/views/layouts/header-simple.blade.php -->
<header class="shadow-md" style="background: radial-gradient(circle at center, #ffffff, #fed8ee, #ffd1eb)">
  <div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-4">

    {{-- 🌸 Logo --}}
    <a href="/">
      <img src="{{ asset('images/logo.png') }}" alt="Chamora Logo" class="h-14">
    </a>

    {{-- 🛒 Cart + User --}}
    <div class="flex items-center space-x-4">
      @auth
          <a href="{{ route('cart.index') }}" class="relative hover:opacity-80 transition">
              <img id="cart-icon" src="{{ asset('images/cart.png') }}" alt="Cart" class="h-6">
              <span id="cart-count"
                    class="absolute -top-2 -right-2 bg-pink-600 text-white text-xs font-bold rounded-full 
                           w-5 h-5 flex items-center justify-center hidden transition-transform duration-300">0</span>
          </a>
          <a href="{{ route('profile.custom') }}" class="hover:opacity-80 transition">
              <img src="{{ asset('images/user.png') }}" alt="Profile" class="h-5">
          </a>
      @else
          <a href="{{ route('login') }}" class="relative hover:opacity-80 transition">
              <img id="cart-icon" src="{{ asset('images/cart.png') }}" alt="Cart (login first)" class="h-6">
          </a>
          <a href="{{ route('login') }}" class="hover:opacity-80 transition">
              <img src="{{ asset('images/user.png') }}" alt="Profile (login first)" class="h-5">
          </a>
      @endauth
    </div>
  </div>
</header>

{{-- 💫 Toast Popup --}}
<div id="toast"
     class="fixed inset-0 flex items-center justify-center opacity-0 pointer-events-none 
            transition-opacity duration-500 z-50">
    <div class="bg-green-500 text-white text-sm px-6 py-3 rounded-full shadow-lg">
        Added to cart!
    </div>
</div>

@push('scripts')
<script>
function showToast(message = "Added to cart!") {
    const toast = document.getElementById("toast");
    const inner = toast.querySelector("div");
    inner.textContent = message;

    toast.classList.remove("opacity-0", "pointer-events-none");
    toast.classList.add("opacity-100");

    setTimeout(() => {
        toast.classList.remove("opacity-100");
        setTimeout(() => toast.classList.add("pointer-events-none"), 500);
    }, 1000);
}

document.addEventListener("DOMContentLoaded", () => {
    // 🛍 Update cart count
    const cartCountEl = document.getElementById("cart-count");
    if (cartCountEl) {
        fetch("/cart/count")
            .then(res => res.ok ? res.json() : { count: 0 })
            .then(data => {
                const count = data.count || 0;
                cartCountEl.textContent = count;
                cartCountEl.classList.toggle("hidden", count <= 0);
            })
            .catch(() => cartCountEl.classList.add("hidden"));
    }

    // ✅ Add to Cart + Toast
    window.addToCart = async function (productId) {
        try {
            const res = await fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || "{{ csrf_token() }}"
                },
                body: JSON.stringify({ product_id: productId })
            });

            if (res.status === 401) {
                window.location.href = "{{ route('login') }}";
                return;
            }

            const data = await res.json();
            if (data.cart_count !== undefined && cartCountEl) {
                cartCountEl.textContent = data.cart_count;
                cartCountEl.classList.remove("hidden");
                cartCountEl.classList.add("scale-125");
                setTimeout(() => cartCountEl.classList.remove("scale-125"), 200);

                showToast("Added to cart!");
            }
        } catch (err) {
            console.error("Add to cart failed:", err);
        }
    };
});
</script>
@endpush

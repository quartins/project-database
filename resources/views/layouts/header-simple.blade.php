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
function showToast(message = "Added to cart!", type = "success") {
    // 🔹 ลบ toast เดิมก่อน (กันซ้อน)
    document.querySelectorAll(".toast-dynamic").forEach(el => el.remove());

    // 🔹 Container กลางจอ
    let toastContainer = document.getElementById("toast-container-global");
    if (!toastContainer) {
        toastContainer = document.createElement("div");
        toastContainer.id = "toast-container-global";
        toastContainer.style.position = "fixed";
        toastContainer.style.top = "50%";
        toastContainer.style.left = "50%";
        toastContainer.style.transform = "translate(-50%, -50%)";
        toastContainer.style.zIndex = "99999";
        document.body.appendChild(toastContainer);
    }

    // 🔹 สร้าง toast
    const toast = document.createElement("div");
    toast.className = `
        toast-dynamic px-6 py-3 text-white text-sm font-medium rounded-full shadow-lg
        opacity-0 transition-all duration-300 ease-in-out mb-3 text-center
    `;
    toast.textContent = message;

    // 🔹 สีพื้นหลังโทนพาสเทล
    let bg = "#81C784"; // success – เขียวมิ้นต์อ่อน
    if (type === "error") bg = "#E57373";   // แดงพาสเทล
    else if (type === "warning") bg = "#FFB74D"; // ส้มพีชอ่อน
    toast.style.backgroundColor = bg;

    // เพิ่มเข้า container
    toastContainer.appendChild(toast);

    // 🔹 Fade in
    requestAnimationFrame(() => {
        toast.style.opacity = "1";
        toast.style.transform = "scale(1)";
    });

    // 🔹 Fade out แล้วลบทิ้งแน่หลัง 2 วิ
    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "scale(0.9)";
        setTimeout(() => {
            if (toast && toast.parentNode) toast.parentNode.removeChild(toast);
        }, 400);
    }, 1500);
}


document.addEventListener("DOMContentLoaded", () => {
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

                // ✅ แจ้งเตือนสำเร็จ
                showToast("Item added to cart successfully!", "success");
            } else {
                // ⚠️ ถ้าเพิ่มไม่ได้
                showToast("Unable to add item.", "error");
            }
        } catch (err) {
            console.error("Add to cart failed:", err);
            showToast("Please login before adding to cart.", "warning");
        }
    };
});
</script>


@endpush

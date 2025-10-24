{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="bg-[#7B4B3A] shadow-sm relative z-50">
    <div class="max-w-6xl mx-auto flex justify-center space-x-14 py-3 text-base font-medium">
        <a href="/" class="text-white hover:text-pink-200 transition">Home</a>

        {{-- Collection dropdown --}}
        <div class="relative group">
            <a href="{{ route('collection.index') }}" class="text-white hover:text-pink-200 transition">Collection</a>

            {{-- Dropdown menu --}}
            <div class="absolute left-1/2 -translate-x-1/2 top-full mt-3
                        w-[700px] bg-white shadow-lg rounded-xl py-6 px-8
                        opacity-0 invisible group-hover:opacity-100 group-hover:visible
                        transition-all duration-300 ease-in-out">
                <div class="grid grid-cols-5 gap-6 text-center">
                    
                    {{-- ตรวจสอบว่ามีข้อมูล $navCategories ถูกส่งมาหรือไม่ --}}
                    @isset($navCategories)
                        {{-- วนลูปเพื่อแสดง Category แต่ละอัน --}}
                        @foreach ($navCategories as $category)
                            <a href="{{ route('collection.show', $category) }}" class="flex flex-col items-center hover:scale-105 transition">
                                <img src="{{ asset($category->image_url) }}" class="w-20 h-20 object-contain mb-2">
                                <span class="text-sm font-semibold text-[#7B4B3A]">{{ $category->name }}</span> 
                            </a>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>

        <a href="/about" class="text-white hover:text-pink-200 transition">About</a>
        <a href="/contact" class="text-white hover:text-pink-200 transition">Contact</a>
    </div>
</nav>

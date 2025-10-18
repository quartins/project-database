<x-app-layout>
    <div class="bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            {{-- Category Title --}}
            <h1 class="text-4xl font-bold text-center mb-10">{{ $category->name }}</h1>

            {{-- Grid Container for Products --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 sm:gap-8">

                {{-- วนลูปเพื่อแสดง Product Card แต่ละอัน --}}
                @foreach ($products as $product)
                <a href="#" {{-- ในอนาคตสามารถใส่ลิงก์ไปยังหน้ารายละเอียดสินค้าได้ --}}
                   class="group block p-2 sm:p-4 bg-white border border-gray-200 rounded-xl shadow-sm 
                          transition-all duration-300 ease-in-out 
                          hover:shadow-lg hover:-translate-y-1">
                    
                    {{-- Image Container --}}
                    <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden mb-4">
                        <img src="{{ asset($product->image_url) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                    </div>
                    
                    {{-- Product Details --}}
                    <div class="text-left">
                        <h3 class="text-md font-semibold text-gray-800 truncate">{{ $product->name }}</h3>
                        <p class="text-lg text-gray-700 mt-1">฿ {{ number_format($product->price, 2) }}</p>
                    </div>
                </a>
                @endforeach
                {{-- จบการ์ด --}}
                
            </div>
        </div>
    </div>
</x-app-layout>
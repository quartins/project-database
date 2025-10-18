<x-app-layout>
    <div class="bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            
            {{-- Grid Container --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 sm:gap-8">

                {{-- วนลูปเพื่อแสดง Category Card แต่ละอัน --}}
                @foreach ($categories as $category)
                <a href="{{ route('collection.show', $category) }}" 
                   class="group block p-2 sm:p-4 bg-white border border-gray-200 rounded-xl shadow-sm 
                          transition-all duration-300 ease-in-out 
                          hover:shadow-lg hover:-translate-y-1">
                    
                    {{-- Image Container --}}
                    <div class="aspect-square bg-pink-50 rounded-lg overflow-hidden mb-4">
                        <img src="{{ asset($category->image_url) }}" 
                             alt="{{ $category->name }}" 
                             class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                    </div>
                    
                    {{-- Category Name --}}
                    <div class="text-center">
                        <h3 class="text-md sm:text-lg font-semibold text-gray-800">{{ $category->name }}</h3>
                    </div>
                </a>
                @endforeach
                {{-- จบการ์ด --}}
                
            </div>
        </div>
    </div>
</x-app-layout>
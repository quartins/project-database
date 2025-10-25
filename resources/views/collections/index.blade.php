@extends('layouts.app')

@section('title', 'Chamora | Collections')

@section('content')
<div class="bg-white min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Iitle --}}
        <h2 id="section-title" class="text-2xl font-bold text-center text-pink-700 mb-10">
            Our Collections
        </h2>

        {{--  Search Box --}}
        <div id="search-results" class="hidden grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8"></div>

        {{-- category --}}
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            @foreach ($categories as $category)
            <a href="{{ route('collection.show', $category) }}" 
               class="group block p-5 bg-white border border-gray-300 rounded-lg shadow-sm 
                      transition duration-300 ease-in-out 
                      hover:shadow-xl hover:-translate-y-1 text-center">
                
                {{-- image --}}
                <img src="{{ asset($category->image_url) }}" 
                     alt="{{ $category->name }}" 
                     class="w-40 h-40 mx-auto object-contain mb-4">
                
                {{-- category name --}}
                <h3 class="text-gray-800 font-medium mb-2">{{ $category->name }}</h3>
            </a>
            @endforeach
        </div>

    </div>
</div>
@endsection

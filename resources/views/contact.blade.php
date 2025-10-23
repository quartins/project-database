@extends('layouts.app')

@section('content')

<div class="bg-gradient-to-b from-pink-100 to-yellow-100 min-h-screen font-serif overflow-x-hidden">

    <section id="banner-section" class="relative w-screen left-1/2 right-1/2 -mx-[50vw] -mt-2 overflow-hidden
             bg-[#FFF8F8] rounded-b-lg shadow-md">
        
        <img src="{{ asset('images/contact1.jpg') }}" 
             alt="Contact Us Banner" 
             class="w-full h-[565px] object-cover object-top"> 
             <div class="absolute bottom-0 left-0 w-full h-[100px]  flex items-center justify-center bg-opacity-90">
    <img src="{{ asset('images/contact-us.png') }}" 
         alt="Contact Us" 
         class="h-25 object-contain">
</div>
    </section>

    <main class="max-w-7xl mx-auto py-12 px-6">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center py-8">
            
            <div class="flex flex-col items-center p-4">
                <i class="fas fa-home text-5xl text-gray-400 mb-6"></i>
                <p class="text-lg text-gray-700">chiangmai</p>
            </div>

            <div class="flex flex-col items-center p-4 md:border-l md:border-r border-gray-300">
                <i class="fas fa-users text-5xl text-gray-400 mb-6"></i>
                <p class="text-lg text-gray-700">name member</p>
            </div>

            <div class="flex flex-col items-center p-4">
                <i class="fas fa-envelope text-5xl text-gray-400 mb-6"></i>
                <p class="text-lg text-gray-700">chamora@example</p>
            </div>

        </div>
    </main>

</div>

@endsection

@push('scripts')
@endpush
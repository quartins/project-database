@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-pink-100 to-yellow-100 min-h-screen font-serif overflow-x-hidden">
<section id="banner-section" class="relative w-screen left-1/2 right-1/2 -mx-[50vw] -mt-2 overflow-hidden
         bg-[#FFF8F8] rounded-b-lg shadow-md">
    
    <img src="{{ asset('about_image/about-header1.jpg') }}" 
         alt="About Chamora Header" 
         class="w-full h-[565px] object-cover object-center">
</section>

<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 items-start mt-8">
        
        <div class="text-center">
            <img src="{{ asset('about_image/about-image1.png') }}" alt="Chamora Collectibles" class="w-full rounded-lg shadow-md">
        </div>

        <div>
            <p class="text-lg text-gray-600">
                <strong class="text-xl">🌸 About Chamora</strong><br><br>
                Chamora was born from a deep passion for collecting adorable character figures from the world of imagination ✨<br><br>
                We are devoted to creating a cozy little space for everyone who loves cuteness in every detail — from collectible figures and decorative items to officially licensed merchandise inspired by beloved characters such as Hello Kitty, My Melody, Cinnamoroll, and many more from the Sanrio universe 💕<br><br>
                At Chamora, we believe that every collectible is more than just decoration — it is a memory, a moment of joy, and a spark of happiness that brightens everyday life.<br><br>
                Each piece is carefully selected with love and attention, aiming to deliver a warm and meaningful experience to every collector.<br><br>
                Whether you’re a passionate collector or just beginning your journey into the world of figures, Chamora welcomes you to a realm filled with sweetness, inspiration, and timeless charm 🌸
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="text-center">
            <img src="{{ asset('about_image/about-image2.png') }}" alt="Image 1" class="w-full rounded-lg shadow-md">
        </div>
        <div class="text-center">
            <img src="{{ asset('about_image/about-image3.png') }}" alt="Image 2" class="w-full rounded-lg shadow-md">
        </div>
        <div class="text-center">
            <img src="{{ asset('about_image/about-image4.png') }}" alt="Image 3" class="w-full rounded-lg shadow-md">
        </div>
    </div>
</div>
</div>
@endsection
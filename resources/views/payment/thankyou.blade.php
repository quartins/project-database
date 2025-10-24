@extends('layouts.app')

@section('content')
{{-- 
    เราใช้ min-h-[calc(100vh-...)] เพื่อให้เนื้อหาอยู่กลางจอ
    (ลบความสูงของ header และ footer ออก)
--}}

<div class="bg-gradient-to-b from-pink-100 to-yellow-100 min-h-screen py-12 flex items-center justify-center">
    <div class="container mx-auto max-w-lg px-4 text-center">

        {{-- 1. Green Checkmark SVG (ไม่ต้องใช้รูป) --}}
        <svg class="w-20 h-20 text-green-500 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        {{-- 2. Thank You Text --}}
        <h1 class="text-4xl font-bold text-gray-800 mb-4">
            Thank you!
        </h1>

        <p class="text-lg text-gray-600 mb-12">
            Your order was completed successfully
        </p>

        <img src="{{ asset('images/sanrio.png') }}" alt="Thank you characters" class="w-48 h-auto mx-auto mb-12">
       
    </div>
</div>
@endsection
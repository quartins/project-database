@extends('layouts.app')

@section('content')
{{-- ดีไซน์ใหม่แบบเต็มจอ + ไล่สีพื้นหลัง --}}
<div class="bg-gradient-to-b from-pink-100 to-yellow-100 min-h-screen py-12 flex items-center justify-center">
    <div class="container mx-auto max-w-lg px-4 text-center">

        {{-- 1) Green Checkmark SVG --}}
        <svg class="w-20 h-20 text-green-500 mx-auto mb-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        {{-- 2) ข้อความ --}}
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Thank you!</h1>
        <p class="text-lg text-gray-600">
            Your order was completed successfully
        </p>

        {{-- 3) รูปภาพ (มี fallback ถ้าไฟล์ใหม่ไม่มี) --}}
        @php
            $imgNew = asset('images/sanrio.png');  // ของเพื่อน
        @endphp
        <img src="{{ $imgNew }}" alt="Thank you characters"
             class="w-48 h-auto mx-auto my-12"
             onerror="this.style.display='none'">

        {{-- 4) ปุ่ม Continue shopping (พฤติกรรมเดิม) --}}
        <a href="{{ route('home') }}"
           class="inline-block bg-[#5a362e] text-white px-6 py-3 rounded-lg hover:opacity-90 shadow">
            Continue shopping
        </a>

    </div>
</div>
@endsection
{{-- resources/views/profile/partials/sidebar.blade.php --}}
@php
    $isProfile  = request()->routeIs('profile.*');
    $isOrders   = request()->routeIs('orders.*');   // <= active ที่หน้าออร์เดอร์
    $linkBase   = 'flex items-center justify-between px-5 py-3 rounded-xl shadow bg-white transition';
    $iconWrap   = 'flex items-center gap-3';
    $isAddress  = request()->routeIs('address.*');
@endphp

<aside class="w-[300px] bg-pink-50 rounded-2xl border border-pink-100 p-6
              flex flex-col justify-start items-center min-h-[600px] shadow-sm">


    {{-- Avatar + username --}}
    <div class="flex flex-col items-center">
        <img
            src="{{ auth()->user()->profile_photo
                    ? asset('storage/'.auth()->user()->profile_photo)
                    : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->username ?? 'user') }}"

            class="w-24 h-24 rounded-full object-cover shadow-md bg-pink-100 border border-white"
            alt="avatar">
        <h2 class="mt-3 text-lg font-semibold text-gray-700">
            {{ auth()->user()->username ?? 'user' }}
        </h2>
    </div>

    {{-- Menu --}}
    <nav class="mt-6 space-y-3 w-full">
        {{-- Profile --}}
        <a href="{{ route('profile.edit') }}"
           class="{{ $linkBase }} {{ $isProfile ? 'text-pink-600 font-bold hover:bg-pink-100' : 'text-gray-800 hover:bg-pink-100' }}">
            <span class="{{ $iconWrap }}">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-4 0-10 2-10 6v2h20v-2c0-4-6-6-10-6z"/>
                </svg>
                <span>Profile</span>
            </span>
            <svg class="w-3.5 h-3.5 text-pink-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 1 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0z" clip-rule="evenodd"/>
            </svg>
        </a>

        {{-- Orders --}}
        <a href="{{ route('orders.index') }}"
           class="{{ $linkBase }} {{ $isOrders ? 'text-pink-600 font-bold hover:bg-pink-100' : 'text-gray-800 hover:bg-pink-100' }}">
            <span class="{{ $iconWrap }}">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 8l-9-5-9 5 9 5 9-5zm-9 7l-9-5v9l9 5 9-5v-9l-9 5z"/>
                </svg>
                <span>Purchase order</span>
            </span>
            <svg class="w-3.5 h-3.5 text-pink-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 1 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0z" clip-rule="evenodd"/>
            </svg>
        </a>

        {{-- Address --}}
        <a href="{{ route('address.edit') }}"
   class="{{ $linkBase }} {{ $isAddress ? 'text-pink-600 font-bold hover:bg-pink-100' : 'text-gray-800 hover:bg-pink-100' }}">
    <span class="{{ $iconWrap }}">
        <svg class="w-4 h-4 {{ $isAddress ? 'text-pink-600' : 'text-gray-800' }}" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5a2.5 2.5 0 1 1 2.5-2.5A2.5 2.5 0 0 1 12 11.5z"/>
        </svg>
        <span>Address</span>
    </span>
    <svg class="w-3.5 h-3.5 {{ $isAddress ? 'text-pink-400' : 'text-pink-300' }}" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 0 1 0-1.414L10.586 10 7.293 6.707a1 1 0 1 1 1.414-1.414l4 4a1 1 0 0 1 0 1.414l-4 4a1 1 0 0 1-1.414 0z" clip-rule="evenodd"/>
    </svg>
</a>

<div class="pt-6">
    <form method="POST" action="{{ route('logout') }}" class="w-full flex justify-center mt-10">
    @csrf
    <button type="submit"
        class="px-8 py-2 bg-pink-200 hover:bg-pink-300 text-gray-800 font-semibold rounded-full shadow transition">
        Logout
    </button>
</form>

</div>

    </nav>
</aside>

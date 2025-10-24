@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-[300px_1fr] gap-6">
    @include('profile.partials.sidebar')

    <section class="bg-white rounded-2xl border border-gray-200 p-6">
        <h1 class="text-2xl font-bold mb-6">Purchase Order</h1>

        @if(($orders ?? null)?->count())
            {{-- วนลูปแสดงรายการออร์เดอร์จริง (เดี๋ยวค่อยดึงจากทีมเพื่อน) --}}
        @else
            <div class="flex flex-col items-center justify-center py-16 text-gray-500">
                <svg class="w-10 h-10 mb-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M7 18c-1.1 0-2 .9-2 2h14a2 2 0 0 0-2-2H7zm11-9h-1l-1-3H8L7 9H6a2 2 0 0 0-2 2v7h2v-7h12v7h2v-7a2 2 0 0 0-2-2z"/>
                </svg>
                <p>You don’t have any orders yet ?</p>
            </div>
        @endif
    </section>
</div>
@endsection

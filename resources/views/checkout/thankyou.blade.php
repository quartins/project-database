@extends('layouts.app')   
@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center space-y-6">
  <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-10 h-10 text-green-600 fill-current">
      <path d="M9 16.2 4.8 12l-1.4 1.4L9 19l12-12-1.4-1.4z"/>
    </svg>
  </div>
  <h1 class="text-4xl font-semibold">Thank you!</h1>
  <p class="text-gray-600 text-lg">Your order was completed successfully.</p>

  <a href="{{ url('/') }}" class="mt-4 inline-block bg-[#5a362e] text-white px-6 py-3 rounded-lg hover:opacity-90">
    Continue shopping
  </a>
</div>
@endsection

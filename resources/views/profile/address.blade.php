@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-[300px_1fr] gap-6">
  @include('profile.partials.sidebar')

  <section class="bg-white rounded-2xl border border-gray-200 p-6">
    <h1 class="text-2xl font-bold mb-6">Address</h1>

    @if(session('ok'))
      <div class="mb-4 text-green-700 bg-green-50 border border-green-200 px-4 py-2 rounded">
        {{ session('ok') }}
      </div>
    @endif

    <form method="POST" action="{{ route('address.update') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      @csrf
      @method('PATCH')

      <div>
        <label class="block text-sm font-semibold">Full name *</label>
        <input name="recipient_name" value="{{ $form['recipient_name'] }}"
               class="mt-1 w-full border rounded-lg px-3 py-2" required>
        @error('recipient_name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-sm font-semibold">Phone</label>
        <input name="phone" value="{{ $form['phone'] }}"
               class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm font-semibold">Address line 1 *</label>
        <input name="address_line1" value="{{ $form['address_line1'] }}"
               class="mt-1 w-full border rounded-lg px-3 py-2" required>
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm font-semibold">Address line 2</label>
        <input name="address_line2" value="{{ $form['address_line2'] }}"
               class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold">District</label>
        <input name="district" value="{{ $form['district'] }}"
               class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold">Province</label>
        <input name="province" value="{{ $form['province'] }}"
               class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold">Postcode</label>
        <input name="postcode" value="{{ $form['postcode'] }}"
               class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold">Country</label>
        <input name="country" value="{{ $form['country'] }}"
               class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div class="md:col-span-2 flex justify-center mt-6">
  <button class="px-6 py-2.5 rounded-xl bg-rose-700 text-white font-medium hover:bg-rose-600 transition">
    Save Address
  </button>
</div>

    </form>
  </section>
</div>
@endsection

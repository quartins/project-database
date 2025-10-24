@extends('layouts.app')

@section('content')
@php($me = $user ?? auth()->user())


  {{-- หน้าโปรไฟล์ --}}
  <div class="max-w-6xl mx-auto px-4 py-8">
    {{-- กรอบรวม 2 คอลัมน์: ซ้ายเมนู ขวาฟอร์ม --}}
   <div class="grid grid-cols-1 md:grid-cols-[280px_1fr] gap-10 items-stretch">

      {{-- Sidebar --}}
   @include('profile.partials.sidebar')




      {{-- Content --}}
<section class="bg-white rounded-2xl border border-gray-100 shadow-md p-10 flex-1 min-h-full">
        {{-- หัวรูป + ปุ่มอัปโหลด --}}
        <div class="flex flex-col items-center">
          <img id="preview"
               class="w-20 h-20 rounded-full object-cover bg-gray-200"
               src="{{ auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->username ?? 'user') }}"
               alt="avatar" />
          <label class="mt-2 inline-flex items-center gap-2 px-3 py-1 rounded-full border text-sm cursor-pointer hover:bg-gray-50">
            choose file
            <input id="avatar" type="file" name="avatar" form="profile-form" accept="image/*" class="hidden">
          </label>
        </div>

        {{-- ฟอร์ม --}}
        <form id="profile-form" class="mt-8 max-w-xl mx-auto space-y-4"
              method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')

          @if (session('status'))
            <div class="rounded-xl bg-green-50 border border-green-200 text-green-800 px-4 py-2">
              {{ session('status') }}
            </div>
          @endif

          @if ($errors->any())
            <div class="rounded-xl bg-rose-50 border border-rose-200 text-rose-700 px-4 py-2">
              <ul class="list-disc pl-5">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
              </ul>
            </div>
          @endif

          {{-- username --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">username</label>
            <input type="text" name="username"
                   value="{{ old('username', auth()->user()->username) }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-200" />
            @error('username') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- email --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">gmail</label>
            <input type="email" name="email"
                   value="{{ old('email', auth()->user()->email) }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-200" />
            @error('email') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- phone --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">phone number</label>
            <input type="text" name="phone"
                   value="{{ old('phone', auth()->user()->phone) }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-200" />
            @error('phone') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- birthday --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">birthday</label>
            <input type="date" name="birthday"
                   value="{{ old('birthday', optional(auth()->user()->birthday)->format('Y-m-d')) }}"
                   class="w-full rounded-xl border border-gray-300 px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-rose-200" />
            @error('birthday') <p class="text-rose-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="pt-2">
            <button class="mx-auto block bg-[#6f4e49] hover:brightness-110 text-white font-semibold rounded-2xl px-10 py-2.5 shadow">
              Save
            </button>
          </div>
        </form>
      </section>
    </div>
  </div>

  {{-- พรีวิวรูป --}}
  <script>
    const input = document.getElementById('avatar');
    const img   = document.getElementById('preview');
    input?.addEventListener('change', e => {
      const f = e.target.files?.[0]; if (!f) return;
      img.src = URL.createObjectURL(f);
    });
  </script>

@endsection
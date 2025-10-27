@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-[300px_1fr] gap-6">
  @include('profile.partials.sidebar')

  <section class="bg-white rounded-2xl border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold">Address Book</h1>
      <button onclick="document.getElementById('add-form').classList.toggle('hidden')"
              class="bg-rose-700 text-white px-4 py-2 rounded-lg hover:bg-rose-600 transition">
        + Add New Address
      </button>
    </div>

      {{--  Success message --}}
      @if(session('ok'))
        <div id="flash-message" class="mb-4 text-green-700 bg-green-50 border border-green-200 px-4 py-2 rounded">
          {{ session('ok') }}
        </div>
      @endif

      @if(session('success'))
        <div id="flash-message" class="mb-4 text-green-700 bg-green-50 border border-green-200 px-4 py-2 rounded">
          {{ session('success') }}
        </div>
      @endif

      {{--  Flash message auto-hide --}}
      <script>
        // Automatically fade out flash messages after 3 seconds
        document.addEventListener('DOMContentLoaded', () => {
          const flash = document.getElementById('flash-message');
          if (flash) {
            setTimeout(() => {
              flash.style.transition = 'opacity 0.8s ease';
              flash.style.opacity = '0';
              setTimeout(() => flash.remove(), 800);
            }, 1000);
          }
        });
      </script>

    {{--  Add new address form --}}
    <form id="add-form" method="POST" action="{{ route('profile.address.store') }}"
          class="hidden border-t pt-4 grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 bg-pink-50 p-4 rounded-xl shadow-sm">
      @csrf

      <input type="hidden" name="is_default" value="false">

      <div>
        <label class="block text-sm font-semibold">Full name *</label>
        <input name="recipient_name" class="mt-1 w-full border rounded-lg px-3 py-2" required>
      </div>

      <div>
        <label class="block text-sm font-semibold">Phone</label>
        <input name="phone" class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm font-semibold">Address line 1 *</label>
        <input name="address_line1" class="mt-1 w-full border rounded-lg px-3 py-2" required>
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm font-semibold">Address line 2</label>
        <input name="address_line2" class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold">District</label>
        <input name="district" class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold">Province</label>
        <input name="province" class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold">Postcode</label>
        <input name="postcode" class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-semibold">Country</label>
        <input name="country" value="Thailand" class="mt-1 w-full border rounded-lg px-3 py-2">
      </div>

      <div class="md:col-span-2 flex justify-center mt-4">
        <button class="px-6 py-2.5 rounded-xl bg-rose-700 text-white font-medium hover:bg-rose-600 transition">
          Save Address
        </button>
      </div>
    </form>

    {{-- Address list --}}
    <div class="grid grid-cols-1 gap-4">
      @forelse($addresses as $addr)
        <div class="border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition bg-white relative">
          <div class="flex justify-between items-start">
            <div>
              <div class="font-semibold text-lg text-gray-800">{{ $addr->recipient_name }}</div>
              <div class="text-sm text-gray-500">{{ $addr->phone }}</div>
              <div class="text-gray-700 mt-1 leading-relaxed">
                {{ $addr->address_line1 }} {{ $addr->address_line2 }}<br>
                {{ $addr->district }}, {{ $addr->province }}, {{ $addr->postcode }}<br>
                {{ $addr->country }}
              </div>
            </div>

            <div class="flex flex-col justify-between items-end h-full w-32">
        
            {{-- Default / Set Default ด้านบน --}}
            <div>
              @if($addr->is_default)
                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded">Default</span>
              @else
                <form action="{{ route('profile.address.default', $addr->id) }}" method="POST" class="inline">
                  @csrf
                  <button class="text-xs text-rose-700 hover:underline">Set as Default</button>
                </form>
              @endif
            </div>

            {{-- ปุ่ม Edit / Delete มุมขวาล่าง --}}
            <div class="absolute bottom-3 right-4 flex gap-4">
              <button onclick="openEditModal({{ json_encode($addr) }})"
                      class="text-xs text-blue-600 hover:text-blue-800 transition">Edit</button>

              <form action="{{ route('profile.address.delete', $addr->id) }}" method="POST" onsubmit="return confirm('Delete this address?')">
                @csrf
                @method('DELETE')
                <button class="text-xs text-gray-500 hover:text-red-600 transition">Delete</button>
              </form>
            </div>
          </div>
            
          </div>
        </div>
      @empty
        <p class="text-gray-500 italic py-8 text-center">No addresses yet</p>
      @endforelse
    </div>
  </section>
</div>

{{--  Modal สำหรับแก้ไขที่อยู่ --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center z-50">
  <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-lg">
    <h2 class="text-xl font-semibold mb-4">Edit Address</h2>
    <form id="editForm" method="POST">
      @csrf
      @method('PUT')
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="hidden" name="address_id" id="edit_id">

        <div>
          <label class="block text-sm font-semibold">Full name *</label>
          <input id="edit_name" name="recipient_name" class="mt-1 w-full border rounded-lg px-3 py-2" required>
        </div>

        <div>
          <label class="block text-sm font-semibold">Phone</label>
          <input id="edit_phone" name="phone" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-semibold">Address line 1 *</label>
          <input id="edit_line1" name="address_line1" class="mt-1 w-full border rounded-lg px-3 py-2" required>
        </div>

        <div class="md:col-span-2">
          <label class="block text-sm font-semibold">Address line 2</label>
          <input id="edit_line2" name="address_line2" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>

        <div>
          <label class="block text-sm font-semibold">District</label>
          <input id="edit_district" name="district" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>

        <div>
          <label class="block text-sm font-semibold">Province</label>
          <input id="edit_province" name="province" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>

        <div>
          <label class="block text-sm font-semibold">Postcode</label>
          <input id="edit_postcode" name="postcode" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>

        <div>
          <label class="block text-sm font-semibold">Country</label>
          <input id="edit_country" name="country" class="mt-1 w-full border rounded-lg px-3 py-2">
        </div>
      </div>

      <div class="flex justify-end mt-6 space-x-3">
        <button type="button" onclick="closeEditModal()" class="px-5 py-2 border rounded-lg hover:bg-gray-100">Cancel</button>
        <button class="px-6 py-2 rounded-xl bg-rose-700 text-white hover:bg-rose-600 transition">Save Changes</button>
      </div>
    </form>
  </div>
</div>

{{--  JavaScript สำหรับเปิด/ปิด modal --}}
<script>
  function openEditModal(addr) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('edit_id').value = addr.id;
    document.getElementById('edit_name').value = addr.recipient_name;
    document.getElementById('edit_phone').value = addr.phone || '';
    document.getElementById('edit_line1').value = addr.address_line1;
    document.getElementById('edit_line2').value = addr.address_line2 || '';
    document.getElementById('edit_district').value = addr.district || '';
    document.getElementById('edit_province').value = addr.province || '';
    document.getElementById('edit_postcode').value = addr.postcode || '';
    document.getElementById('edit_country').value = addr.country || '';
    document.getElementById('editForm').action = `/profile/address/${addr.id}`;
  }

  function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
  }
</script>
@endsection

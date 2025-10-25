<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class ProfileAddressController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', $user->id)->get();

        return view('profile.address', compact('addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postcode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
        ]);

        $validated['user_id'] = Auth::id();

        // ถ้าเลือกให้ default ให้ reset ของเก่า
        if ($request->boolean('is_default')) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        Address::create($validated);

        return back()->with('ok', 'เพิ่มที่อยู่เรียบร้อยแล้ว');
    }

    public function setDefault(Address $address)
    {
        $userId = Auth::id();

        Address::where('user_id', $userId)->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return back()->with('ok', 'ตั้งค่า Default Address แล้ว');
    }

    public function destroy(Address $address)
    {
        $address->delete();
        return back()->with('ok', 'ลบที่อยู่เรียบร้อยแล้ว');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class ProfileAddressController extends Controller
{
    /** ✅ Get all addresses as JSON (used in modal) */
    public function index()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return response()->json($addresses);
    }

    public function list(Request $request)
    {
        $addresses = Address::where('user_id', auth()->id())->get();
        return response()->json($addresses);
    }

    /** ✅ Display the Address Book page */
    public function showPage()
    {
        $addresses = Address::where('user_id', auth()->id())->get();
        return view('profile.address', compact('addresses'));
    }

    /** ✅ Display the address edit page (for full-page view) */
    public function edit()
    {
        $user = Auth::user();
        $addresses = Address::where('user_id', $user->id)->get();

        return view('profile.address', compact('addresses'));
    }

    /** ✅ Add a new address (used by both modal & profile page) */
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

        // ถ้าเป็นที่อยู่แรกของ user → ตั้งให้เป็น default อัตโนมัติ
        $existingCount = Address::where('user_id', Auth::id())->count();

        if ($existingCount === 0) {
            $validated['is_default'] = true;
        } elseif ($request->boolean('is_default')) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $address = Address::create($validated);

        // 🧠 ตรวจว่า request มาจาก fetch (expect JSON) หรือไม่
        if ($request->expectsJson() || $request->isJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => '✅ Address added successfully!',
                'address' => $address,
            ]);
        }

        // 🧩 fallback: ถ้ามาจากหน้า profile ปกติ (form submit)
        return redirect()
            ->route('profile.address.page')
            ->with('success', 'The address has been added successfully.');
    }



    /** Update existing address */
    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::id())->findOrFail($id);
        $address->update($request->all());

        return redirect()
            ->route('profile.address.page')
            ->with('ok', 'The address has been updated successfully.');
    }

    /** Delete an address */
    public function destroy(Address $address)
    {
        // Check if the address belongs to the current user
        if ($address->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this address.');
        }

        $address->delete();

        //  Redirect back with success message
        return redirect()
            ->route('profile.address.page')
            ->with('ok', 'The address has been deleted successfully.');
    }

    /**  Set default address */
    public function setDefault(Address $address)
    {
        $userId = Auth::id();

        Address::where('user_id', $userId)->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        //  Redirect back with success message
        return redirect()
            ->route('profile.address.page')
            ->with('success', 'The default address has been set successfully.');
    }
}

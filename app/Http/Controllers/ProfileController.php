<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        // ส่ง $user เข้า view เสมอ
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // ข้อมูลผ่านการ validate แล้ว (name, email, phone, birthday, avatar?)
        $data = $request->validated();

        // อัปโหลดรูปใหม่ (input name="avatar")
        if ($request->hasFile('avatar')) {
            // ลบไฟล์เก่าถ้ามี
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            // เก็บไฟล์ใหม่ลง storage/app/public/avatars/...
            $data['profile_photo'] = $request->file('avatar')->store('avatars', 'public');
        }

        // รีเซ็ต verify ถ้า email เปลี่ยน
        if (isset($data['email']) && $data['email'] !== $user->email) {
            $user->email_verified_at = null;
        }

        // อัปเดตฟิลด์
        $user->fill([
        'username'      => $data['username']      ?? $user->username,
        'email'         => $data['email']         ?? $user->email,
        'phone'         => $data['phone']         ?? $user->phone,
        'birthday'      => $data['birthday']      ?? $user->birthday,
        'profile_photo' => $data['profile_photo'] ?? $user->profile_photo,
    ])->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

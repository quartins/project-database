<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'username'  => ['required','string','max:255','unique:users,username'],
        'firstname' => ['required','string','max:255'],
        'lastname'  => ['required','string','max:255'],
        'email'     => ['required','string','lowercase','email','max:255','unique:users,email'],
        'password'  => ['required','confirmed', Rules\Password::defaults()],
    ]);

    
    $name = trim($request->firstname.' '.$request->lastname) ?: $request->username;

    $user = User::create([
                 
        'username'  => $request->username,
        'firstname' => $request->firstname,
        'lastname'  => $request->lastname,
        'email'     => $request->email,
        'password'  => Hash::make($request->password),
    ]);

    event(new Registered($user));
    Auth::login($user);

    // ✅ ป้องกัน redirect ไป /cart/count หรือ /api/*
    $intended = session()->pull('url.intended', '/');
    if (preg_match('/(\/cart\/|\/api\/)/', $intended)) {
        $intended = '/';
    }

    return redirect($intended);
    
    }
}

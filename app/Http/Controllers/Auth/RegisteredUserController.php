<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    // Show register page
    public function create()
    {
        return view('auth.register');
    }

    // Handle register
    public function store(Request $request): RedirectResponse
    {
        // ✅ SIMPLE VALIDATION (no hidden issues)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // ✅ CREATE USER
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // 🔥 MUST
        ]);

        // ✅ AUTO LOGIN
        Auth::login($user);

        // ✅ REDIRECT
        return redirect('/dashboard');
    }
}
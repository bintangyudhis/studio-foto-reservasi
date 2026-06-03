<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'nomor_hp' => 'required|string|min:10|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'nomor_hp' => $validated['nomor_hp'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Akun berhasil dibuat!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            // Pastikan user bukan admin
            if (Auth::user()->role === 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Admin harus login melalui admin panel.',
                ]);
            }

            $request->session()->regenerate();
            return redirect()->intended(route('reservasi.index'))->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Logout berhasil!');
    }
}

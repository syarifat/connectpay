<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    public function index()
    {
        // Menampilkan view login yang ada di resources/views/auth/login.blade.php
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect sesuai role
            if (auth()->user()->role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/pelanggan/dashboard');
        }

        return back()->with('loginError', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // Menghapus session agar aman
        $request->session()->invalidate();

        // Membuat ulang token CSRF untuk keamanan
        $request->session()->regenerateToken();

        // Kembali ke halaman login
        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}

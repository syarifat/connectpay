<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use App\Models\User; // Tambahkan ini

class AuthController extends Controller
{
    public function index()
    {
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

            if (auth()->user()->role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/pelanggan/dashboard');
        }

        return back()->with('loginError', 'Username atau Password salah!');
    }

    // Method Baru: Menampilkan Halaman Ganti Password
    public function editPassword()
    {
        return view('auth.change-password');
    }

    // Method Baru: Proses Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ], [
            'new_password.min' => 'Password baru minimal harus 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // Cek apakah password lama cocok
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with('error', 'Password lama Anda salah!');
        }

        // Update Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke route login
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}
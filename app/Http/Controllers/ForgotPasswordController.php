<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Services\FonnteService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    protected $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    // Tampilkan form minta link
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim Link via WA
    public function sendResetLinkWA(Request $request)
    {
        $request->validate(['username' => 'required|exists:users,username']);

        $token = Str::random(60);
        
        // Simpan token ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['username' => $request->username],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Cari nomor WA pelanggan
        $customer = Customer::where('id_pelanggan', $request->username)->first();
        $resetUrl = url("/password/reset/{$token}?username={$request->username}");

        $pesan = "🔐 *Permintaan Reset Password ConnectPay*\n\n" .
                 "Halo *{$customer->nama}*,\n" .
                 "Kami menerima permintaan untuk meriset password akun Anda.\n\n" .
                 "Silakan klik link di bawah ini untuk membuat password baru:\n" .
                 "🔗 {$resetUrl}\n\n" .
                 "Link ini berlaku selama 60 menit. Jika Anda tidak merasa melakukan permintaan ini, abaikan pesan ini.\n\n" .
                 "Terima kasih,\n" .
                 "*Admin ConnectPay*";

        $this->fonnte->sendMessage($customer->nomor_wa, $pesan);

        return back()->with('success', 'Link reset password telah dikirim ke WhatsApp Anda!');
    }

    // Tampilkan form input password baru
    public function showResetForm($token, Request $request)
    {
        return view('auth.reset-password', ['token' => $token, 'username' => $request->username]);
    }

    // Proses Update Password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'username' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_reset_tokens')
                    ->where('username', $request->username)
                    ->where('token', $request->token)
                    ->first();

        if (!$reset || Carbon::parse($reset->created_at)->addMinutes(60)->isPast()) {
            return back()->withErrors(['token' => 'Token tidak valid atau sudah kadaluarsa.']);
        }

        // Update Password
        $user = User::where('username', $request->username)->first();
        $user->update([
            'password' => Hash::make($request->password),
            // Jika Anda menggunakan kolom password_plain tadi, update juga di sini
            'password_plain' => $request->password 
        ]);

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('username', $request->username)->delete();

        return redirect('/login')->with('success', 'Password berhasil diperbarui! Silakan login.');
    }
}
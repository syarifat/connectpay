<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PelangganController extends Controller
{
    public function index()
    {
        // Set timezone ke Jakarta agar akurat dengan jam lokal
        $today = Carbon::now('Asia/Jakarta');
        
        $customer = Customer::where('user_id', auth()->user()->id)->first();
        
        if (!$customer) {
            return redirect('/')->with('loginError', 'Data pelanggan tidak ditemukan.');
        }

        $history = Payment::where('customer_id', $customer->id)
                    ->orderBy('id', 'desc')
                    ->get();

        $tglJatuhTempo = (int) $customer->jatuh_tempo;

        // LOGIKA PERIODE:
        // Jika hari ini >= tanggal jatuh tempo, maka targetnya adalah bulan ini.
        // Jika hari ini < tanggal jatuh tempo, maka targetnya masih bulan lalu.
        if ($today->day < $tglJatuhTempo) {
            $periodeTarget = $today->copy()->subMonth();
        } else {
            $periodeTarget = $today;
        }

        // Konversi ke nama bulan Indonesia
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $bulanTarget = $bulanIndo[$periodeTarget->month];
        $tahunTarget = $periodeTarget->year;

        // Cek status pembayaran periode ini
        $isLunas = Payment::where('customer_id', $customer->id)
                    ->where('bulan', $bulanTarget)
                    ->where('tahun', $tahunTarget)
                    ->exists();

        // Hitung Masa Aktif Layanan untuk dikirim ke view (agar logic tidak menumpuk di Blade)
        $startActive = Carbon::create($tahunTarget, $periodeTarget->month, $tglJatuhTempo, 0, 0, 0, 'Asia/Jakarta');
        $endActive = $startActive->copy()->addMonth()->subDay();

        return view('pelanggan.dashboard', compact(
            'customer', 
            'history', 
            'isLunas', 
            'bulanTarget', 
            'tahunTarget',
            'startActive',
            'endActive'
        ));
    }
}
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
        $customer = Customer::where('user_id', auth()->user()->id)->first();
        $history = Payment::where('customer_id', $customer->id)
                    ->orderBy('id', 'desc')
                    ->get();

        // 1. Ambil info tanggal hari ini dan tanggal jatuh tempo
        $today = Carbon::now();
        $tglJatuhTempo = (int) $customer->jatuh_tempo;

        // 2. Logika Penentuan Periode Tagihan
        // Jika hari ini belum masuk tanggal jatuh tempo, cek tagihan bulan lalu
        if ($today->day < $tglJatuhTempo) {
            $periodeTarget = $today->copy()->subMonth();
        } else {
            // Jika sudah masuk/lewat tanggal jatuh tempo, cek tagihan bulan ini
            $periodeTarget = $today;
        }

        // 3. Konversi ke nama bulan Indonesia & Tahun
        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        $bulanTarget = $bulanIndo[$periodeTarget->month];
        $tahunTarget = $periodeTarget->year;

        // 4. Cek status pembayaran di database berdasarkan periode target
        $isLunas = Payment::where('customer_id', $customer->id)
                    ->where('bulan', $bulanTarget)
                    ->where('tahun', $tahunTarget)
                    ->exists();

        return view('pelanggan.dashboard', compact(
            'customer', 
            'history', 
            'isLunas', 
            'bulanTarget', 
            'tahunTarget'
        ));
    }
}
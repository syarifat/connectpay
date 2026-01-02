<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PelangganController extends Controller
{
    public function index()
    {
        $customer = Customer::where('user_id', auth()->user()->id)->first();
        $history = Payment::where('customer_id', $customer->id)
                    ->orderBy('id', 'desc')
                    ->get();

        // Ambil pembayaran bulan ini untuk cek status
        $bulanIni = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][date('n')-1];
        $isLunas = Payment::where('customer_id', $customer->id)
                    ->where('bulan', $bulanIni)
                    ->where('tahun', date('Y'))
                    ->exists();

        return view('pelanggan.dashboard', compact('customer', 'history', 'isLunas', 'bulanIni'));
    }
}

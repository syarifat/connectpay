<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Paket; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon; // Tambahan untuk logika tanggal

class AdminController extends Controller
{
    /**
     * Dashboard Monitoring Pembayaran (Baru)
     */
    public function dashboard()
    {
        // Set timezone ke Jakarta agar sinkron dengan jam lokal (WIB)
        $today = Carbon::now('Asia/Jakarta');
        
        $customers = Customer::with('paket')->get();
        
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $dataPelanggan = $customers->map(function($c) use ($today, $bulanIndo) {
            $tglJatuhTempo = (int) $c->jatuh_tempo;

            // Logika Periode: 
            // Jika hari ini < tanggal jatuh tempo, cek bulan lalu.
            // Jika hari ini >= tanggal jatuh tempo, cek bulan ini.
            if ($today->day < $tglJatuhTempo) {
                $periode = $today->copy()->subMonth();
            } else {
                $periode = $today;
            }

            $bulanTarget = $bulanIndo[$periode->month];
            $tahunTarget = $periode->year;

            $isLunas = Payment::where('customer_id', $c->id)
                        ->where('bulan', $bulanTarget)
                        ->where('tahun', $tahunTarget)
                        ->exists();

            return (object) [
                'id' => $c->id,
                'id_pelanggan' => $c->id_pelanggan,
                'nama' => $c->nama,
                'nomor_wa' => $c->nomor_wa,
                'jatuh_tempo' => $c->jatuh_tempo,
                'periode_aktif' => $bulanTarget . ' ' . $tahunTarget,
                'status' => $isLunas ? 'Lunas' : 'Belum Bayar',
                'paket_harga' => $c->paket ? $c->paket->harga : 0
            ];
        });

        $stats = [
            'total' => $dataPelanggan->count(),
            'lunas' => $dataPelanggan->where('status', 'Lunas')->count(),
            'belum' => $dataPelanggan->where('status', 'Belum Bayar')->count(),
        ];

        return view('admin.dashboard', compact('dataPelanggan', 'stats'));
    }

    public function index()
    {
        $customers = Customer::with('paket')->get(); // Eager load paket
        return view('admin.index', compact('customers'));
    }

    public function create()
    {
        $pakets = Paket::all(); // Mengambil data paket untuk dropdown
        return view('admin.create', compact('pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|unique:customers',
            'nama'         => 'required',
            'nik'          => 'required|numeric',
            'nomor_wa'     => 'required',
            'paket_id'     => 'required|exists:pakets,id', 
            'jatuh_tempo'  => 'required|numeric|min:1|max:31',
            'foto_rumah'   => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'username' => $request->id_pelanggan,
                'password' => Hash::make('123456'),
                'role'     => 'pelanggan',
            ]);

            $namaFoto = null;
            if ($request->hasFile('foto_rumah')) {
                $foto = $request->file('foto_rumah');
                $namaFoto = time() . '_' . $request->id_pelanggan . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('uploads/rumah'), $namaFoto);
            }

            Customer::create([
                'user_id'       => $user->id,
                'id_pelanggan'  => $request->id_pelanggan,
                'nama'          => $request->nama,
                'nik'           => $request->nik,
                'nomor_wa'      => $request->nomor_wa,
                'alamat'        => $request->alamat,
                'paket_id'      => $request->paket_id, 
                'jatuh_tempo'   => $request->jatuh_tempo,
                'pppoe_profile' => $request->pppoe_profile,
                'foto_rumah'    => $namaFoto ? 'uploads/rumah/' . $namaFoto : null,
            ]);

            DB::commit();
            return redirect('/admin/pelanggan')->with('success', 'Pelanggan Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $pakets = Paket::all(); 
        return view('admin.edit', compact('customer', 'pakets'));
    }
    
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        
        $request->validate([
            'nama'        => 'required',
            'nik'         => 'required|numeric',
            'nomor_wa'    => 'required',
            'paket_id'    => 'required|exists:pakets,id',
            'jatuh_tempo' => 'required|numeric|min:1|max:31',
            'foto_rumah'  => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto_rumah')) {
            if ($customer->foto_rumah && File::exists(public_path($customer->foto_rumah))) {
                File::delete(public_path($customer->foto_rumah));
            }
            $foto = $request->file('foto_rumah');
            $namaFoto = time() . '_' . $customer->id_pelanggan . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/rumah'), $namaFoto);
            $customer->foto_rumah = 'uploads/rumah/' . $namaFoto;
        }

        $customer->update([
            'nama'          => $request->nama,
            'nik'           => $request->nik,
            'nomor_wa'      => $request->nomor_wa,
            'alamat'        => $request->alamat,
            'paket_id'      => $request->paket_id,
            'jatuh_tempo'   => $request->jatuh_tempo,
            'pppoe_profile' => $request->pppoe_profile,
            'foto_rumah'    => $customer->foto_rumah
        ]);

        if ($customer->user) {
            $customer->user->update(['name' => $request->nama]);
        }

        return redirect('/admin/pelanggan')->with('success', 'Data Berhasil Diperbarui!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $user = User::find($customer->user_id);

        if ($customer->foto_rumah && File::exists(public_path($customer->foto_rumah))) {
            File::delete(public_path($customer->foto_rumah));
        }

        if ($user) { $user->delete(); } else { $customer->delete(); }

        return redirect('/admin/pelanggan')->with('success', 'Data dihapus!');
    }

    public function pembayaran($id)
    {
        $customer = Customer::with('paket')->findOrFail($id);
        $payments = Payment::where('customer_id', $id)->orderBy('id', 'desc')->get();
        return view('admin.pembayaran', compact('customer', 'payments'));
    }

    public function storePembayaran(Request $request)
    {
        $request->validate([
            'customer_id'   => 'required',
            'bulan'         => 'required',
            'tahun'         => 'required',
            'nominal'       => 'required|numeric',
            'metode'        => 'required',
            'tanggal_bayar' => 'required|date',
        ]);

        Payment::create($request->all());
        return redirect()->back()->with('success', 'Pembayaran dicatat!');
    }
}
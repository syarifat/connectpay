<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua pelanggan
     */
    public function index()
    {
        // Mengambil semua data pelanggan untuk ditampilkan di tabel utama
        $customers = Customer::all();
        return view('admin.index', compact('customers'));
    }

    /**
     * Menampilkan form tambah pelanggan
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Menyimpan data pelanggan baru dan membuatkan akun user
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|unique:customers',
            'nama'         => 'required',
            'nik'          => 'required|numeric',
            'nomor_wa'     => 'required',
            'paket'        => 'required',
            'jatuh_tempo'  => 'required|numeric|min:1|max:31', // Validasi jatuh tempo 1-31
            'foto_rumah'   => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat User untuk login (Username = ID Pelanggan)
            $user = User::create([
                'username' => $request->id_pelanggan,
                'password' => Hash::make('123456'), // Password default
                'role'     => 'pelanggan',
            ]);

            // 2. Handle Upload Foto
            $namaFoto = null;
            if ($request->hasFile('foto_rumah')) {
                $foto = $request->file('foto_rumah');
                $namaFoto = time() . '_' . $request->id_pelanggan . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('uploads/rumah'), $namaFoto);
            }

            // 3. Simpan Detail Pelanggan ke tabel customers
            Customer::create([
                'user_id'       => $user->id,
                'id_pelanggan'  => $request->id_pelanggan,
                'nama'          => $request->nama,
                'nik'           => $request->nik,
                'nomor_wa'      => $request->nomor_wa,
                'alamat'        => $request->alamat,
                'paket'         => $request->paket,
                'jatuh_tempo'   => $request->jatuh_tempo, // Menyimpan kolom jatuh tempo
                'pppoe_profile' => $request->pppoe_profile,
                'foto_rumah'    => $namaFoto ? 'uploads/rumah/' . $namaFoto : null,
            ]);

            DB::commit();
            return redirect('/admin/pelanggan')->with('success', 'Pelanggan Berhasil Ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit pelanggan
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.edit', compact('customer'));
    }
    
    /**
     * Memperbarui data pelanggan
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        
        $request->validate([
            'nama'        => 'required',
            'nik'         => 'required|numeric',
            'nomor_wa'    => 'required',
            'paket'       => 'required',
            'jatuh_tempo' => 'required|numeric|min:1|max:31', // Validasi jatuh tempo 1-31
            'foto_rumah'  => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle Upload Foto Baru jika ada
        if ($request->hasFile('foto_rumah')) {
            // Hapus foto lama jika ada fisiknya di folder
            if ($customer->foto_rumah && File::exists(public_path($customer->foto_rumah))) {
                File::delete(public_path($customer->foto_rumah));
            }

            $foto = $request->file('foto_rumah');
            $namaFoto = time() . '_' . $customer->id_pelanggan . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/rumah'), $namaFoto);
            $customer->foto_rumah = 'uploads/rumah/' . $namaFoto;
        }

        // Update data pelanggan di database
        $customer->update([
            'nama'          => $request->nama,
            'nik'           => $request->nik,
            'nomor_wa'      => $request->nomor_wa,
            'alamat'        => $request->alamat,
            'paket'         => $request->paket,
            'jatuh_tempo'   => $request->jatuh_tempo, // Update jatuh tempo
            'pppoe_profile' => $request->pppoe_profile,
            'foto_rumah'    => $customer->foto_rumah
        ]);

        // Sinkronisasi nama di tabel Users (opsional)
        if ($customer->user) {
            $customer->user->update(['name' => $request->nama]);
        }

        return redirect('/admin/pelanggan')->with('success', 'Data Pelanggan Berhasil Diperbarui!');
    }

    /**
     * Menghapus pelanggan, akun user, dan file foto secara permanen
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $user = User::find($customer->user_id);

        // 1. Hapus File Foto dari folder public
        if ($customer->foto_rumah) {
            $pathFoto = public_path($customer->foto_rumah);
            if (File::exists($pathFoto)) {
                File::delete($pathFoto);
            }
        }

        // 2. Hapus data dari database
        // Jika menggunakan user->delete(), data customer akan ikut terhapus (Cascade)
        if ($user) {
            $user->delete();
        } else {
            $customer->delete();
        }

        return redirect('/admin/pelanggan')->with('success', 'Data pelanggan dan file foto berhasil dihapus!');
    }

    /**
     * Menampilkan riwayat pembayaran pelanggan tertentu
     */
    public function pembayaran($id)
    {
        $customer = Customer::findOrFail($id);
        $payments = Payment::where('customer_id', $id)
                    ->orderBy('tahun', 'desc')
                    ->orderBy('bulan', 'desc')
                    ->get();
        
        return view('admin.pembayaran', compact('customer', 'payments'));
    }

    /**
     * Menyimpan input pembayaran baru dari Admin
     */
    public function storePembayaran(Request $request)
    {
        $request->validate([
            'customer_id'   => 'required',
            'bulan'         => 'required',
            'tahun'         => 'required',
            'nominal'       => 'required|numeric',
            'tanggal_bayar' => 'required|date',
        ]);

        Payment::create($request->all());

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat!');
    }
}
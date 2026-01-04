<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Paket; 
use App\Services\FonnteService; // Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class AdminController extends Controller
{
    protected $fonnte;

    // Tambahkan Constructor untuk memanggil FonnteService
    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    /**
     * Dashboard Monitoring Pembayaran
     */
    public function dashboard()
    {
        $today = Carbon::now('Asia/Jakarta');
        $customers = Customer::with('paket')->get();
        
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        $dataPelanggan = $customers->map(function($c) use ($today, $bulanIndo) {
            $tglJatuhTempo = (int) $c->jatuh_tempo;

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

    // ==========================================
    // FITUR WHATSAPP GATEWAY (MODIFIKASI BARU)
    // ==========================================

    public function sendAutoReminder(Request $request)
    {
        if ($request->query('key') !== 'connectpay123') {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $today = Carbon::now('Asia/Jakarta');
        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $periode = $bulanIndo[$today->month] . ' ' . $today->year;

        $customers = Customer::where('jatuh_tempo', $today->day)->get();

        $sent = 0;
        foreach ($customers as $c) {
            $nominal = $c->paket ? number_format($c->paket->harga, 0, ',', '.') : '0';
            $pesan = "Halo *{$c->nama}*,\n\nMengingatkan bahwa hari ini jatuh tempo pembayaran internet periode *{$periode}*.\nTagihan: *Rp {$nominal}*\nID: *{$c->id_pelanggan}*\n\nTerima kasih.";

            // Menggunakan Service
            $this->fonnte->sendMessage($c->nomor_wa, $pesan);
            $sent++;
        }

        return response()->json(['status' => 'success', 'sent' => $sent]);
    }

    public function broadcast(Request $request)
    {
        $deviceData = $this->fonnte->getDeviceStatus();
        $apiSuccess = $deviceData['status'] ?? false;
        $actualStatus = $deviceData['device_status'] ?? 'disconnect';

        if ($apiSuccess && $actualStatus === 'connect') {
            $deviceStatus = 'connect';
            $qrUrl = null;
        } else {
            $deviceStatus = 'disconnect';
            $qrData = $this->fonnte->getQrCode();

            // Debugging: Aktifkan ini jika gambar masih pecah untuk melihat isi respon Fonnte
            // dd($qrData);

            // Pastikan mengambil field 'url' atau 'result' sesuai respon API
            $qrUrl = $qrData['url'] ?? ($qrData['result'] ?? null);
        }

        $customers = Customer::all();
        return view('admin.broadcast', compact('customers', 'deviceStatus', 'qrUrl'));
    }

    public function sendBroadcast(Request $request)
    {
        $request->validate(['message' => 'required', 'target_type' => 'required']);

        $targets = ($request->target_type == 'all') 
                    ? Customer::all() 
                    : Customer::whereIn('id', $request->selected_ids ?? [])->get();

        if ($targets->isEmpty()) {
            return back()->with('error', 'Tidak ada pelanggan yang dipilih.');
        }

        foreach ($targets as $t) {
            // Menggunakan Service
            $this->fonnte->sendMessage($t->nomor_wa, $request->message);
        }

        return back()->with('success', count($targets) . ' Pesan broadcast berhasil dikirim!');
    }

    // ==========================================
    // LOGIKA CRUD PELANGGAN (TETAP SAMA)
    // ==========================================

    public function index()
    {
        $customers = Customer::with('paket')->get();
        return view('admin.index', compact('customers'));
    }

    public function create()
    {
        $pakets = Paket::all();
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
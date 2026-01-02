<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::all();
        return view('admin.pakets.index', compact('pakets'));
    }

    public function create()
    {
        return view('admin.pakets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:pakets',
            'speed' => 'required',
            'harga' => 'required|numeric',
        ]);

        Paket::create($request->all());

        return redirect()->route('pakets.index')->with('success', 'Paket baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.pakets.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|unique:pakets,nama,' . $id,
            'speed' => 'required',
            'harga' => 'required|numeric',
        ]);

        $paket->update($request->all());

        return redirect()->route('pakets.index')->with('success', 'Data paket berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        
        // Cek apakah paket masih digunakan oleh pelanggan
        if ($paket->customers()->count() > 0) {
            return redirect()->back()->with('error', 'Gagal menghapus! Paket masih digunakan oleh pelanggan.');
        }

        $paket->delete();
        return redirect()->route('pakets.index')->with('success', 'Paket berhasil dihapus!');
    }
}
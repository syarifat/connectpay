@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h4 class="fw-bold text-primary mb-3">Tambah Paket Baru</h4>
        <div class="card-custom bg-white p-4">
            <form action="{{ route('pakets.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Paket</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Paket Lite" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Kecepatan (Speed)</label>
                    <input type="text" name="speed" class="form-control" placeholder="Contoh: 15 Mbps" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Harga Bulanan (Rp)</label>
                    <input type="number" name="harga" class="form-control" placeholder="Contoh: 150000" required>
                </div>
                <button type="submit" class="btn btn-connect w-100 py-2">Simpan Paket</button>
                <a href="{{ route('pakets.index') }}" class="btn btn-light w-100 mt-2">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
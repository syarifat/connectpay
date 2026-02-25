@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        {{-- Page Header --}}
        <div class="mb-4 cp-page-header">
            <h1 class="cp-page-title">
                <i class="bi bi-plus-circle me-2" style="color: var(--primary);"></i>Tambah Paket
            </h1>
            <p class="cp-page-subtitle">Buat paket internet baru untuk pelanggan</p>
        </div>

        <div class="cp-card">
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
                <button type="submit" class="btn btn-connect w-100 py-2 fw-bold">
                    <i class="bi bi-check-lg me-1"></i> Simpan Paket
                </button>
                <a href="{{ route('pakets.index') }}" class="btn btn-light w-100 mt-2" style="border-radius: var(--radius-sm);">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
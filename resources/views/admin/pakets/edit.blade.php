@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary">Edit Paket Internet</h4>
            <a href="{{ route('pakets.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-custom bg-white p-4">
            <form action="{{ route('pakets.update', $paket->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Paket</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama', $paket->nama) }}" placeholder="Contoh: Paket Ultra" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kecepatan (Speed)</label>
                    <input type="text" name="speed" class="form-control @error('speed') is-invalid @enderror" 
                           value="{{ old('speed', $paket->speed) }}" placeholder="Contoh: 50 Mbps" required>
                    @error('speed')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Harga Bulanan (Rp)</label>
                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                           value="{{ old('harga', $paket->harga) }}" placeholder="Contoh: 350000" required>
                    <small class="text-muted italic">Masukkan angka saja tanpa titik atau koma.</small>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-warning border-0 small mb-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Perubahan pada harga paket akan otomatis terlihat pada tagihan baru pelanggan di bulan depan.
                </div>

                <button type="submit" class="btn btn-connect w-100 py-2 fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan Paket
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
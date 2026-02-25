@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 cp-page-header">
            <div>
                <h1 class="cp-page-title">
                    <i class="bi bi-pencil-square me-2" style="color: var(--primary);"></i>Edit Paket
                </h1>
                <p class="cp-page-subtitle">Perbarui informasi paket internet</p>
            </div>
            <a href="{{ route('pakets.index') }}" class="btn btn-light border px-3" style="border-radius: var(--radius-sm);">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="cp-card">
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
                    <small style="color: var(--text-muted); font-size: 0.78rem; font-style: italic;">Masukkan angka saja tanpa titik atau koma.</small>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="background: var(--warning-subtle); border-radius: var(--radius-sm); padding: 12px 16px; color: #92400e; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    Perubahan harga paket akan otomatis terlihat pada tagihan baru pelanggan di bulan depan.
                </div>

                <button type="submit" class="btn btn-connect w-100 py-2 fw-bold">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan Paket
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
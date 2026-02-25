@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-5">
        <div class="cp-card" style="padding: 40px;">
            <div class="text-center mb-4">
                <div style="width: 56px; height: 56px; background: var(--primary-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="bi bi-key-fill" style="font-size: 1.5rem; color: var(--primary);"></i>
                </div>
                <h3 class="fw-bold" style="color: var(--text-primary);">Lupa Password?</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Masukkan ID Pelanggan Anda untuk menerima link reset melalui WhatsApp.</p>
            </div>

            @if(session('success'))
                <div class="cp-alert success mb-3" style="font-size: 0.85rem;">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('password.wa') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-bold">ID Pelanggan (Username)</label>
                    <input type="text" name="username" class="form-control form-control-lg @error('username') is-invalid @enderror" 
                           placeholder="Contoh: CP001" value="{{ old('username') }}" required style="font-size: 0.95rem;">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-connect py-3 fw-bold" style="font-size: 0.95rem;">
                        <i class="bi bi-whatsapp me-2"></i> Kirim Link ke WhatsApp
                    </button>
                    <a href="{{ route('login') }}" class="btn btn-light border fw-bold" style="border-radius: var(--radius-sm); color: var(--text-secondary);">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
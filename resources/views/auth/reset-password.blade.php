@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="col-md-5">
        <div class="cp-card" style="padding: 40px;">
            <div class="text-center mb-4">
                <div style="width: 56px; height: 56px; background: var(--success-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="bi bi-shield-lock-fill" style="font-size: 1.5rem; color: var(--success);"></i>
                </div>
                <h3 class="fw-bold" style="color: var(--text-primary);">Buat Password Baru</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    Silakan masukkan password baru untuk akun <strong style="color: var(--primary);">{{ $username }}</strong>
                </p>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="username" value="{{ $username }}">

                <div class="mb-3">
                    <label class="form-label fw-bold">Password Baru</label>
                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                           placeholder="Minimal 6 karakter" required autofocus style="font-size: 0.95rem;">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control form-control-lg" 
                           placeholder="Ulangi password baru" required style="font-size: 0.95rem;">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-connect py-3 fw-bold" style="font-size: 0.95rem; background: var(--gradient-success);">
                        <i class="bi bi-check-lg me-2"></i> Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
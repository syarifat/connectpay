@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="cp-card">
            <div class="mb-4">
                <h4 class="fw-bold" style="color: var(--text-primary);">
                    <i class="bi bi-key-fill me-2" style="color: var(--primary);"></i>Ganti Password
                </h4>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Demi keamanan akun, jangan berikan password Anda kepada siapapun.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label">Password Saat Ini</label>
                    <div class="input-group">
                        <input type="password" name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" required>
                        <button class="btn btn-light border toggle-password" type="button" data-target="old_password" style="border-radius: 0 var(--radius-sm) var(--radius-sm) 0;">
                            <i class="bi bi-eye" style="color: var(--text-muted);"></i>
                        </button>
                    </div>
                </div>

                <hr style="border-color: var(--border); margin: 20px 0;">

                <div class="mb-3">
                    <label class="form-label">Password Baru <small style="color: var(--text-muted);">(Min. 6 Karakter)</small></label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                        <button class="btn btn-light border toggle-password" type="button" data-target="new_password" style="border-radius: 0 var(--radius-sm) var(--radius-sm) 0;">
                            <i class="bi bi-eye" style="color: var(--text-muted);"></i>
                        </button>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                        <button class="btn btn-light border toggle-password" type="button" data-target="new_password_confirmation" style="border-radius: 0 var(--radius-sm) var(--radius-sm) 0;">
                            <i class="bi bi-eye" style="color: var(--text-muted);"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : '/pelanggan/dashboard' }}" class="btn btn-light border w-100 fw-bold" style="border-radius: var(--radius-sm);">Batal</a>
                    <button type="submit" class="btn btn-connect w-100">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    });
</script>
@endpush
@endsection
@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card-custom">
            <div class="mb-4">
                <h4 class="fw-bold text-primary"><i class="bi bi-key-fill me-2"></i>Ganti Password</h4>
                <p class="text-muted small">Demi keamanan akun, jangan berikan password Anda kepada siapapun.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-secondary">Password Saat Ini</label>
                    <div class="input-group">
                        <input type="password" name="old_password" id="old_password" class="form-control border-info-subtle @error('old_password') is-invalid @enderror" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="old_password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <hr class="text-light">

                <div class="mb-3">
                    <label class="form-label text-secondary">Password Baru (Min. 6 Karakter)</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control border-info-subtle @error('new_password') is-invalid @enderror" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password">
                            <i class="bi bi-eye"></i>
                        </button>
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-secondary">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control border-info-subtle" required>
                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="new_password_confirmation">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : '/pelanggan/dashboard' }}" class="btn btn-light w-100 fw-bold">Batal</a>
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
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Lupa Password?</h3>
                        <p class="text-muted">Masukkan ID Pelanggan Anda untuk menerima link reset melalui WhatsApp.</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 small">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('password.wa') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">ID Pelanggan (Username)</label>
                            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                                   placeholder="Contoh: CP001" value="{{ old('username') }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary fw-bold py-2">
                                <i class="bi bi-whatsapp me-2"></i> Kirim Link ke WhatsApp
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-light text-secondary small fw-bold">Kembali ke Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
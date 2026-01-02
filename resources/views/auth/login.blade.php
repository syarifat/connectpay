@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-4">
        <div class="card-custom p-5 bg-white">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">Connect<span class="text-info">Pay</span></h2>
                <p class="text-muted">Silahkan login ke akun Anda</p>
            </div>

            @if(session('loginError'))
                <div class="alert alert-danger">{{ session('loginError') }}</div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary">Username / ID Pelanggan</label>
                    <input type="text" name="username" class="form-control form-control-lg border-info-subtle" required>
                </div>
                <div class="mb-4">
                    <label class="form-label text-secondary">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg border-info-subtle" required>
                </div>
                <button type="submit" class="btn btn-connect w-100 py-2 fw-bold">Masuk</button>
            </form>
        </div>
    </div>
</div>
@endsection
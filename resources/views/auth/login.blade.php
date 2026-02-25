@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 78vh;">
    <div class="col-lg-10 col-xl-8">
        <div class="cp-card p-0 overflow-hidden" style="border-radius: var(--radius-2xl);">
            <div class="row g-0">
                {{-- Left Panel - Brand --}}
                <div class="col-lg-5 d-none d-lg-flex" style="background: var(--gradient-primary); position: relative; overflow: hidden; min-height: 480px;">
                    <div style="position: absolute; inset: 0; overflow: hidden;">
                        <div style="position: absolute; top: -40px; right: -40px; width: 150px; height: 150px; border-radius: 50%; background: rgba(255,255,255,0.08);"></div>
                        <div style="position: absolute; bottom: 60px; left: -30px; width: 100px; height: 100px; border-radius: 50%; background: rgba(255,255,255,0.06);"></div>
                        <div style="position: absolute; top: 50%; right: 20px; width: 60px; height: 60px; border-radius: var(--radius-md); background: rgba(255,255,255,0.05); transform: rotate(45deg);"></div>
                        <div style="position: absolute; bottom: -20px; right: 40%; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.04);"></div>
                    </div>
                    <div class="d-flex flex-column justify-content-center align-items-center text-center text-white p-5 w-100" style="position: relative; z-index: 2;">
                        <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin-bottom: 24px;">
                            <i class="bi bi-broadcast" style="font-size: 2rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-2" style="letter-spacing: -0.5px;">ConnectPay</h2>
                        <p style="opacity: 0.8; font-size: 0.9rem; max-width: 250px; line-height: 1.6;">
                            Sistem manajemen pembayaran internet yang cepat, aman & terpercaya.
                        </p>
                        <div class="mt-4 d-flex gap-3">
                            <div style="background: rgba(255,255,255,0.12); border-radius: var(--radius-sm); padding: 10px 16px; text-align: center;">
                                <i class="bi bi-shield-check d-block mb-1" style="font-size: 1.2rem;"></i>
                                <small style="font-size: 0.7rem; opacity: 0.8;">Aman</small>
                            </div>
                            <div style="background: rgba(255,255,255,0.12); border-radius: var(--radius-sm); padding: 10px 16px; text-align: center;">
                                <i class="bi bi-lightning-charge d-block mb-1" style="font-size: 1.2rem;"></i>
                                <small style="font-size: 0.7rem; opacity: 0.8;">Cepat</small>
                            </div>
                            <div style="background: rgba(255,255,255,0.12); border-radius: var(--radius-sm); padding: 10px 16px; text-align: center;">
                                <i class="bi bi-graph-up-arrow d-block mb-1" style="font-size: 1.2rem;"></i>
                                <small style="font-size: 0.7rem; opacity: 0.8;">Mudah</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Panel - Form --}}
                <div class="col-lg-7">
                    <div class="p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <div class="d-lg-none mb-3">
                                <div class="cp-brand-icon mx-auto mb-2" style="width: 48px; height: 48px; font-size: 1.3rem;">
                                    <i class="bi bi-broadcast"></i>
                                </div>
                            </div>
                            <h3 class="fw-bold" style="color: var(--text-primary); letter-spacing: -0.3px;">Selamat Datang!</h3>
                            <p style="color: var(--text-muted); font-size: 0.9rem;">Silahkan login ke akun Anda untuk melanjutkan</p>
                        </div>

                        @if(session('loginError'))
                            <div class="cp-alert error mb-3" style="font-size: 0.85rem;">
                                <i class="bi bi-exclamation-circle-fill"></i>
                                {{ session('loginError') }}
                            </div>
                        @endif

                        <form action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-person me-1" style="color: var(--primary);"></i> ID Pelanggan
                                </label>
                                <input type="text" name="username" class="form-control form-control-lg" placeholder="Masukkan ID Pelanggan" required style="font-size: 0.95rem;">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="bi bi-lock me-1" style="color: var(--primary);"></i> Password
                                </label>
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password" required style="font-size: 0.95rem;">
                            </div>
                            <button type="submit" class="btn btn-connect w-100 py-3 fw-bold" style="font-size: 1rem;">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                            </button>
                            <div class="mt-3 text-center">
                                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: var(--primary); font-weight: 500; font-size: 0.9rem;">
                                    <i class="bi bi-key me-1"></i>Lupa Password?
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
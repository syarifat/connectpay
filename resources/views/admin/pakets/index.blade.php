@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 cp-page-header">
        <div>
            <h1 class="cp-page-title">
                <i class="bi bi-box-seam-fill me-2" style="color: var(--primary);"></i>Paket Internet
            </h1>
            <p class="cp-page-subtitle">Kelola paket layanan internet yang tersedia</p>
        </div>
        <a href="{{ route('pakets.create') }}" class="btn btn-connect px-4 mt-2 mt-md-0">
            <i class="bi bi-plus-lg me-2"></i>Tambah Paket
        </a>
    </div>

    @if(session('error'))
        <div class="cp-alert error mb-4 alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Paket Table --}}
    <div class="cp-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Kecepatan</th>
                        <th>Harga</th>
                        <th>Total Pelanggan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pakets as $p)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 40px; height: 40px; background: var(--gradient-accent); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-wifi" style="color: white; font-size: 1rem;"></i>
                                </div>
                                <span class="fw-bold" style="font-size: 0.95rem;">{{ $p->nama }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="cp-badge info">
                                <i class="bi bi-speedometer2 me-1"></i>{{ $p->speed }}
                            </span>
                        </td>
                        <td class="fw-bold" style="color: var(--primary);">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td>
                            <span style="color: var(--text-secondary); font-weight: 500;">
                                <i class="bi bi-people me-1" style="color: var(--primary-light);"></i>
                                {{ $p->customers->count() }} User
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('pakets.edit', $p->id) }}" class="btn btn-sm"
                                   style="background: var(--primary-subtle); color: var(--primary); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: var(--radius-sm); padding: 6px 12px;">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </a>
                                <form action="{{ route('pakets.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm" style="background: var(--danger-subtle); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: var(--radius-sm); padding: 6px 12px;">
                                        <i class="bi bi-trash3 me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
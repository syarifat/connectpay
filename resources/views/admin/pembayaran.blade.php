@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 cp-page-header">
        <div>
            <h1 class="cp-page-title">
                <i class="bi bi-cash-stack me-2" style="color: var(--primary);"></i>Riwayat Pembayaran
            </h1>
            <p class="cp-page-subtitle">
                Pelanggan: <strong style="color: var(--text-primary);">{{ $customer->nama }}</strong> 
                <span class="cp-badge info ms-1">{{ $customer->id_pelanggan }}</span>
            </p>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0">
            <a href="/admin/dashboard" class="btn btn-light border px-3" style="border-radius: var(--radius-sm);">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <button class="btn btn-connect px-4" data-bs-toggle="modal" data-bs-target="#modalBayar">
                <i class="bi bi-plus-lg me-1"></i> Input Bayar Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="cp-alert success mb-4 alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Payment History --}}
    <div class="cp-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Bulan / Tahun</th>
                        <th>Tanggal Bayar</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td class="fw-bold" style="color: var(--text-primary);">{{ $p->bulan }} {{ $p->tahun }}</td>
                        <td style="color: var(--text-secondary);">{{ date('d M Y', strtotime($p->tanggal_bayar)) }}</td>
                        <td class="fw-bold" style="color: var(--primary);">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                        <td>
                            <span class="cp-badge {{ $p->metode == 'Transfer' ? 'info' : '' }}" 
                                  style="{{ $p->metode != 'Transfer' ? 'background: var(--bg-alt); color: var(--text-secondary);' : '' }}">
                                {{ $p->metode }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="cp-badge success">
                                <i class="bi bi-check-lg me-1"></i> LUNAS
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="cp-empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Belum ada riwayat pembayaran untuk pelanggan ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Input Pembayaran --}}
<div class="modal fade" id="modalBayar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.pembayaran.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: var(--text-primary);">
                    <i class="bi bi-cash-coin me-2" style="color: var(--primary);"></i>Input Pembayaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Bulan</label>
                        <select name="bulan" class="form-select" required>
                            @php
                                $months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                                $currentMonth = $months[date('n')-1];
                            @endphp
                            @foreach($months as $m)
                                <option value="{{ $m }}" {{ $m == $currentMonth ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Tahun</label>
                        <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nominal Pembayaran (Rp)</label>
                    <input type="number" name="nominal" class="form-control" placeholder="Contoh: 150000" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Metode Pembayaran</label>
                    <select name="metode" class="form-select" required>
                        <option value="Cash" selected>Cash (Tunai)</option>
                        <option value="Transfer">Transfer Bank</option>
                    </select>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            
            <div class="modal-footer" style="gap: 8px;">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: var(--radius-sm);">Batal</button>
                <button type="submit" class="btn btn-connect px-4">
                    <i class="bi bi-check-lg me-1"></i> Simpan Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
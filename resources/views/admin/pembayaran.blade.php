@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-primary">Riwayat Pembayaran</h4>
            <p class="text-muted">Pelanggan: <span class="text-dark fw-bold">{{ $customer->nama }}</span> ({{ $customer->id_pelanggan }})</p>
        </div>
        <div>
            <a href="/admin/dashboard" class="btn btn-outline-secondary me-2">Kembali</a>
            <button class="btn btn-connect px-4" data-bs-toggle="modal" data-bs-target="#modalBayar">
                <i class="bi bi-cash-stack"></i> Input Bayar Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-custom bg-white p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Bulan / Tahun</th>
                        <th>Tanggal Bayar</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td class="fw-bold">{{ $p->bulan }} {{ $p->tahun }}</td>
                        <td>{{ date('d M Y', strtotime($p->tanggal_bayar)) }}</td>
                        <td class="text-primary fw-bold">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $p->metode == 'Transfer' ? 'bg-info-subtle text-info' : 'bg-secondary-subtle text-secondary' }} px-3">
                                {{ $p->metode }}
                            </span>
                        </td>
                        <td><span class="badge bg-success"><i class="bi bi-check-lg"></i> LUNAS</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat pembayaran untuk pelanggan ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalBayar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.pembayaran.store') }}" method="POST" class="modal-content border-0 shadow">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold text-primary">Input Pembayaran Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
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
            
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-connect px-4">Simpan Pembayaran</button>
            </div>
        </form>
    </div>
</div>
@endsection
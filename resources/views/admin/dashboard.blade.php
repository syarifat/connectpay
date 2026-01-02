@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-secondary">Dashboard Monitoring Pembayaran</h3>
        <span class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-people-fill fs-1 me-3"></i>
                    <div>
                        <h6 class="mb-0 opacity-75">Total Pelanggan</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-1 me-3"></i>
                    <div>
                        <h6 class="mb-0 opacity-75">Sudah Lunas (Periode Ini)</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['lunas'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white p-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-1 me-3"></i>
                    <div>
                        <h6 class="mb-0 opacity-75">Belum Bayar</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['belum'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-primary mb-0">Daftar Status Pembayaran Pelanggan</h5>
            <div class="badge bg-info-subtle text-info px-3 py-2">
                Menampilkan Periode Aktif Masing-Masing Pelanggan
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 100px;">ID</th>
                        <th>Nama Pelanggan</th>
                        <th>Harga Paket</th>
                        <th class="text-center">Jatuh Tempo</th>
                        <th>Periode Tagihan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataPelanggan as $d)
                    <tr>
                        <td class="fw-bold text-dark">{{ $d->id_pelanggan }}</td>
                        <td>
                            <div class="fw-semibold">{{ $d->nama }}</div>
                            <small class="text-muted"><i class="bi bi-whatsapp"></i> {{ $d->nomor_wa }}</small>
                        </td>
                        <td class="text-success fw-bold">
                            Rp {{ number_format($d->paket_harga, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">Tgl {{ $d->jatuh_tempo }}</span>
                        </td>
                        <td>
                            <span class="text-primary fw-medium">{{ $d->periode_aktif }}</span>
                        </td>
                        <td class="text-center">
                            @if($d->status == 'Lunas')
                                <span class="badge bg-success-subtle text-success px-3 py-2 border border-success-subtle w-100">
                                    <i class="bi bi-patch-check-fill me-1"></i> LUNAS
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger px-3 py-2 border border-danger-subtle w-100">
                                    <i class="bi bi-clock-history me-1"></i> BELUM BAYAR
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.pembayaran', $d->id) }}" class="btn btn-sm btn-outline-primary" title="Input Pembayaran">
                                    <i class="bi bi-cash-stack"></i> Bayar
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $d->nomor_wa) }}?text=Halo%20{{ $d->nama }},%20mengingatkan%20tagihan%20internet%20periode%20{{ $d->periode_aktif }}%20sebesar%20Rp%20{{ number_format($d->paket_harga, 0, ',', '.') }}%20belum%20terbayar.%20Terima%20kasih." 
                                   target="_blank" class="btn btn-sm btn-outline-success {{ $d->status == 'Lunas' ? 'disabled' : '' }}" title="Kirim Pengingat WA">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
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
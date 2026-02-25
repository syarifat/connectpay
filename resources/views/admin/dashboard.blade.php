@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 cp-page-header">
        <div>
            <h1 class="cp-page-title">
                <i class="bi bi-grid-1x2-fill me-2" style="color: var(--primary);"></i>Dashboard
            </h1>
            <p class="cp-page-subtitle">Monitoring pembayaran pelanggan ConnectPay</p>
        </div>
        <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
            <span style="background: var(--primary-subtle); color: var(--primary); padding: 8px 16px; border-radius: var(--radius-lg); font-size: 0.85rem; font-weight: 600;">
                <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4 animate-in animate-delay-1">
            <div class="cp-stat-card primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="cp-stat-label mb-1">Total Pelanggan</p>
                        <h2 class="cp-stat-value mb-0">{{ $stats['total'] }}</h2>
                    </div>
                    <div class="cp-stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 animate-in animate-delay-2">
            <div class="cp-stat-card success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="cp-stat-label mb-1">Sudah Lunas</p>
                        <h2 class="cp-stat-value mb-0">{{ $stats['lunas'] }}</h2>
                    </div>
                    <div class="cp-stat-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 animate-in animate-delay-3">
            <div class="cp-stat-card danger">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="cp-stat-label mb-1">Belum Bayar</p>
                        <h2 class="cp-stat-value mb-0">{{ $stats['belum'] }}</h2>
                    </div>
                    <div class="cp-stat-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Table --}}
    <div class="cp-card animate-in" style="animation-delay: 0.35s;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
            <div>
                <h5 class="fw-bold mb-1" style="color: var(--text-primary);">
                    <i class="bi bi-table me-2" style="color: var(--primary);"></i>Status Pembayaran
                </h5>
                <p class="mb-0" style="color: var(--text-muted); font-size: 0.85rem;">Daftar seluruh pelanggan dan status pembayaran terkini</p>
            </div>
            <span class="cp-badge info">
                <i class="bi bi-broadcast me-1"></i> Monitoring Periode Aktif
            </span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
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
                        <td>
                            <span class="fw-bold" style="color: var(--primary); font-size: 0.85rem;">{{ $d->id_pelanggan }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 36px; height: 36px; background: var(--primary-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <span style="font-weight: 700; color: var(--primary); font-size: 0.8rem;">{{ strtoupper(substr($d->nama, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size: 0.9rem;">{{ $d->nama }}</div>
                                    <small style="color: var(--text-muted); font-size: 0.78rem;">
                                        <i class="bi bi-whatsapp" style="color: #25D366;"></i> {{ $d->nomor_wa }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold" style="color: var(--success);">
                                Rp {{ number_format($d->paket_harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="cp-badge info">Tgl {{ $d->jatuh_tempo }}</span>
                        </td>
                        <td>
                            <span style="color: var(--primary); font-weight: 500; font-size: 0.9rem;">{{ $d->periode_aktif }}</span>
                        </td>
                        <td class="text-center">
                            @if($d->status == 'Lunas')
                                <span class="cp-badge success">
                                    <i class="bi bi-patch-check-fill me-1"></i> LUNAS
                                </span>
                            @else
                                <span class="cp-badge danger">
                                    <i class="bi bi-clock-history me-1"></i> BELUM BAYAR
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.pembayaran', $d->id) }}" class="btn btn-sm btn-connect px-3" style="font-size: 0.78rem; padding: 6px 14px;">
                                    <i class="bi bi-cash-stack me-1"></i> Bayar
                                </a>
                                
                                @php
                                    $phone = preg_replace('/[^0-9]/', '', $d->nomor_wa);
                                    if (strpos($phone, '0') === 0) { $phone = '62' . substr($phone, 1); }
                                    $msg = "Halo " . $d->nama . ", tagihan internet periode " . $d->periode_aktif . " sebesar Rp " . number_format($d->paket_harga, 0, ',', '.') . " belum terbayar. Terima kasih.";
                                @endphp
                                
                                <a href="https://wa.me/{{ $phone }}?text={{ urlencode($msg) }}" 
                                   target="_blank" 
                                   class="btn btn-sm {{ $d->status == 'Lunas' ? 'disabled' : '' }}"
                                   style="background: #dcfce7; color: #16a34a; border: 1px solid rgba(22, 163, 74, 0.2); border-radius: var(--radius-sm); padding: 6px 10px;">
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
@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="row g-4">
        {{-- Left Panel - Status --}}
        <div class="col-lg-4 mb-4">
            {{-- Welcome --}}
            <div class="mb-3">
                <h4 class="fw-bold" style="color: var(--text-primary); letter-spacing: -0.3px;">
                    Selamat Datang! 👋
                </h4>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 4px;">{{ $customer->nama }}</p>
                <span class="cp-badge info">{{ $customer->id_pelanggan }}</span>
            </div>

            {{-- Status Card --}}
            <div class="cp-card text-center" style="border: 2px solid {{ $isLunas ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)' }}; position: relative; overflow: hidden;">
                {{-- Decorative top bar --}}
                <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: {{ $isLunas ? 'var(--gradient-success)' : 'var(--gradient-danger)' }};"></div>
                
                <p class="mb-2 fw-semibold" style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 8px;">
                    Status Tagihan
                </p>
                <p class="mb-3" style="color: var(--primary); font-weight: 600; font-size: 0.9rem;">
                    {{ $bulanTarget }} {{ $tahunTarget }}
                </p>

                {{-- Masa Aktif --}}
                <div style="background: var(--bg); border-radius: var(--radius-md); padding: 14px; margin-bottom: 16px;">
                    <small style="color: var(--text-muted); display: block; margin-bottom: 4px; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">Masa Aktif Layanan</small>
                    <span class="fw-bold" style="color: var(--text-primary); font-size: 0.9rem;">
                        {{ $startActive->translatedFormat('d M Y') }} - {{ $endActive->translatedFormat('d M Y') }}
                    </span>
                </div>

                {{-- Batas Pembayaran --}}
                <div class="mb-3">
                    <small style="color: var(--text-muted); font-size: 0.78rem;">Batas Pembayaran:</small><br>
                    <span class="fw-bold fs-5" style="color: {{ $isLunas ? 'var(--success)' : 'var(--danger)' }};">
                        {{ $customer->jatuh_tempo }} {{ $bulanTarget }} {{ $tahunTarget }}
                    </span>
                </div>

                @if($isLunas)
                    <div class="py-2">
                        <div style="width: 64px; height: 64px; background: var(--success-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="bi bi-check-circle-fill" style="font-size: 2rem; color: var(--success);"></i>
                        </div>
                        <h3 class="fw-bold mb-0" style="color: var(--success);">TERBAYAR</h3>
                    </div>
                    <hr style="border-color: var(--border);">
                    <p style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 0;">
                        Terima kasih! Layanan aktif hingga <strong style="color: var(--text-primary);">{{ $endActive->translatedFormat('d F Y') }}</strong>.
                    </p>
                @else
                    <div class="py-2">
                        <div style="width: 64px; height: 64px; background: var(--danger-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                            <i class="bi bi-exclamation-circle-fill" style="font-size: 2rem; color: var(--danger);"></i>
                        </div>
                        <h3 class="fw-bold mb-0" style="color: var(--danger);">BELUM BAYAR</h3>
                    </div>
                    <hr style="border-color: var(--border);">
                    <p style="font-size: 0.82rem; color: var(--text-muted); margin-bottom: 0;">
                        Segera lakukan pembayaran untuk memperpanjang masa aktif hingga <strong style="color: var(--text-primary);">{{ $endActive->translatedFormat('d F Y') }}</strong>.
                    </p>
                @endif
            </div>
        </div>

        {{-- Right Panel - Payment History --}}
        <div class="col-lg-8 mb-4">
            <div class="cp-card h-100">
                <h5 class="fw-bold mb-4" style="color: var(--text-primary);">
                    <i class="bi bi-receipt me-2" style="color: var(--primary);"></i>Riwayat Pembayaran
                </h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Bulan / Tahun</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Tanggal Bayar</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $h)
                            <tr>
                                <td class="fw-bold" style="color: var(--text-primary);">{{ $h->bulan }} {{ $h->tahun }}</td>
                                <td class="fw-semibold" style="color: var(--primary);">
                                    Rp {{ number_format($h->nominal, 0, ',', '.') }}
                                </td>
                                <td>
                                    <span class="cp-badge {{ $h->metode == 'Transfer' ? 'info' : '' }}"
                                          style="{{ $h->metode != 'Transfer' ? 'background: var(--bg-alt); color: var(--text-secondary);' : '' }}">
                                        {{ $h->metode }}
                                    </span>
                                </td>
                                <td style="color: var(--text-muted);">
                                    {{ \Carbon\Carbon::parse($h->tanggal_bayar)->translatedFormat('d/m/Y') }}
                                </td>
                                <td class="text-center">
                                    <span class="cp-badge success">
                                        <i class="bi bi-patch-check-fill me-1"></i> Success
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="cp-empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Belum ada riwayat pembayaran tersedia.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
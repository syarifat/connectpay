@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h4 class="fw-bold">Selamat Datang, {{ $customer->nama }}!</h4>
            <p class="text-muted">ID Pelanggan: <span class="badge bg-info-subtle text-info px-3">{{ $customer->id_pelanggan }}</span></p>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card-custom p-4 text-center bg-white border-bottom border-4 {{ $isLunas ? 'border-success' : 'border-danger' }}">
                <p class="mb-2 text-muted fw-semibold">Status Tagihan ({{ $bulanIni }} {{ date('Y') }})</p>
                
                <div class="mb-3">
                    <span class="text-secondary small">Jatuh Tempo:</span><br>
                    <span class="fw-bold {{ $isLunas ? 'text-success' : 'text-danger' }} fs-5">
                        {{ $customer->jatuh_tempo }} {{ $bulanIni }} {{ date('Y') }}
                    </span>
                </div>

                @if($isLunas)
                    <h2 class="text-success fw-bold">TERBAYAR</h2>
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3.5rem;"></i>
                    <hr>
                    <p class="small text-secondary mb-0">Terima kasih telah melakukan pembayaran tepat waktu.</p>
                @else
                    <h2 class="text-danger fw-bold">BELUM BAYAR</h2>
                    <i class="bi bi-exclamation-circle-fill text-danger" style="font-size: 3.5rem;"></i>
                    <hr>
                    <p class="small text-secondary mb-0">Segera hubungi Admin untuk melakukan pembayaran.</p>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <div class="card-custom p-4 bg-white h-100">
                <h5 class="fw-bold mb-4 text-primary">Riwayat Pembayaran</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr class="text-secondary">
                                <th>Bulan / Tahun</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Tanggal Bayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $h)
                            <tr>
                                <td class="fw-bold">{{ $h->bulan }} {{ $h->tahun }}</td>
                                <td class="text-primary fw-semibold">Rp {{ number_format($h->nominal, 0, ',', '.') }}</td>
                                <td>{{ $h->metode }}</td>
                                <td class="text-muted">{{ date('d/m/Y', strtotime($h->tanggal_bayar)) }}</td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                        <i class="bi bi-patch-check-fill me-1"></i> Success
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada riwayat pembayaran.
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
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 cp-page-header">
        <div>
            <h1 class="cp-page-title">
                <i class="bi bi-people-fill me-2" style="color: var(--primary);"></i>Data Pelanggan
            </h1>
            <p class="cp-page-subtitle">Kelola seluruh data pelanggan ConnectPay</p>
        </div>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-connect px-4 mt-2 mt-md-0">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Pelanggan
        </a>
    </div>

    {{-- Table Card --}}
    <div class="cp-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 120px;">ID</th>
                        <th>Nama</th>
                        <th>Harga Paket</th>
                        <th class="text-center">Tempo</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $c)
                    <tr>
                        <td>
                            <span class="fw-bold" style="color: var(--primary); font-size: 0.85rem;">{{ $c->id_pelanggan }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 36px; height: 36px; background: var(--primary-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <span style="font-weight: 700; color: var(--primary); font-size: 0.8rem;">{{ strtoupper(substr($c->nama, 0, 1)) }}</span>
                                </div>
                                <span class="fw-semibold" style="font-size: 0.9rem;">{{ $c->nama }}</span>
                            </div>
                        </td>
                        <td>
                            @if($c->paket)
                                <span class="fw-bold" style="color: var(--success);">Rp {{ number_format($c->paket->harga, 0, ',', '.') }}</span>
                            @else
                                <span class="cp-badge" style="background: var(--bg-alt); color: var(--text-muted);">N/A</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="cp-badge danger">
                                <i class="bi bi-calendar-event me-1"></i> Tgl {{ $c->jatuh_tempo }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#detailPelanggan{{ $c->id }}"
                                        style="background: #e0f2fe; color: #0284c7; border: 1px solid rgba(2, 132, 199, 0.15); border-radius: var(--radius-sm); font-size: 0.78rem; padding: 6px 12px;">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </button>
                                <a href="{{ route('pelanggan.edit', $c->id) }}" class="btn btn-sm"
                                   style="background: var(--primary-subtle); color: var(--primary); border: 1px solid rgba(99, 102, 241, 0.15); border-radius: var(--radius-sm); padding: 6px 10px;">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('pelanggan.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data pelanggan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm" style="background: var(--danger-subtle); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: var(--radius-sm); padding: 6px 10px;">
                                        <i class="bi bi-trash3"></i>
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

{{-- Detail Modals --}}
@foreach($customers as $c)
<div class="modal fade" id="detailPelanggan{{ $c->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: var(--text-primary);">
                    <i class="bi bi-person-badge me-2" style="color: var(--primary);"></i>Detail Pelanggan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div style="width: 64px; height: 64px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px;">
                        <span style="font-weight: 700; color: white; font-size: 1.4rem;">{{ strtoupper(substr($c->nama, 0, 1)) }}</span>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $c->nama }}</h5>
                    <span class="cp-badge info">{{ $c->id_pelanggan }}</span>
                </div>

                <div style="background: var(--bg); border-radius: var(--radius-md); padding: 16px;">
                    <div class="row mb-2">
                        <div class="col-5" style="color: var(--text-muted); font-size: 0.85rem;">Paket Internet</div>
                        <div class="col-7 fw-semibold" style="font-size: 0.9rem;">
                            @if($c->paket)
                                {{ $c->paket->nama }} ({{ $c->paket->speed }}) <br>
                                <span style="color: var(--success);">Rp {{ number_format($c->paket->harga, 0, ',', '.') }}</span>
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5" style="color: var(--text-muted); font-size: 0.85rem;">Jatuh Tempo</div>
                        <div class="col-7 fw-semibold" style="font-size: 0.9rem;">Tanggal {{ $c->jatuh_tempo }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5" style="color: var(--text-muted); font-size: 0.85rem;">WhatsApp</div>
                        <div class="col-7" style="font-size: 0.9rem;">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c->nomor_wa) }}" target="_blank" style="color: #25D366; font-weight: 600; text-decoration: none;">
                                <i class="bi bi-whatsapp me-1"></i>{{ $c->nomor_wa }}
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5" style="color: var(--text-muted); font-size: 0.85rem;">Alamat</div>
                        <div class="col-7 fw-semibold" style="font-size: 0.9rem;">{{ $c->alamat }}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="gap: 8px;">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: var(--radius-sm);">Tutup</button>
                <a href="{{ route('pelanggan.edit', $c->id) }}" class="btn btn-connect px-4">
                    <i class="bi bi-pencil-square me-1"></i>Edit Data
                </a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
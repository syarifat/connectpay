@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-secondary">Daftar Pelanggan ConnectPay</h3>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-connect px-4">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Pelanggan
        </a>
    </div>

    <div class="card-custom p-4 bg-white shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr class="text-primary">
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
                        <td class="fw-bold text-dark">{{ $c->id_pelanggan }}</td>
                        <td><span class="fw-semibold">{{ $c->nama }}</span></td>
                        <td>
                            @if($c->paket)
                                <span class="text-success fw-bold">Rp {{ number_format($c->paket->harga, 0, ',', '.') }}</span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger-subtle text-danger px-3 py-2 border border-danger-subtle">
                                Tanggal {{ $c->jatuh_tempo }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailPelanggan{{ $c->id }}">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                                <a href="{{ route('pelanggan.edit', $c->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('pelanggan.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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

@foreach($customers as $c)
<div class="modal fade" id="detailPelanggan{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold">Detail Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-5 text-muted">ID Pelanggan</div>
                    <div class="col-7 fw-bold">: {{ $c->id_pelanggan }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 text-muted">Nama Lengkap</div>
                    <div class="col-7 fw-bold">: {{ $c->nama }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 text-muted">Paket Internet</div>
                    <div class="col-7">: 
                        @if($c->paket)
                            <span class="fw-bold">{{ $c->paket->nama }}</span> ({{ $c->paket->speed }}) <br>
                            <span class="text-success">Rp {{ number_format($c->paket->harga, 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 text-muted">Jatuh Tempo</div>
                    <div class="col-7">: Tanggal {{ $c->jatuh_tempo }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-5 text-muted">WhatsApp</div>
                    <div class="col-7">: 
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $c->nomor_wa) }}" target="_blank">
                            {{ $c->nomor_wa }}
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5 text-muted">Alamat</div>
                    <div class="col-7">: {{ $c->alamat }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('pelanggan.edit', $c->id) }}" class="btn btn-primary text-white">Edit Data</a>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
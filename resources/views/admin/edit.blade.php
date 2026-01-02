@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary">Edit Data Pelanggan</h4>
            <a href="/admin/pelanggan" class="btn btn-sm btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        
        <div class="card-custom bg-white p-4">
            <form action="{{ route('pelanggan.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 border-end">
                        <div class="mb-3">
                            <label class="form-label fw-bold">ID Pelanggan (Read-only)</label>
                            <input type="text" class="form-control bg-light" value="{{ $customer->id_pelanggan }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $customer->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIK</label>
                            <input type="number" name="nik" class="form-control" value="{{ $customer->nik }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp</label>
                            <input type="text" name="nomor_wa" class="form-control" value="{{ $customer->nomor_wa }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ $customer->alamat }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Paket Internet</label>
                            <select name="paket_id" class="form-select" required>
                                @foreach($pakets as $p)
                                    <option value="{{ $p->id }}" {{ $customer->paket_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->nama }} ({{ $p->speed }}) - Rp {{ number_format($p->harga, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-danger">Tanggal Jatuh Tempo</label>
                            <input type="number" name="jatuh_tempo" class="form-control" min="1" max="31" value="{{ $customer->jatuh_tempo }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">PPPoE Profile</label>
                            <input type="text" name="pppoe_profile" class="form-control" value="{{ $customer->pppoe_profile }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Rumah</label>
                            @if($customer->foto_rumah)
                                <div class="mb-2">
                                    <img src="{{ asset($customer->foto_rumah) }}" width="100" class="img-thumbnail border-primary">
                                </div>
                            @endif
                            <input type="file" name="foto_rumah" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-connect w-100 py-2 fw-bold"><i class="bi bi-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
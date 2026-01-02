@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary">Edit Data Pelanggan</h4>
            <a href="/admin/pelanggan" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
        
        <div class="card-custom bg-white p-4">
            <form action="{{ route('pelanggan.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 border-end">
                        <div class="mb-3">
                            <label class="form-label fw-bold">ID Pelanggan (Tetap)</label>
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
                            <label class="form-label fw-bold">Pilih Paket</label>
                            <select name="paket" class="form-select" required>
                                <option value="Lite - 10Mbps" {{ $customer->paket == 'Lite - 10Mbps' ? 'selected' : '' }}>Lite - 10Mbps</option>
                                <option value="Basic - 20Mbps" {{ $customer->paket == 'Basic - 20Mbps' ? 'selected' : '' }}>Basic - 20Mbps</option>
                                <option value="Pro - 50Mbps" {{ $customer->paket == 'Pro - 50Mbps' ? 'selected' : '' }}>Pro - 50Mbps</option>
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
                            <div class="mb-2">
                                @if($customer->foto_rumah)
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset($customer->foto_rumah) }}" width="150" class="img-thumbnail shadow-sm border-info">
                                        <span class="badge bg-primary position-absolute bottom-0 end-0">Foto Saat Ini</span>
                                    </div>
                                @else
                                    <div class="p-3 border rounded bg-light text-center">
                                        <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                                        <p class="small text-muted mb-0">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>
                            <input type="file" name="foto_rumah" class="form-control">
                            <small class="text-muted italic">Pilih file baru jika ingin mengganti foto.</small>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-connect w-100 py-2 fw-bold">
                        <i class="bi bi-save"></i> Simpan Perubahan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
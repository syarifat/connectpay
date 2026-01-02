@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary">Tambah Pelanggan Baru</h4>
            <a href="/admin/pelanggan" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-custom bg-white p-4">
            <form action="{{ route('pelanggan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 border-end">
                        <div class="mb-3">
                            <label class="form-label fw-bold">ID Pelanggan</label>
                            <input type="text" name="id_pelanggan" class="form-control" placeholder="Contoh: CP001" required>
                            <small class="text-muted">Akan digunakan sebagai username login.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama sesuai KTP" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">NIK</label>
                            <input type="number" name="nik" class="form-control" placeholder="16 Digit NIK" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp</label>
                            <input type="text" name="nomor_wa" class="form-control" placeholder="0812xxxx" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat pemasangan lengkap" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih Paket</label>
                            <select name="paket" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Paket --</option>
                                <option value="Lite - 10Mbps">Lite - 10Mbps (Rp150.000)</option>
                                <option value="Basic - 20Mbps">Basic - 20Mbps (Rp250.000)</option>
                                <option value="Pro - 50Mbps">Pro - 50Mbps (Rp450.000)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-danger">Tanggal Jatuh Tempo</label>
                            <input type="number" name="jatuh_tempo" class="form-control" min="1" max="31" placeholder="Isi Tanggal (1-31)" required>
                            <small class="text-muted">Contoh: Isi 10 jika jatuh tempo setiap tanggal 10.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">PPPoE Profile</label>
                            <input type="text" name="pppoe_profile" class="form-control" placeholder="Nama Profile Mikrotik">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Foto Rumah</label>
                            <input type="file" name="foto_rumah" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG (Maks 2MB)</small>
                        </div>
                        <div class="alert alert-info py-2 border-0">
                            <small><i class="bi bi-info-circle"></i> Password default pelanggan adalah: <strong>123456</strong></small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-light me-2 px-4">Reset</button>
                    <button type="submit" class="btn btn-connect px-5">Simpan Pelanggan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
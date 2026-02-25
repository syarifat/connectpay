@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 cp-page-header">
            <div>
                <h1 class="cp-page-title">
                    <i class="bi bi-person-plus-fill me-2" style="color: var(--primary);"></i>Tambah Pelanggan
                </h1>
                <p class="cp-page-subtitle">Isi data pelanggan baru ke sistem ConnectPay</p>
            </div>
            <a href="/admin/pelanggan" class="btn btn-light border px-3" style="border-radius: var(--radius-sm);">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        {{-- Form Card --}}
        <div class="cp-card">
            <form action="{{ route('pelanggan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- Left Column --}}
                    <div class="col-md-6">
                        <div class="mb-1 pb-2" style="border-bottom: 2px solid var(--primary-subtle);">
                            <h6 class="fw-bold mb-0" style="color: var(--primary);">
                                <i class="bi bi-person me-1"></i> Informasi Pribadi
                            </h6>
                        </div>
                        <div class="mt-3 mb-3">
                            <label class="form-label fw-bold">ID Pelanggan</label>
                            <input type="text" name="id_pelanggan" class="form-control" placeholder="Contoh: CP001" required>
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
                            <div class="input-group">
                                <span class="input-group-text" style="background: #dcfce7; color: #16a34a; border: 1.5px solid var(--border); border-right: 0;">
                                    <i class="bi bi-whatsapp"></i>
                                </span>
                                <input type="text" name="nomor_wa" class="form-control" placeholder="0812xxxx" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap pelanggan" required></textarea>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-md-6">
                        <div class="mb-1 pb-2" style="border-bottom: 2px solid var(--primary-subtle);">
                            <h6 class="fw-bold mb-0" style="color: var(--primary);">
                                <i class="bi bi-wifi me-1"></i> Informasi Layanan
                            </h6>
                        </div>
                        <div class="mt-3 mb-3">
                            <label class="form-label fw-bold">Pilih Paket Internet</label>
                            <select name="paket_id" class="form-select" required>
                                <option value="" selected disabled>-- Pilih Paket --</option>
                                @foreach($pakets as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->speed }}) - Rp {{ number_format($p->harga, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: var(--danger);">
                                <i class="bi bi-calendar-event me-1"></i> Tanggal Jatuh Tempo
                            </label>
                            <input type="number" name="jatuh_tempo" class="form-control" min="1" max="31" placeholder="Tanggal (1-31)" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">PPPoE Profile</label>
                            <input type="text" name="pppoe_profile" class="form-control" placeholder="Profile Mikrotik">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Rumah</label>
                            <input type="file" name="foto_rumah" class="form-control" accept="image/*">
                        </div>
                        <div style="background: #e0f2fe; border-radius: var(--radius-sm); padding: 12px 16px; color: #0284c7; font-size: 0.85rem;">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            Password login default: <strong>123456</strong>
                        </div>
                    </div>
                </div>

                <hr class="my-4" style="border-color: var(--border);">

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light border px-4" style="border-radius: var(--radius-sm);">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-connect px-5">
                        <i class="bi bi-check-lg me-1"></i> Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

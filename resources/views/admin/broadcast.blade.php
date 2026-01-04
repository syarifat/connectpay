@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-secondary">Broadcast WhatsApp</h3>
            <p class="text-muted">Kirim pesan informasi atau pengumuman ke banyak pelanggan sekaligus.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.broadcast') }}" class="btn btn-outline-primary fw-bold">
                <i class="bi bi-arrow-clockwise me-2"></i> Cek Koneksi
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light border px-4 fw-bold">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    {{-- LOGIKA CEK STATUS PERANGKAT --}}
    @if($deviceStatus !== 'connect')
        {{-- TAMPILAN JIKA WHATSAPP BELUM CONNECT / LOGOUT --}}
        <div class="row justify-content-center py-5">
            <div class="col-md-5">
                <div class="card-custom shadow-sm bg-white p-5 text-center">
                    <div class="mb-4">
                        <div class="display-1 text-danger mb-3">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <h4 class="fw-bold text-dark">WhatsApp Terputus</h4>
                        <p class="text-muted">Silahkan scan QR Code di bawah ini menggunakan aplikasi WhatsApp di HP Anda untuk menghubungkan sistem.</p>
                    </div>

                    @if($qrUrl)
                        <div class="bg-light p-4 rounded border border-dashed mb-4 d-inline-block">
                            <img src="data:image/png;base64,{{ $qrUrl }}" alt="QR Code Fonnte" class="img-fluid shadow-sm" style="max-width: 250px; border: 10px solid white;">
                        </div>
                        <div class="alert alert-warning border-0 small text-start">
                            <i class="bi bi-info-circle-fill me-2"></i> <strong>Penting:</strong> QR Code ini akan berganti otomatis setiap beberapa menit. Segera scan untuk menghubungkan.
                        </div>
                    @else
                        <div class="alert alert-danger border-0">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i>
                            Gagal memuat QR Code. Pastikan Token API WhatsApp di setting dengan benar.
                        </div>
                    @endif
                    
                    <p class="small text-muted mb-0">Setelah berhasil scan, klik tombol <strong>Cek Koneksi</strong> di pojok kanan atas.</p>
                </div>
            </div>
        </div>
    @else
        {{-- TAMPILAN FORM BROADCAST (LOGIKA ASLI ANDA) --}}
        <form action="{{ route('admin.broadcast.send') }}" method="POST" id="broadcastForm">
            @csrf
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card-custom shadow-sm bg-white p-4 h-100">
                        <div class="d-flex align-items-center mb-3 text-success">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span class="fw-bold small">WhatsApp Connected</span>
                        </div>
                        
                        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-chat-left-text me-2"></i> 1. Tulis Pesan</h5>
                        <div class="mb-3">
                            <textarea name="message" class="form-control border-info-subtle" rows="10" 
                                placeholder="Tulis pesan Anda di sini...&#10;&#10;Gunakan *teks* untuk cetak tebal." required></textarea>
                            <div class="form-text mt-2">
                                <small class="text-muted">Tips: Gunakan sapaan yang sopan agar pesan tidak dianggap spam.</small>
                            </div>
                        </div>
                        <div class="alert alert-info border-0 small">
                            <i class="bi bi-info-circle me-2"></i> Pesan akan dikirim satu per satu dengan delay otomatis untuk keamanan akun WhatsApp Anda.
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mb-4">
                    <div class="card-custom shadow-sm bg-white p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold text-primary mb-0"><i class="bi bi-people me-2"></i> 2. Pilih Penerima</h5>
                            
                            <div class="input-group w-50">
                                <span class="input-group-text bg-light border-info-subtle"><i class="bi bi-search"></i></span>
                                <input type="text" id="searchName" class="form-control border-info-subtle" placeholder="Cari nama pelanggan...">
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded mb-3 border">
                            <div class="form-check">
                                <input class="form-check-input border-primary" type="checkbox" id="checkAll">
                                <label class="form-check-label fw-bold text-primary" for="checkAll">
                                    Pilih Semua Pelanggan
                                </label>
                            </div>
                            <span class="badge bg-primary px-3 py-2" id="selectedCounter">0 Terpilih</span>
                        </div>

                        <input type="hidden" name="target_type" id="targetType" value="selected">

                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover align-middle border-start border-end" id="customerTable">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th style="width: 50px;">Pilih</th>
                                        <th>Nama Pelanggan</th>
                                        <th>ID Pelanggan</th>
                                        <th>Nomor WhatsApp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $c)
                                    <tr class="customer-row">
                                        <td class="text-center">
                                            <input type="checkbox" name="selected_ids[]" value="{{ $c->id }}" 
                                                class="form-check-input customer-checkbox border-info-subtle">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark customer-name">{{ $c->nama }}</div>
                                        </td>
                                        <td><span class="badge bg-light text-secondary border">{{ $c->id_pelanggan }}</span></td>
                                        <td><span class="text-success fw-medium"><i class="bi bi-whatsapp me-1"></i> {{ $c->nomor_wa }}</span></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">Data pelanggan tidak tersedia.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 border-top pt-3 text-end">
                            <button type="submit" class="btn btn-connect px-5 py-2 fs-5 shadow-sm" id="btnSubmit" disabled>
                                <i class="bi bi-send-fill me-2"></i> Kirim Pesan Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

@push('scripts')
<script>
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('.customer-checkbox');
    const targetTypeInput = document.getElementById('targetType');
    const selectedCounter = document.getElementById('selectedCounter');
    const btnSubmit = document.getElementById('btnSubmit');
    const searchInput = document.getElementById('searchName');
    const rows = document.querySelectorAll('.customer-row');

    // Fungsi update tampilan counter dan button
    function updateUI() {
        if (!selectedCounter) return; // Guard jika elemen tidak ada (saat disconnect)

        const checkedCount = document.querySelectorAll('.customer-checkbox:checked').length;
        selectedCounter.innerText = `${checkedCount} Terpilih`;
        
        btnSubmit.disabled = checkedCount === 0;
        
        if (checkedCount === checkboxes.length && checkedCount > 0) {
            targetTypeInput.value = 'all';
            checkAll.checked = true;
        } else {
            targetTypeInput.value = 'selected';
            checkAll.checked = false;
        }
    }

    if (checkAll) {
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                if (cb.closest('tr').style.display !== 'none') {
                    cb.checked = this.checked;
                }
            });
            updateUI();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateUI);
    });

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            rows.forEach(row => {
                const name = row.querySelector('.customer-name').innerText.toLowerCase();
                if (name.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    const broadcastForm = document.getElementById('broadcastForm');
    if (broadcastForm) {
        broadcastForm.onsubmit = function() {
            return confirm('Apakah Anda yakin ingin mengirim pesan broadcast ini ke ' + 
                   document.querySelectorAll('.customer-checkbox:checked').length + ' pelanggan?');
        };
    }
</script>
@endpush
@endsection
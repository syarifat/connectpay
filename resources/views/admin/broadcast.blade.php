@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 cp-page-header">
        <div>
            <h1 class="cp-page-title">
                <i class="bi bi-whatsapp me-2" style="color: #25D366;"></i>Broadcast WhatsApp
            </h1>
            <p class="cp-page-subtitle">Kirim pesan informasi atau pengumuman ke banyak pelanggan sekaligus</p>
        </div>
        <div class="d-flex gap-2 mt-2 mt-md-0">
            <a href="{{ route('admin.broadcast') }}" class="btn btn-light border px-3" style="border-radius: var(--radius-sm);">
                <i class="bi bi-arrow-clockwise me-1"></i> Cek Koneksi
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-light border px-3" style="border-radius: var(--radius-sm);">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    {{-- LOGIKA CEK STATUS PERANGKAT --}}
    @if($deviceStatus !== 'connect')
        {{-- TAMPILAN JIKA WHATSAPP BELUM CONNECT --}}
        <div class="row justify-content-center py-4">
            <div class="col-md-5">
                <div class="cp-card text-center" style="padding: 48px 32px;">
                    <div style="width: 80px; height: 80px; background: var(--danger-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                        <i class="bi bi-whatsapp" style="font-size: 2rem; color: var(--danger);"></i>
                    </div>
                    <h4 class="fw-bold mb-2" style="color: var(--text-primary);">WhatsApp Terputus</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 350px; margin: 0 auto 24px;">
                        Silahkan scan QR Code di bawah ini menggunakan aplikasi WhatsApp di HP Anda.
                    </p>

                    @if($qrUrl)
                        <div style="background: var(--bg); padding: 24px; border-radius: var(--radius-lg); border: 2px dashed var(--border); display: inline-block; margin-bottom: 20px;">
                            <img src="data:image/png;base64,{{ $qrUrl }}" alt="QR Code" style="max-width: 230px; border-radius: var(--radius-sm); border: 8px solid white; box-shadow: var(--shadow-md);">
                        </div>
                        <div style="background: var(--warning-subtle); border-radius: var(--radius-sm); padding: 12px 16px; color: #92400e; font-size: 0.85rem; text-align: left;">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            <strong>Penting:</strong> QR Code ini akan berganti otomatis setiap beberapa menit. Segera scan untuk menghubungkan.
                        </div>
                    @else
                        <div style="background: var(--danger-subtle); border-radius: var(--radius-sm); padding: 14px 16px; color: #991b1b; font-size: 0.9rem;">
                            <i class="bi bi-exclamation-octagon-fill me-2"></i>
                            Gagal memuat QR Code. Pastikan Token API WhatsApp di setting dengan benar.
                        </div>
                    @endif
                    
                    <p class="mt-3" style="color: var(--text-muted); font-size: 0.8rem;">
                        Setelah berhasil scan, klik tombol <strong>Cek Koneksi</strong> di pojok kanan atas.
                    </p>
                </div>
            </div>
        </div>
    @else
        {{-- TAMPILAN FORM BROADCAST --}}
        <form action="{{ route('admin.broadcast.send') }}" method="POST" id="broadcastForm">
            @csrf
            <div class="row g-4">
                {{-- Left Panel -  Message --}}
                <div class="col-lg-4">
                    <div class="cp-card h-100">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div style="width: 8px; height: 8px; background: var(--success); border-radius: 50%; box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);"></div>
                            <span class="fw-bold" style="color: var(--success); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px;">WhatsApp Connected</span>
                        </div>
                        
                        <h6 class="fw-bold mb-3" style="color: var(--text-primary);">
                            <i class="bi bi-chat-left-text me-2" style="color: var(--primary);"></i>1. Tulis Pesan
                        </h6>

                        <div class="mb-3">
                            <textarea name="message" class="form-control" rows="10" 
                                placeholder="Tulis pesan Anda di sini...&#10;&#10;Gunakan *teks* untuk cetak tebal." required
                                style="resize: vertical;"></textarea>
                            <div class="mt-2" style="font-size: 0.78rem; color: var(--text-muted);">
                                <i class="bi bi-lightbulb me-1"></i>
                                Tips: Gunakan sapaan yang sopan agar pesan tidak dianggap spam.
                            </div>
                        </div>

                        <div style="background: #e0f2fe; border-radius: var(--radius-sm); padding: 12px 16px; color: #0284c7; font-size: 0.82rem;">
                            <i class="bi bi-info-circle me-1"></i>
                            Pesan dikirim satu per satu dengan delay otomatis untuk keamanan akun WhatsApp Anda.
                        </div>
                    </div>
                </div>

                {{-- Right Panel - Recipients --}}
                <div class="col-lg-8">
                    <div class="cp-card h-100">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
                            <h6 class="fw-bold mb-0" style="color: var(--text-primary);">
                                <i class="bi bi-people me-2" style="color: var(--primary);"></i>2. Pilih Penerima
                            </h6>
                            <div class="input-group" style="max-width: 280px;">
                                <span class="input-group-text" style="background: var(--bg); border: 1.5px solid var(--border); border-right: 0;">
                                    <i class="bi bi-search" style="color: var(--text-muted);"></i>
                                </span>
                                <input type="text" id="searchName" class="form-control" placeholder="Cari nama..." style="border-left: 0;">
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between p-3 mb-3" 
                             style="background: var(--primary-subtle); border-radius: var(--radius-md); border: 1px solid rgba(99, 102, 241, 0.1);">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkAll" style="border-color: var(--primary);">
                                <label class="form-check-label fw-bold" for="checkAll" style="color: var(--primary); font-size: 0.9rem;">
                                    Pilih Semua Pelanggan
                                </label>
                            </div>
                            <span class="cp-badge" id="selectedCounter" style="background: var(--gradient-primary); color: white; border: none;">0 Terpilih</span>
                        </div>

                        <input type="hidden" name="target_type" id="targetType" value="selected">

                        <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0" id="customerTable">
                                <thead style="position: sticky; top: 0; z-index: 1;">
                                    <tr>
                                        <th style="width: 50px;">Pilih</th>
                                        <th>Nama Pelanggan</th>
                                        <th>ID</th>
                                        <th>WhatsApp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customers as $c)
                                    <tr class="customer-row">
                                        <td class="text-center">
                                            <input type="checkbox" name="selected_ids[]" value="{{ $c->id }}" 
                                                class="form-check-input customer-checkbox" style="border-color: var(--primary-light);">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div style="width: 32px; height: 32px; background: var(--primary-subtle); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                    <span style="font-weight: 700; color: var(--primary); font-size: 0.7rem;">{{ strtoupper(substr($c->nama, 0, 1)) }}</span>
                                                </div>
                                                <span class="fw-semibold customer-name" style="font-size: 0.9rem;">{{ $c->nama }}</span>
                                            </div>
                                        </td>
                                        <td><span class="cp-badge" style="background: var(--bg-alt); color: var(--text-secondary);">{{ $c->id_pelanggan }}</span></td>
                                        <td>
                                            <span style="color: #25D366; font-weight: 500; font-size: 0.85rem;">
                                                <i class="bi bi-whatsapp me-1"></i>{{ $c->nomor_wa }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4">
                                            <div class="cp-empty-state">
                                                <i class="bi bi-people"></i>
                                                <p>Data pelanggan tidak tersedia.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 pt-3 text-end" style="border-top: 1px solid var(--border);">
                            <button type="submit" class="btn btn-connect px-5 py-2" id="btnSubmit" disabled style="font-size: 1rem;">
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

    function updateUI() {
        if (!selectedCounter) return;

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
                row.style.display = name.includes(filter) ? '' : 'none';
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
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Page Header --}}
    <div class="mb-4 cp-page-header">
        <h1 class="cp-page-title">
            <i class="bi bi-clock-history me-2" style="color: var(--primary);"></i>Log Aktivitas
        </h1>
        <p class="cp-page-subtitle">Daftar pelanggan dan admin yang masuk ke sistem ConnectPay</p>
    </div>

    {{-- Logs Table --}}
    <div class="cp-card" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="padding-left: 24px;">Waktu Login</th>
                        <th>Nama / Username</th>
                        <th>Role</th>
                        <th>IP Address</th>
                        <th>Perangkat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td style="padding-left: 24px;">
                            <div style="font-size: 0.9rem; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($log->login_at)->format('d M Y, H:i') }}
                                <span style="color: var(--text-muted); font-size: 0.75rem;">WIB</span>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 32px; height: 32px; background: {{ $log->user->role == 'admin' ? 'var(--danger-subtle)' : 'var(--primary-subtle)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="bi bi-{{ $log->user->role == 'admin' ? 'shield-lock' : 'person' }}" 
                                       style="color: {{ $log->user->role == 'admin' ? 'var(--danger)' : 'var(--primary)' }}; font-size: 0.8rem;"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size: 0.9rem;">{{ $log->user->customer->nama ?? 'Administrator' }}</div>
                                    <small style="color: var(--text-muted); font-size: 0.78rem;">{{ $log->user->username }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="cp-badge {{ $log->user->role == 'admin' ? 'danger' : '' }}" 
                                  style="{{ $log->user->role != 'admin' ? 'background: var(--primary-subtle); color: var(--primary); border: 1px solid rgba(99, 102, 241, 0.2);' : '' }}">
                                {{ ucfirst($log->user->role) }}
                            </span>
                        </td>
                        <td>
                            <code style="background: var(--bg); padding: 4px 10px; border-radius: var(--radius-sm); font-size: 0.8rem; color: var(--text-secondary);">
                                {{ $log->ip_address }}
                            </code>
                        </td>
                        <td>
                            <small style="color: var(--text-muted); font-size: 0.8rem;">
                                {{ Str::limit($log->user_agent, 50) }}
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3">
        {{ $logs->links() }}
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-secondary">Log Aktivitas Login</h3>
        <p class="text-muted">Daftar pelanggan dan admin yang masuk ke sistem ConnectPay.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Waktu Login</th>
                            <th>Nama / Username</th>
                            <th>Role</th>
                            <th>IP Address</th>
                            <th>Perangkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($log->login_at)->format('d M Y, H:i') }} WIB</td>
                            <td>
                                <div class="fw-bold">{{ $log->user->customer->nama ?? 'Administrator' }}</div>
                                <small class="text-muted">{{ $log->user->username }}</small>
                            </td>
                            <td>
                                <span class="badge {{ $log->user->role == 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ ucfirst($log->user->role) }}
                                </span>
                            </td>
                            <td><code class="small">{{ $log->ip_address }}</code></td>
                            <td><small class="text-muted">{{ Str::limit($log->user_agent, 50) }}</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-3">
        {{ $logs->links() }}
    </div>
</div>
@endsection
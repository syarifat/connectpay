@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">Daftar Paket Internet</h4>
        <a href="{{ route('pakets.create') }}" class="btn btn-connect px-4">+ Tambah Paket</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="card-custom bg-white p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama Paket</th>
                        <th>Kecepatan</th>
                        <th>Harga</th>
                        <th>Total Pelanggan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pakets as $p)
                    <tr>
                        <td class="fw-bold">{{ $p->nama }}</td>
                        <td><span class="badge bg-info-subtle text-info">{{ $p->speed }}</span></td>
                        <td class="text-primary">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                        <td>{{ $p->customers->count() }} User</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('pakets.edit', $p->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('pakets.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus paket ini?')">
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
@endsection
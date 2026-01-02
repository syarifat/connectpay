@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-secondary">Daftar Pelanggan</h3>
        <a href="{{ route('pelanggan.create') }}" class="btn btn-connect px-4">+ Tambah Pelanggan</a>
    </div>

    <div class="card-custom p-4 bg-white">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr class="text-primary">
                    <th>ID Pelanggan</th>
                    <th>Nama</th>
                    <th>Paket</th>
                    <th>PPPoE Profile</th>
                    <th>Status Tagihan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $c)
                <tr>
                    <td class="fw-bold">{{ $c->id_pelanggan }}</td>
                    <td>{{ $c->nama }}</td>
                    <td><span class="badge bg-info-subtle text-info">{{ $c->paket }}</span></td>
                    <td><code>{{ $c->pppoe_profile }}</code></td>
                    <td>
                        <span class="badge bg-success-subtle text-success">Lunas</span>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('pelanggan.edit', $c->id) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <form action="{{ route('pelanggan.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini? Semua data login juga akan terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                        <a href="{{ route('admin.pembayaran', $c->id) }}" class="btn btn-sm btn-outline-success me-2" title="Kelola Pembayaran">
                            <i class="bi bi-wallet2"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
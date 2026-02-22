@extends('layouts.app')

@section('title', 'Karyawan Produksi')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Karyawan Produksi</h4>
            <p class="text-muted mb-0">Kelola data produksi karyawan</p>
        </div>
        <a href="{{ route('karyawan_produksi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Produksi Karyawan
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4">No</th>
                            <th>Karyawan</th>
                            <th>Produksi (Produk)</th>
                            <th>Tanggal Produksi</th>
                            <th>Jumlah Unit</th>
                            <th class="text-end px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produksiKaryawans as $index => $produksiKaryawan)
                        <tr>
                            <td class="px-4">{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $produksiKaryawan->karyawan->nama ?? 'Tanpa Karyawan' }}</strong>
                            </td>
                            <td>{{ $produksiKaryawan->produksi->produk->nama_produk ?? 'Tanpa Produk' }}</td>
                            <td>{{ \Carbon\Carbon::parse($produksiKaryawan->tanggal_produksi)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge bg-info fs-6">
                                    {{ number_format($produksiKaryawan->jumlah_unit) }}
                                </span>
                            </td>
                            <td class="text-end px-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('karyawan_produksi.show', $produksiKaryawan->id_karyawan_produksi) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('karyawan_produksi.edit', $produksiKaryawan->id_karyawan_produksi) }}" 
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('karyawan_produksi.destroy', $produksiKaryawan->id_karyawan_produksi) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2"></i>
                                    <p class="mb-0">Belum ada data produksi karyawan</p>
                                    <a href="{{ route('karyawan_produksi.create') }}" class="btn btn-primary btn-sm mt-2">
                                        Tambah Data Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

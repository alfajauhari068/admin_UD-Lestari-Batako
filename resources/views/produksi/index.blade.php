@extends('layouts.app')

@section('title', 'Master Ongkos Produksi')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Master Ongkos Produksi</h4>
            <p class="text-muted mb-0">Kelola tarif upah per unit untuk setiap produk</p>
        </div>
        <a href="{{ route('produksi.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Ongkos
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
                            <th class="px-4">Produk</th>
                            <th>Upah per Unit</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                            <th class="text-end px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produksis as $produksi)
                        <tr>
                            <td class="px-4">
                                <strong>{{ $produksi->produk->nama_produk ?? 'Tanpa Produk' }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    Rp {{ number_format($produksi->upah_per_unit, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>{{ $produksi->satuan }}</td>
                            <td>{{ $produksi->keterangan ?? '-' }}</td>
                            <td class="text-end px-4">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('produksi.show', $produksi->id_produksi) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('produksi.edit', $produksi->id_produksi) }}" 
                                       class="btn btn-sm btn-outline-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('produksi.destroy', $produksi->id_produksi) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin hapus ongkos ini?')">
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
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-cash-stack fs-1 d-block mb-2"></i>
                                    <p class="mb-0">Belum ada master ongkos</p>
                                    <a href="{{ route('produksi.create') }}" class="btn btn-primary btn-sm mt-2">
                                        Tambah Ongkos Pertama
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

@extends('layouts.app')

@section('title', 'Detail Master Ongkos')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produksi.index') }}">Master Ongkos</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>

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

    <div class="row">
        <!-- Detail Card -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Ongkos</h5>
                        <a href="{{ route('produksi.edit', $produksi->id_produksi) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-muted ps-0">Produk</td>
                            <td class="fw-bold">{{ $produksi->produk->nama_produk ?? 'Tanpa Produk' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Upah per Unit</td>
                            <td>
                                <span class="badge bg-success fs-6">
                                    Rp {{ number_format($produksi->upah_per_unit, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Satuan</td>
                            <td>{{ $produksi->satuan }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Keterangan</td>
                            <td>{{ $produksi->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Dibuat</td>
                            <td>{{ $produksi->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <!-- Delete Button -->
                    <hr>
                    <form action="{{ route('produksi.destroy', $produksi->id_produksi) }}" 
                          method="POST" 
                          onsubmit="return confirm('Yakin hapus master ongkos ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                            <i class="bi bi-trash"></i> Hapus Ongkos
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi Card -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Transaksi</h5>
                        <a href="{{ route('tim-produksi.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-lg"></i> Tambah Transaksi
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($riwayatTransaksi->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-3">Tanggal</th>
                                    <th>Karyawan</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end">Upah/Unit</th>
                                    <th class="text-end px-3">Total Upah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatTransaksi as $transaksi)
                                <tr>
                                    <td class="px-3">{{ \Carbon\Carbon::parse($transaksi->tanggal_produksi)->format('d/m/Y') }}</td>
                                    <td>{{ $transaksi->karyawan->nama_karyawan ?? 'N/A' }}</td>
                                    <td class="text-end">{{ number_format($transaksi->jumlah_produksi) }} {{ $produksi->satuan }}</td>
                                    <td class="text-end">Rp {{ number_format($transaksi->upah_per_unit, 0, ',', '.') }}</td>
                                    <td class="text-end px-3 fw-bold">
                                        Rp {{ number_format($transaksi->total_upah, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                            <p class="mb-2">Belum ada transaksi</p>
                            <a href="{{ route('tim-produksi.create') }}" class="btn btn-primary btn-sm">
                                Catat Transaksi Pertama
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="page-container">
        
{{-- Header --}}
        <section class="dashboard-header">
            <h1>Daftar Pesanan</h1>
            <p>Manajemen pesanan UD. Lestari Batako</p>
        </section>
        
        {{-- Breadcrumb --}}
        <div class="">
            @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Pesanan', 'url' => route('pesanan.index')]
                ])
            @endcomponent
        </div>

        {{-- Header --}}
        <div class="row justify-content-between align-items-center mb-">
            <div class="col-auto">
                <h4 class="fw-bold text-primary"><i class="bi bi-cart"></i>Data Pesanan</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('pesanan.create') }}" class="btn btn-primary rounded-circle shadow-sm d-flex justify-content-center align-items-center p-2"
                   data-bs-toggle="tooltip" title="Tambah Pesanan">
                    <i class="bi bi-plus-circle fs-4"></i>
                </a>
            </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill text-success me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger mt-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-circle-fill text-danger me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Card Table --}}
        <div class="table-industrial-wrapper">
            <div class="p-3">
                <div class="table-responsive">
                    <table class="table custom-table striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pesanans as $pesanan)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td>{{ $pesanan->id_pesanan }}</td>
                                <td>{{ $pesanan->pelanggan->nama }}</td>
                                <td>{{ $pesanan->catatan ?? '-' }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- Tombol Detail --}}
                                        <a href="{{ route('pesanan.detail', $pesanan->id_pesanan) }}" 
                                           class="btn btn-primary btn-sm btn-icon" 
                                           data-bs-toggle="tooltip" title="Lihat Detail Pesanan">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Tombol Atur Pengiriman --}}
                                        <a href="{{ route('pengiriman.create', $pesanan->id_pesanan) }}" 
                                           class="btn btn-success btn-sm btn-icon" 
                                           data-bs-toggle="tooltip" title="Atur Pengiriman">
                                            <i class="bi bi-truck"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted fst-italic">Belum ada pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end small text-muted bg-white">
                UD Lestari Batako &copy; {{ date('Y') }}
            </div>
        </div>
    </div>
</div>

{{-- Tooltip Init --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(el => new bootstrap.Tooltip(el));
    });
</script>
@endsection

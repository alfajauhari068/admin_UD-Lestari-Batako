@extends('layouts.app')

@section('content')
<div class="d-flex">
    <div class="container-fluid py- p-5" style="padding-top: 80px; background:rgba(252,252,252,0.61); min-height: 100vh;">

        {{-- Header --}}
        <section class="dashboard-header">
            <h1>Riwayat Upah Karyawan</h1>
            <p>Manajemen riwayat upah</p>
            <span class="badge bg-secondary">Upah dibagi rata per tim produksi</span>
        </section>

        {{-- Breadcrumb --}}
        <div class="">
                @component('components.breadcrumb')
                    @slot('breadcrumbs', [
                        ['name' => 'Tim Produksi', 'url' => route('karyawan_produksi.index')]
                    ])
                @endcomponent
        </div>

        {{-- Header --}}
        <div class="row justify-content-between align-items-center  p-">
            <div class="col-auto">
                <h4 class="fw-bold text-primary">Daftar Produksi Karyawan</h4>
            </div>
            <div class="panel-actions">
                    <a href="{{ route('tim_produksi.index') }}" class="btn btn-primary" title="Lihat Tim Produksi">Lihat Tim Produksi</a>
                </div>
            <div class="col-auto">
                {{-- intentionally no create button on per-karyawan dashboard --}}
            </div>
        </div>

        {{-- Card Tabel --}}
        <div class="table-industrial-wrapper">
            <div style="padding: 1.5rem;">
                {{-- Alert Sukses --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Error --}}
                @if($errors->any())
                    <div class="alert alert-danger mb-4 shadow-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="bi bi-exclamation-circle-fill me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-industrial striped">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 60px;">No</th>
                                <th>Nama Produksi</th>
                                <th style="text-align: center;">Tanggal Produksi</th>
                                <th style="text-align: center;">Jumlah Unit</th>
                                <th style="text-align: center;">Gaji Diterima</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produksiKaryawans as $produksiKaryawan)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td>{{ $produksiKaryawan->produksi->nama_produksi ?? $produksiKaryawan->produksi->produk->nama_produk ?? 'N/A' }}</td>
                                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($produksiKaryawan->tanggal_produksi)->format('d M Y') }}</td>
                                    <td style="text-align: center;">{{ $produksiKaryawan->jumlah_unit }}</td>
                                    <td style="text-align: center;">
                                        @if($produksiKaryawan->gaji_diterima === null)
                                            <span class="text-muted">Belum dihitung</span>
                                        @else
                                            Rp{{ number_format($produksiKaryawan->gaji_diterima, 0, ',', '.') }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; color: #94A3B8; padding: 2rem;">Belum ada data produksi karyawan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

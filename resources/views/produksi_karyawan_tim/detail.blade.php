@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mt-4">
        @component('components.breadcrumb')
            @slot('breadcrumbs', [
                ['name' => 'Produksi Karyawan Tim', 'url' => route('tim_produksi.index')],
                ['name' => 'Detail Tim', 'url' => route('tim_produksi.detail', ['id' => $record->produksi->id_produksi ?? $record->id_produksi, 'tanggal' => $record->tanggal_produksi])]
            ])
        @endcomponent
    </div>

    <h2 class="mb-4">Detail Produksi Tim</h2>

    {{-- INFO PRODUKSI --}}
    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title mb-3">Informasi Produksi</h5>
        <table class="table table-borderless">
            <tr>
                <th style="width: 30%;">Nama Produksi</th>
                <td>{{ $record->produksi->produk->nama_produk ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Tanggal Produksi</th>
                <td>{{ \Carbon\Carbon::parse($record->tanggal_produksi)->format('d M Y') }}</td>
            </tr>
            <tr>
                <th>Patokan Unit (jumlah_per_unit)</th>
                <td>{{ $record->produksi->jumlah_per_unit }} unit</td>
            </tr>
            <tr>
                <th>Gaji Per Patokan</th>
                <td>Rp{{ number_format($record->produksi->gaji_per_unit ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    {{-- RINGKASAN GAJI TIM --}}
    <div class="card shadow-sm p-4 mb-4 bg-light">
        <h5 class="card-title mb-3">Ringkasan Gaji Tim (Otomatis)</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card border-0 bg-white">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Unit Tim</h6>
                        <h3 class="text-primary">{{ $total_unit_tim }}</h3>
                        <small class="text-muted">unit</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-white">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Upah Tim</h6>
                        <h3 class="text-success">Rp{{ number_format($total_gaji_tim, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-white">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Jumlah Anggota</h6>
                        <h3 class="text-info">{{ $jumlah_anggota }}</h3>
                        <small class="text-muted">orang</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 bg-white">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Upah per Karyawan</h6>
                        <h3 class="text-danger">Rp{{ number_format($gaji_per_karyawan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Rumus Perhitungan (Info untuk pengguna) --}}
        <div class="mt-3 alert alert-info">
            <strong>Rumus Perhitungan:</strong><br>
            <small>
                Total Upah = ({{ $total_unit_tim }} ÷ {{ $record->produksi->jumlah_per_unit }}) × Rp{{ number_format($record->produksi->gaji_per_unit, 0, ',', '.') }} 
                = Rp{{ number_format($total_gaji_tim, 0, ',', '.') }}<br>
                Upah per Karyawan = Rp{{ number_format($total_gaji_tim, 0, ',', '.') }} ÷ {{ $jumlah_anggota }} 
                = Rp{{ number_format($gaji_per_karyawan, 0, ',', '.') }}
            </small>
        </div>
    </div>

    

    <div class="mt-4">
        <a href="{{ route('tim_produksi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection

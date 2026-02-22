@extends('layouts.app')

@section('title', 'Detail Pengiriman')

@section('content')
<div class="container-fluid py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengiriman.index') }}">Pengiriman</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail</li>
        </ol>
    </nav>

    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-file-earmark-text me-2"></i>Detail Pengiriman
            </h2>
            <p class="text-muted">Informasi lengkap pengiriman</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('pengiriman.edit', $pengiriman->id_pengiriman) }}" class="btn btn-warning">
                <i class="bi bi-pencil-fill me-1"></i>Edit
            </a>
            <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle me-1"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Status Badge --}}
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body text-center py-4">
                    @php
                        $statusBadge = [
                            'Menunggu Dijadwalkan' => 'warning',
                            'Dalam Pengiriman' => 'info',
                            'Terkirim' => 'success',
                            'Dibatalkan' => 'danger',
                        ];
                        $badgeClass = $statusBadge[$pengiriman->status] ?? 'secondary';
                    @endphp
                    <h3>
                        <span class="badge bg-{{ $badgeClass }} fs-5 px-4 py-2">
                            <i class="bi bi-circle-fill me-2" style="font-size: 0.6em;"></i>
                            {{ $pengiriman->status ?? 'N/A' }}
                        </span>
                    </h3>
                    <p class="text-muted mt-2 mb-0">Status Pengiriman</p>
                </div>
            </div>
        </div>

        {{-- Informasi Pesanan --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="fw-bold">Kode Pesanan</td>
                            <td>: #PSN-{{ str_pad($pengiriman->pesanan->id_pesanan ?? 0, 4, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Nama Pelanggan</td>
                            <td>: {{ $pengiriman->pesanan->pelanggan->nama ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">No WhatsApp</td>
                            <td>: {{ $pengiriman->pesanan->pelanggan->no_hp ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email</td>
                            <td>: {{ $pengiriman->pesanan->pelanggan->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total Bayar</td>
                            <td>: <strong class="text-success">Rp {{ number_format($pengiriman->pesanan->total_bayar ?? 0, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Status Pesanan</td>
                            <td>: <span class="badge bg-primary">{{ ucfirst($pengiriman->pesanan->status ?? 'N/A') }}</span></td>
                        </tr>
                    </table>

                    <hr>

                    <h6 class="fw-bold mb-3">Produk yang Dipesan:</h6>
                    <ul class="list-group">
                        @forelse($pengiriman->pesanan->detailPesanan ?? [] as $detail)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $detail->produk->nama ?? 'N/A' }}</strong><br>
                                <small class="text-muted">{{ $detail->jumlah }} {{ $detail->produk->satuan ?? 'pcs' }}</small>
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                Rp {{ number_format($detail->total_bayar ?? 0, 0, ',', '.') }}
                            </span>
                        </li>
                        @empty
                        <li class="list-group-item text-muted">Tidak ada detail produk</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- Informasi Pengiriman --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-truck me-2"></i>Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="fw-bold">Tanggal Pengiriman</td>
                            <td>: {{ $pengiriman->tanggal_pengiriman ? \Carbon\Carbon::parse($pengiriman->tanggal_pengiriman)->format('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jenis Pengiriman</td>
                            <td>: <span class="badge bg-secondary">{{ $pengiriman->jenis_pengiriman ?? '-' }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Alamat Pengiriman</td>
                            <td>: {{ $pengiriman->alamat_pengiriman ?? '-' }}</td>
                        </tr>
                        @if($pengiriman->kecamatan || $pengiriman->kabupaten || $pengiriman->provinsi)
                        <tr>
                            <td class="fw-bold">Wilayah</td>
                            <td>: 
                                @if($pengiriman->kecamatan) Kec. {{ $pengiriman->kecamatan }}, @endif
                                @if($pengiriman->kabupaten) {{ $pengiriman->kabupaten }}, @endif
                                @if($pengiriman->provinsi) {{ $pengiriman->provinsi }} @endif
                            </td>
                        </tr>
                        @endif
                        @if($pengiriman->latitude && $pengiriman->longitude)
                        <tr>
                            <td class="fw-bold">Koordinat GPS</td>
                            <td>: 
                                <code>{{ number_format($pengiriman->latitude, 6) }}, {{ number_format($pengiriman->longitude, 6) }}</code>
                                <a href="https://www.google.com/maps?q={{ $pengiriman->latitude }},{{ $pengiriman->longitude }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary ms-2"
                                   data-bs-toggle="tooltip"
                                   title="Buka di Google Maps">
                                    <i class="bi bi-geo-alt-fill"></i> Lihat di Maps
                                </a>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="fw-bold">Catatan</td>
                            <td>: {{ $pengiriman->catatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dibuat Pada</td>
                            <td>: {{ $pengiriman->created_at ? $pengiriman->created_at->format('d F Y, H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Terakhir Diupdate</td>
                            <td>: {{ $pengiriman->updated_at ? $pengiriman->updated_at->format('d F Y, H:i') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Peta Lokasi --}}
        @if($pengiriman->latitude && $pengiriman->longitude)
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-map me-2"></i>Peta Lokasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div id="map" style="height: 450px; border-radius: 8px;"></div>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

@if($pengiriman->latitude && $pengiriman->longitude)
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $pengiriman->latitude }};
    const lng = {{ $pengiriman->longitude }};
    
    // Inisialisasi peta
    const map = L.map('map').setView([lat, lng], 15);
    
    // Tambahkan tile layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Tambahkan marker
    const marker = L.marker([lat, lng]).addTo(map);
    marker.bindPopup(`
        <div style="min-width: 200px;">
            <h6 class="mb-2"><strong>Lokasi Pengiriman</strong></h6>
            <p class="mb-1"><small>{{ $pengiriman->alamat_pengiriman }}</small></p>
            <p class="mb-0"><small class="text-muted">{{ $pengiriman->pesanan->pelanggan->nama ?? 'N/A' }}</small></p>
        </div>
    `).openPopup();
    
    // Tambahkan circle untuk area
    L.circle([lat, lng], {
        color: 'blue',
        fillColor: '#30f',
        fillOpacity: 0.1,
        radius: 500
    }).addTo(map);
});

// Initialize tooltips
document.addEventListener("DOMContentLoaded", function () {
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(el => new bootstrap.Tooltip(el));
});
</script>
@endif

@endsection

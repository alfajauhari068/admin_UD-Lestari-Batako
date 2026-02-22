@extends('layouts.app')

@section('title', 'Edit Pengiriman')

@section('content')
<div class="container-fluid py-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pengiriman.index') }}">Pengiriman</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold text-primary">
                <i class="bi bi-pencil-square me-2"></i>Edit Pengiriman
            </h2>
            <p class="text-muted">Perbarui informasi pengiriman</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="bi bi-clipboard-check me-2"></i>Form Edit Pengiriman</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pengiriman.update', $pengiriman->id_pengiriman) }}" method="POST" id="formPengiriman">
                @csrf
                @method('PUT')

                {{-- Error Messages --}}
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Terdapat kesalahan:</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="row g-3">
                    {{-- Info Pesanan (Read-only) --}}
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informasi Pesanan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="mb-1"><strong>Kode Pesanan:</strong></p>
                                        <p class="text-muted">#PSN-{{ str_pad($pengiriman->pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="mb-1"><strong>Nama Pelanggan:</strong></p>
                                        <p class="text-muted">{{ $pengiriman->pesanan->pelanggan->nama ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="mb-1"><strong>No WhatsApp:</strong></p>
                                        <p class="text-muted">{{ $pengiriman->pesanan->pelanggan->no_hp ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="mb-1"><strong>Total Bayar:</strong></p>
                                        <p class="text-muted">Rp {{ number_format($pengiriman->pesanan->total_bayar, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <p class="mb-1"><strong>Produk & Jumlah:</strong></p>
                                        <ul class="text-muted mb-0">
                                            @foreach($pengiriman->pesanan->detailPesanan as $detail)
                                            <li>{{ $detail->produk->nama ?? 'N/A' }} - {{ $detail->jumlah }} {{ $detail->produk->satuan ?? 'pcs' }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal Pengiriman --}}
                    <div class="col-md-6">
                        <label for="tanggal_pengiriman" class="form-label fw-bold">
                            Tanggal Pengiriman <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               class="form-control @error('tanggal_pengiriman') is-invalid @enderror" 
                               id="tanggal_pengiriman" 
                               name="tanggal_pengiriman" 
                               value="{{ old('tanggal_pengiriman', $pengiriman->tanggal_pengiriman?->format('Y-m-d')) }}" 
                               required>
                        @error('tanggal_pengiriman')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis Pengiriman --}}
                    <div class="col-md-6">
                        <label for="jenis_pengiriman" class="form-label fw-bold">
                            Jenis Pengiriman <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('jenis_pengiriman') is-invalid @enderror" 
                                id="jenis_pengiriman" 
                                name="jenis_pengiriman" 
                                required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Internal / Ambil Sendiri" {{ old('jenis_pengiriman', $pengiriman->jenis_pengiriman) == 'Internal / Ambil Sendiri' ? 'selected' : '' }}>Internal / Ambil Sendiri</option>
                            <option value="Kurir Lokal" {{ old('jenis_pengiriman', $pengiriman->jenis_pengiriman) == 'Kurir Lokal' ? 'selected' : '' }}>Kurir Lokal</option>
                            <option value="Ekspedisi" {{ old('jenis_pengiriman', $pengiriman->jenis_pengiriman) == 'Ekspedisi' ? 'selected' : '' }}>Ekspedisi</option>
                        </select>
                        @error('jenis_pengiriman')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-12">
                        <label for="status" class="form-label fw-bold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="Menunggu Dijadwalkan" {{ old('status', $pengiriman->status) == 'Menunggu Dijadwalkan' ? 'selected' : '' }}>Menunggu Dijadwalkan</option>
                            <option value="Dalam Pengiriman" {{ old('status', $pengiriman->status) == 'Dalam Pengiriman' ? 'selected' : '' }}>Dalam Pengiriman</option>
                            <option value="Terkirim" {{ old('status', $pengiriman->status) == 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                            <option value="Dibatalkan" {{ old('status', $pengiriman->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Status "Terkirim" akan otomatis menyelesaikan pesanan</small>
                    </div>

                    {{-- Alamat Pengiriman dengan Autocomplete --}}
                    <div class="col-12">
                        <label for="alamat_pengiriman" class="form-label fw-bold">
                            Alamat Pengiriman <span class="text-danger">*</span>
                        </label>
                        <div class="position-relative">
                            <input type="text" 
                                   class="form-control @error('alamat_pengiriman') is-invalid @enderror" 
                                   id="alamat_pengiriman" 
                                   name="alamat_pengiriman" 
                                   placeholder="Ketik alamat untuk mencari lokasi..."
                                   value="{{ old('alamat_pengiriman', $pengiriman->alamat_pengiriman) }}"
                                   autocomplete="off"
                                   required>
                            <div id="addressSuggestions" class="list-group position-absolute w-100" style="z-index: 1000; max-height: 300px; overflow-y: auto; display: none;"></div>
                        </div>
                        @error('alamat_pengiriman')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>Ketik alamat untuk melihat saran lokasi, atau klik pada peta di bawah
                        </small>
                    </div>

                    {{-- Peta Interaktif --}}
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            Lokasi Pengiriman <span class="text-danger">*</span>
                        </label>
                        <div class="card">
                            <div class="card-body">
                                <p class="text-muted mb-2">
                                    <i class="bi bi-geo-alt me-1"></i>Klik pada peta untuk mengubah lokasi pengiriman
                                </p>
                                <div id="map" style="height: 400px; border-radius: 8px;"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Wilayah Administratif (Read-only) --}}
                    <div class="col-md-4">
                        <label for="kecamatan" class="form-label fw-bold">Kecamatan</label>
                        <input type="text" 
                               class="form-control bg-light" 
                               id="kecamatan" 
                               name="kecamatan" 
                               value="{{ old('kecamatan', $pengiriman->kecamatan) }}"
                               readonly>
                    </div>

                    <div class="col-md-4">
                        <label for="kabupaten" class="form-label fw-bold">Kabupaten/Kota</label>
                        <input type="text" 
                               class="form-control bg-light" 
                               id="kabupaten" 
                               name="kabupaten" 
                               value="{{ old('kabupaten', $pengiriman->kabupaten) }}"
                               readonly>
                    </div>

                    <div class="col-md-4">
                        <label for="provinsi" class="form-label fw-bold">Provinsi</label>
                        <input type="text" 
                               class="form-control bg-light" 
                               id="provinsi" 
                               name="provinsi" 
                               value="{{ old('provinsi', $pengiriman->provinsi) }}"
                               readonly>
                    </div>

                    {{-- Hidden Fields untuk GPS --}}
                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $pengiriman->latitude) }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $pengiriman->longitude) }}">

                    {{-- Catatan --}}
                    <div class="col-12">
                        <label for="catatan" class="form-label fw-bold">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                  id="catatan" 
                                  name="catatan" 
                                  rows="3" 
                                  placeholder="Catatan tambahan untuk pengiriman (opsional)">{{ old('catatan', $pengiriman->catatan) }}</textarea>
                        @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save2 me-1"></i>Update Pengiriman
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Koordinat existing atau default
    const existingLat = {{ $pengiriman->latitude ?? -7.2575 }};
    const existingLng = {{ $pengiriman->longitude ?? 112.7521 }};
    
    // Inisialisasi peta
    const map = L.map('map').setView([existingLat, existingLng], 15);
    
    // Tambahkan tile layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    // Tambahkan marker existing jika ada
    let marker = null;
    @if($pengiriman->latitude && $pengiriman->longitude)
    marker = L.marker([existingLat, existingLng]).addTo(map);
    marker.bindPopup('<b>Lokasi Pengiriman Saat Ini</b><br>{{ addslashes($pengiriman->alamat_pengiriman) }}').openPopup();
    @endif
    
    let searchTimeout = null;
    
    // ========================================
    // A. ALAMAT → PETA (Autocomplete Search)
    // ========================================
    const addressInput = document.getElementById('alamat_pengiriman');
    const suggestionsDiv = document.getElementById('addressSuggestions');
    
    addressInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        if (query.length < 3) {
            suggestionsDiv.style.display = 'none';
            return;
        }
        
        // Debounce search (tunggu 500ms setelah user berhenti mengetik)
        searchTimeout = setTimeout(() => {
            searchAddress(query);
        }, 500);
    });
    
    function searchAddress(query) {
        // Nominatim Search API
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.length > 0) {
                    displaySuggestions(data);
                } else {
                    suggestionsDiv.innerHTML = '<div class="list-group-item text-muted">Tidak ada hasil ditemukan</div>';
                    suggestionsDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error searching address:', error);
                suggestionsDiv.style.display = 'none';
            });
    }
    
    function displaySuggestions(results) {
        suggestionsDiv.innerHTML = '';
        
        results.forEach(result => {
            const item = document.createElement('a');
            item.href = '#';
            item.className = 'list-group-item list-group-item-action';
            item.innerHTML = `
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">${result.display_name}</h6>
                </div>
                <small class="text-muted">${result.type || 'Lokasi'}</small>
            `;
            
            item.addEventListener('click', function(e) {
                e.preventDefault();
                selectAddress(result);
            });
            
            suggestionsDiv.appendChild(item);
        });
        
        suggestionsDiv.style.display = 'block';
    }
    
    function selectAddress(result) {
        const lat = parseFloat(result.lat);
        const lng = parseFloat(result.lon);
        
        // Set alamat
        addressInput.value = result.display_name;
        
        // Update peta
        updateMapLocation(lat, lng, result.display_name);
        
        // Set wilayah administratif
        if (result.address) {
            document.getElementById('kecamatan').value = result.address.suburb || result.address.village || '';
            document.getElementById('kabupaten').value = result.address.city || result.address.county || '';
            document.getElementById('provinsi').value = result.address.state || '';
        }
        
        // Set koordinat
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        // Hide suggestions
        suggestionsDiv.style.display = 'none';
    }
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!addressInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });
    
    // ========================================
    // B. PETA → ALAMAT (Reverse Geocoding)
    // ========================================
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        
        // Update peta
        updateMapLocation(lat, lng);
        
        // Reverse geocoding
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`)
            .then(response => response.json())
            .then(data => {
                if (data && data.address) {
                    const address = data.address;
                    
                    // Set alamat lengkap
                    const fullAddress = data.display_name || '';
                    addressInput.value = fullAddress;
                    
                    // Set wilayah administratif
                    document.getElementById('kecamatan').value = address.suburb || address.village || '';
                    document.getElementById('kabupaten').value = address.city || address.county || '';
                    document.getElementById('provinsi').value = address.state || '';
                    
                    // Set koordinat
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;
                    
                    // Update marker popup
                    if (marker) {
                        marker.bindPopup(`<b>Lokasi Pengiriman Baru</b><br>${fullAddress}`).openPopup();
                    }
                }
            })
            .catch(error => {
                console.error('Error fetching address:', error);
                alert('Gagal mendapatkan alamat. Silakan coba lagi.');
            });
    });
    
    function updateMapLocation(lat, lng, address = '') {
        // Hapus marker lama
        if (marker) {
            map.removeLayer(marker);
        }
        
        // Tambah marker baru
        marker = L.marker([lat, lng]).addTo(map);
        
        if (address) {
            marker.bindPopup(`<b>Lokasi Pengiriman</b><br>${address}`).openPopup();
        }
        
        // Zoom dan center ke lokasi
        map.setView([lat, lng], 15);
    }
    
    // ========================================
    // VALIDASI FORM
    // ========================================
    document.getElementById('formPengiriman').addEventListener('submit', function(e) {
        const lat = document.getElementById('latitude').value;
        const lng = document.getElementById('longitude').value;
        const alamat = document.getElementById('alamat_pengiriman').value.trim();
        
        if (!alamat) {
            e.preventDefault();
            alert('Alamat pengiriman wajib diisi!');
            addressInput.focus();
            return false;
        }
        
        if (!lat || !lng) {
            e.preventDefault();
            alert('Silakan pilih lokasi pengiriman pada peta atau dari saran alamat!');
            return false;
        }
    });
});
</script>

<style>
#addressSuggestions {
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    border-radius: 0.25rem;
}

#addressSuggestions .list-group-item {
    cursor: pointer;
    border-left: 3px solid transparent;
    transition: all 0.2s;
}

#addressSuggestions .list-group-item:hover {
    border-left-color: #ffc107;
    background-color: #f8f9fa;
}
</style>

@endsection

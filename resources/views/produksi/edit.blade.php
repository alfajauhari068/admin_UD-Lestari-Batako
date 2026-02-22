@extends('layouts.app')

@section('title', 'Edit Master Ongkos')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produksi.index') }}">Master Ongkos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produksi.show', $produksi->id_produksi) }}">Detail</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Edit Master Ongkos</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('produksi.update', $produksi->id_produksi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Produk Selection -->
                        <div class="mb-3">
                            <label for="id_produk" class="form-label">Produk <span class="text-danger">*</span></label>
                            <select name="id_produk" id="id_produk" 
                                    class="form-select @error('id_produk') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $produk)
                                <option value="{{ $produk->id_produk }}" 
                                        {{ $produksi->id_produk == $produk->id_produk ? 'selected' : '' }}>
                                    {{ $produk->nama_produk }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle"></i> 
                                Perubahan produk akan mempengaruhi referensi data
                            </div>
                        </div>

                        <!-- Upah per Unit -->
                        <div class="mb-3">
                            <label for="upah_per_unit" class="form-label">Upah per Unit (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="upah_per_unit" id="upah_per_unit"
                                       class="form-control @error('upah_per_unit') is-invalid @enderror"
                                       value="{{ $produksi->upah_per_unit }}"
                                       min="0" step="100" required>
                            </div>
                            @error('upah_per_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-warning">
                                <i class="bi bi-exclamation-triangle"></i> 
                                Perubahan akan berlaku untuk transaksi baru. Transaksi lama tetap menggunakan nilai lama (snapshot).
                            </div>
                        </div>

                        <!-- Satuan -->
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select name="satuan" id="satuan" 
                                    class="form-select @error('satuan') is-invalid @enderror"
                                    required>
                                <option value="unit" {{ $produksi->satuan == 'unit' ? 'selected' : '' }}>Unit</option>
                                <option value="pcs" {{ $produksi->satuan == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="biji" {{ $produksi->satuan == 'biji' ? 'selected' : '' }}>Biji</option>
                                <option value="batang" {{ $produksi->satuan == 'batang' ? 'selected' : '' }}>Batang</option>
                                <option value="zak" {{ $produksi->satuan == 'zak' ? 'selected' : '' }}>Zak</option>
                                <option value="m3" {{ $produksi->satuan == 'm3' ? 'selected' : '' }}>M³</option>
                            </select>
                            @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                      class="form-control @error('keterangan') is-invalid @enderror"
                                      placeholder="Catatan opsional...">{{ $produksi->keterangan }}</textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-check-lg"></i> Update
                            </button>
                            <a href="{{ route('produksi.show', $produksi->id_produksi) }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

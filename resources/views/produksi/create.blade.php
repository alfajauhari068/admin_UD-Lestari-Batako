@extends('layouts.app')

@section('title', 'Tambah Master Ongkos')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produksi.index') }}">Master Ongkos</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Tambah Master Ongkos Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('produksi.store') }}" method="POST">
                        @csrf

                        <!-- Produk Selection -->
                        <div class="mb-3">
                            <label for="id_produk" class="form-label">Produk <span class="text-danger">*</span></label>
                            <select name="id_produk" id="id_produk" 
                                    class="form-select @error('id_produk') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Produk</option>
                                @foreach($produks as $produk)
                                <option value="{{ $produk->id_produk }}" 
                                        {{ old('id_produk') == $produk->id_produk ? 'selected' : '' }}>
                                    {{ $produk->nama_produk }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Satu produk hanya boleh memiliki satu master ongkos</div>
                        </div>

                        <!-- Upah per Unit -->
                        <div class="mb-3">
                            <label for="upah_per_unit" class="form-label">Upah per Unit (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="upah_per_unit" id="upah_per_unit"
                                       class="form-control @error('upah_per_unit') is-invalid @enderror"
                                       value="{{ old('upah_per_unit') }}"
                                       min="0" step="100" required>
                            </div>
                            @error('upah_per_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Satuan -->
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select name="satuan" id="satuan" 
                                    class="form-select @error('satuan') is-invalid @enderror"
                                    required>
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="biji" {{ old('satuan') == 'biji' ? 'selected' : '' }}>Biji</option>
                                <option value="batang" {{ old('satuan') == 'batang' ? 'selected' : '' }}>Batang</option>
                                <option value="zak" {{ old('satuan') == 'zak' ? 'selected' : '' }}>Zak</option>
                                <option value="kubik" {{ old('satuan') == 'kubik' ? 'selected' : '' }}>Kubik</option>
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
                                      placeholder="Catatan opsional...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-check-lg"></i> Simpan
                            </button>
                            <a href="{{ route('produksi.index') }}" class="btn btn-outline-secondary">
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

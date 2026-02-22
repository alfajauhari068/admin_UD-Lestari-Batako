@extends('layouts.app')

@section('title', 'Tambah Produksi Karyawan')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('karyawan_produksi.index') }}">Karyawan Produksi</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Tambah Produksi Karyawan Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('karyawan_produksi.store') }}" method="POST">
                        @csrf

                        <!-- Karyawan Selection -->
                        <div class="mb-3">
                            <label for="karyawan_ids" class="form-label">Pilih Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_ids[]" id="karyawan_ids" 
                                    class="form-select @error('karyawan_ids') is-invalid @enderror"
                                    multiple 
                                    required
                                    size="5">
                                @forelse($karyawans as $karyawan)
                                <option value="{{ $karyawan->id_karyawan }}" 
                                        {{ in_array($karyawan->id_karyawan, old('karyawan_ids', [])) ? 'selected' : '' }}>
                                    {{ $karyawan->nama }}
                                </option>
                                @empty
                                <option value="">Tidak ada karyawan tersedia</option>
                                @endforelse
                            </select>
                            @error('karyawan_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Pilih satu atau lebih karyawan (tekan Ctrl/Cmd untuk memilih多个)</div>
                        </div>

                        <!-- Produksi Selection -->
                        <div class="mb-3">
                            <label for="id_produksi" class="form-label">Produksi (Produk) <span class="text-danger">*</span></label>
                            <select name="id_produksi" id="id_produksi" 
                                    class="form-select @error('id_produksi') is-invalid @enderror"
                                    required>
                                <option value="">Pilih Produksi</option>
                                @forelse($produksis as $produksi)
                                <option value="{{ $produksi->id_produksi }}" 
                                        {{ old('id_produksi') == $produksi->id_produksi ? 'selected' : '' }}>
                                    {{ $produksi->produk->nama_produk ?? 'Tanpa Produk' }} - {{ $produksi->upah_per_unit ? 'Rp ' . number_format($produksi->upah_per_unit) : 'Tanpa Upah' }}
                                </option>
                                @empty
                                <option value="">Tidak ada produksi tersedia</option>
                                @endforelse
                            </select>
                            @error('id_produksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Produksi -->
                        <div class="mb-3">
                            <label for="tanggal_produksi" class="form-label">Tanggal Produksi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_produksi" id="tanggal_produksi"
                                   class="form-control @error('tanggal_produksi') is-invalid @enderror"
                                   value="{{ old('tanggal_produksi') }}"
                                   required>
                            @error('tanggal_produksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jumlah Unit -->
                        <div class="mb-4">
                            <label for="jumlah_unit" class="form-label">Jumlah Unit <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_unit" id="jumlah_unit"
                                   class="form-control @error('jumlah_unit') is-invalid @enderror"
                                   value="{{ old('jumlah_unit') }}"
                                   min="1"
                                   required>
                            @error('jumlah_unit')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-check-lg"></i> Simpan
                            </button>
                            <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-outline-secondary">
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

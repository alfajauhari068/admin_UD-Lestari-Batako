@extends('layouts.app')

@section('content')
<div class="page-container p-fluid" >
        <div class="mt-4">
            @component('components.breadcrumb')
                    @slot('breadcrumbs', [
                        ['name' => 'Produksi', 'url' => route('produksi.index')],
                        ['name' => 'Tambah Produksi', 'url' => route('produksi.create_produksi')]
                    ])
                @endcomponent
            </div>
    <h2 class="mb-5 fw-bold text-primary">Tambah Produksi</h2>
    <form action="{{ route('produksi.store') }}" method="POST" class="card custom-card p-5">
    @csrf

    {{-- Pilih Produk (reference) --}}
    <div class="mb-4">
        <label for="id_produk" class="form-label">Produk *</label>
        <select class="form-control @error('id_produk') is-invalid @enderror" id="id_produk" name="id_produk" required>
            <option value="">Pilih Produk</option>
            @foreach($produks as $produk)
                <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
            @endforeach
        </select>
        @error('id_produk')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    {{-- Kriteria Gaji (deskripsi) --}}
    <div class="mb-4">
        <label for="kriteria_gaji" class="form-label">Kriteria Gaji *</label>
        <textarea class="form-control form-textarea @error('kriteria_gaji') is-invalid @enderror" id="kriteria_gaji" name="kriteria_gaji" required
              placeholder="Jelaskan kriteria gaji — deskripsi kapan karyawan berhak menerima gaji berdasarkan pencapaian produksi">{{ old('kriteria_gaji') }}</textarea>
        @error('kriteria_gaji')
            <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Gaji Per Unit --}}
    <div class="mb-4">
         <label for="gaji_per_unit" class="form-label">Gaji Per Unit *</label>
         <input type="number" class="form-control @error('gaji_per_unit') is-invalid @enderror"
             id="gaji_per_unit" name="gaji_per_unit" value="{{ old('gaji_per_unit') }}" required
             placeholder="Masukkan gaji per unit">
        @error('gaji_per_unit')
            <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Jumlah Per Unit (patokan kuantitas) --}}
    <div class="mb-4">
         <label for="jumlah_per_unit" class="form-label">Jumlah Per Unit *</label>
         <input type="number" class="form-control @error('jumlah_per_unit') is-invalid @enderror"
             id="jumlah_per_unit" name="jumlah_per_unit" value="{{ old('jumlah_per_unit', 100) }}" required
             placeholder="Masukkan patokan jumlah per unit (contoh: 100)">
        @error('jumlah_per_unit')
            <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
        @enderror
    </div>

    {{-- Tombol Aksi --}}
    <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
        <a href="{{ route('produksi.index') }}" class="btn btn-secondary btn-secondary-custom">
            <i class="bi bi-arrow-left-circle me-2"></i>Batal
        </a>
        <button type="submit" class="btn btn-primary btn-primary-custom">
            <i class="bi bi-save me-2"></i>Simpan
        </button>
    </div>
</form>

</div>
@endsection
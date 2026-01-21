@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 100vh;">
            <div class=" ">
            @component('components.breadcrumb')
                    @slot('breadcrumbs', [
                        ['name' => 'Produksi', 'url' => route('produksi.index')],
                        ['name' => 'Edit Produksi', 'url' => route('produksi.edit', $produksi->id_produksi)]
                    ])
                @endcomponent
            </div>
    <h2 class="mb- fw-bold text-primary">Edit Produksi</h2>
    <form action="{{ route('produksi.update', $produksi->id_produksi) }}" method="POST" class="card shadow-lg p-5 border-0 rounded-4" style="background: #FFFFFF;">
    @csrf
    @method('PUT')

    {{-- Pilih Produk (reference) --}}
    <div class="mb-4">
        <label for="id_produk" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Produk *</label>
        <select class="form-control" id="id_produk" name="id_produk" required
                style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
            <option value="">Pilih Produk</option>
            @foreach($produks as $produk)
                <option value="{{ $produk->id_produk }}" {{ old('id_produk', $produksi->id_produk) == $produk->id_produk ? 'selected' : '' }}>
                    {{ $produk->nama_produk }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Kriteria Gaji (deskripsi) --}}
    <div class="mb-4">
        <label for="kriteria_gaji" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Kriteria Gaji *</label>
        <textarea class="form-control" id="kriteria_gaji" name="kriteria_gaji" required
                  placeholder="Jelaskan kriteria gaji — deskripsi kapan karyawan berhak menerima gaji berdasarkan pencapaian produksi"
                  style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem; height:120px;">{{ old('kriteria_gaji', $produksi->kriteria_gaji) }}</textarea>
    </div>

    {{-- Gaji Per Unit --}}
    <div class="mb-4">
        <label for="gaji_per_unit" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Gaji Per Unit *</label>
        <input type="number" class="form-control" id="gaji_per_unit" name="gaji_per_unit" 
               value="{{ old('gaji_per_unit', $produksi->gaji_per_unit) }}" required
               placeholder="Masukkan gaji per unit"
               style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
    </div>

    {{-- Jumlah Per Unit (patokan kuantitas) --}}
    <div class="mb-4">
        <label for="jumlah_per_unit" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Jumlah Per Unit *</label>
        <input type="number" class="form-control" id="jumlah_per_unit" name="jumlah_per_unit" 
               value="{{ old('jumlah_per_unit', $produksi->jumlah_per_unit ?? 100) }}" required
               placeholder="Masukkan patokan jumlah per unit (contoh: 100)"
               style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
    </div>

    {{-- Tombol Aksi --}}
    <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
        <a href="{{ route('produksi.index') }}" class="btn btn-secondary" style="background-color: #64748B; color: #FFFFFF; border: none; border-radius: 8px; padding: 0.625rem 1.5rem;">
            <i class="bi bi-arrow-left-circle me-2"></i>Batal
        </a>
        <button type="submit" class="btn btn-primary" style="background-color: #1E293B; color: #FFFFFF; border: none; border-radius: 8px; padding: 0.625rem 1.5rem;">
            <i class="bi bi-save me-2"></i>Simpan
        </button>
    </div>
</form>

</div>
@endsection
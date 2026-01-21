@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5" style="min-height: 100vh;">
    <div class="mt-4">
        @component('components.breadcrumb')
            @slot('breadcrumbs', [
                ['name' => 'Tim Produksi', 'url' => route('karyawan_produksi.index')],
                ['name' => 'Tambah Tim Produksi', 'url' => route('karyawan_produksi.create')]
            ])
        @endcomponent
    </div>
    
    <h2 class="mb-5 fw-bold text-primary">Tambah Tim Produksi</h2>
    <form action="{{ route('karyawan_produksi.store') }}" method="POST" class="card shadow-lg p-5 border-0 rounded-4" style="background: #FFFFFF; max-width: 1060px;">
        @csrf
        
        {{-- Pilih Nama Produksi --}}
        <div class="mb-4">
            <label for="id_produksi" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Nama Produksi *</label>
            <select class="form-control @error('id_produksi') is-invalid @enderror" id="id_produksi" name="id_produksi" required
                    style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
                <option value="">Pilih Produksi</option>
                @foreach($produksis as $produksi)
                    <option value="{{ $produksi->id_produksi }}">{{ $produksi->produk->nama_produk ?? 'N/A' }}</option>
                @endforeach
            </select>
            @error('id_produksi')
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Tanggal Produksi --}}
        <div class="mb-4">
            <label for="tanggal_produksi" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Tanggal Produksi *</label>
            <input type="date" class="form-control @error('tanggal_produksi') is-invalid @enderror" id="tanggal_produksi" name="tanggal_produksi" required
                   style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
            @error('tanggal_produksi')
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Jumlah Unit --}}
        <div class="mb-4">
            <label for="jumlah_unit" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Jumlah Unit *</label>
            <input type="number" class="form-control @error('jumlah_unit') is-invalid @enderror" id="jumlah_unit" name="jumlah_unit" required
                   style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
            <small style="color: #64748B; margin-top: 0.5rem; display: block;">Masukkan total jumlah unit yang diproduksi oleh tim pada tanggal ini.</small>
            @error('jumlah_unit')
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Pilih Karyawan (Tim Produksi) --}}
        <div class="mb-4">
            <label for="karyawan_ids" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Pilih Tim Produksi *</label>
            <select multiple class="form-control @error('karyawan_ids') is-invalid @enderror" id="karyawan_ids" name="karyawan_ids[]" required
                    style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama }}</option>
                @endforeach
            </select>
            <small style="color: #64748B; margin-top: 0.5rem; display: block;">Pilih karyawan yang tergabung dalam tim produksi. Tekan <kbd>Ctrl</kbd> (atau <kbd>Cmd</kbd> di Mac) untuk memilih lebih dari satu karyawan.</small>
            @error('karyawan_ids')
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Simpan dan Batal --}}
        <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
            <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-secondary" style="background-color: #64748B; color: #FFFFFF; border: none; border-radius: 8px; padding: 0.625rem 1.5rem;">
                <i class="bi bi-arrow-left-circle me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary" style="background-color: #1E293B; color: #FFFFFF; border: none; border-radius: 8px; padding: 0.625rem 1.5rem;">
                <i class="bi bi-save me-2"></i>Simpan
            </button>
        </div>
    </form>
</div>
@endsection
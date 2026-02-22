@extends('layouts.app')

@section('content')
<div class="page-container p-fluid">
    <div class="mt-4">
                @component('components.breadcrumb')
            @slot('breadcrumbs', [
                ['name' => 'Produksi Karyawan Tim', 'url' => route('produksi_karyawan_tim.index')],
                ['name' => 'Tambah Data', 'url' => route('produksi_karyawan_tim.index')]
            ])
        @endcomponent
    </div>
    
    <h2 class="mb-5 fw-bold text-primary">Tambah Data Produksi Karyawan Tim</h2>
    <form action="{{ route('produksi_karyawan_tim.store') }}" method="POST" class="card custom-card p-5 mx-auto max-w-900">
        @csrf
        
        {{-- Pilih Nama Produksi --}}
        <div class="mb-4">
                <label for="id_produksi" class="form-label">Nama Produksi *</label>
                <select class="form-control @error('id_produksi') is-invalid @enderror" id="id_produksi" name="id_produksi" required>
                <option value="">Pilih Produksi</option>
                @foreach($produksis as $produksi)
                    <option value="{{ $produksi->id_produksi }}">{{ $produksi->produk->nama_produk ?? 'N/A' }}</option>
                @endforeach
            </select>
            @error('id_produksi')
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Pilih Karyawan --}}
        <div class="mb-4">
                <label for="id_karyawan" class="form-label">Nama Karyawan (Pilih beberapa) *</label>
                <select class="form-control form-multiselect @error('id_karyawan') is-invalid @enderror" id="id_karyawan" name="id_karyawan[]" multiple required>
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama }}</option>
                @endforeach
            </select>
            <small class="text-muted">Tekan Ctrl (Windows) atau Cmd (Mac) untuk memilih beberapa karyawan sekaligus.</small>
            @error('id_karyawan')
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
            @if($errors->has('id_karyawan.*'))
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">Beberapa pilihan karyawan tidak valid.</div>
            @endif
        </div>

        {{-- Input Tanggal Produksi --}}
        <div class="mb-4">
                 <label for="tanggal_produksi" class="form-label">Tanggal Produksi *</label>
                 <input type="date" class="form-control @error('tanggal_produksi') is-invalid @enderror" id="tanggal_produksi" name="tanggal_produksi" required>
            @error('tanggal_produksi')
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Input Jumlah Unit --}}
        <div class="mb-4">
                 <label for="jumlah_unit" class="form-label">Jumlah Unit *</label>
                 <input type="number" class="form-control @error('jumlah_unit') is-invalid @enderror" id="jumlah_unit" name="jumlah_unit" required min="1">
                 <small class="form-note">Masukkan jumlah unit yang dikontribusikan oleh karyawan ini untuk produksi tim pada tanggal tersebut.</small>
            @error('jumlah_unit')
                <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
            @enderror
        </div>

        {{-- Info Penting --}}
        <div class="alert alert-info mt-4 mb-4">
            <strong><i class="bi bi-info-circle me-2"></i>Catatan Penting:</strong><br>
            <small>
                Gaji akan dihitung otomatis berdasarkan total unit tim, bukan individual.
                Satu tim produksi dalam 1 hari = 1 perhitungan gaji untuk semua anggota.
            </small>
        </div>

        {{-- Tombol Simpan dan Batal --}}
        <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
            <a href="{{ route('produksi_karyawan_tim.index') }}" class="btn btn-secondary btn-secondary-custom">
                <i class="bi bi-arrow-left-circle me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-primary btn-primary-custom">
                <i class="bi bi-save me-2"></i>Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container py-5 " style="min-height: 100vh;">
    <div class="">
        @component('components.breadcrumb')
            @slot('breadcrumbs', [
                ['name' => 'Karyawan', 'url' => route('karyawans.index')],
                ['name' => 'Tambah Karyawan', 'url' => route('karyawans.create_kariawan')]
            ])
        @endcomponent
    </div>

    <h4 class="fw-bold text-primary mb-">Tambah Karyawan</h4>

    <div class="card shadow-lg p-5 border-0 rounded-4" style="background: #FFFFFF; max-width: 1060px;">
        <div class="card-body p-0">
            <h5 class="fw-bold text-primary ">Informasi Karyawan</h5>
            <form action="{{ route('karyawans.store') }}" method="POST">
                @csrf

                {{-- Nama --}}
                <div class="">
                    <label for="nama" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Nama *</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" required
                           placeholder="Masukkan nama karyawan"
                           style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
                    @error('nama')
                        <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Posisi / Jabatan --}}
                <div class="">
                    <label for="jabatan" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Posisi *</label>
                    <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan" name="jabatan" required
                           placeholder="Masukkan posisi/jabatan"
                           style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
                    @error('jabatan')
                        <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor HP --}}
                <div class="mb-4">
                    <label for="no_hp" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">No HP *</label>
                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" required
                           placeholder="Masukkan nomor HP"
                           style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;">
                    @error('no_hp')
                        <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="">
                    <label for="alamat" class="form-label fw-semibold" style="color: #1E293B; font-size: 0.95rem;">Alamat *</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4" required
                              placeholder="Masukkan alamat karyawan"
                              style="border: 1px solid #E2E8F0; border-radius: 8px; padding: 0.75rem;"></textarea>
                    @error('alamat')
                        <div class="invalid-feedback d-block" style="color: #DC2626; margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                    <a href="{{ route('karyawans.index') }}" class="btn btn-secondary" style="background-color: #64748B; color: #FFFFFF; border: none; border-radius: 8px; padding: 0.625rem 1.5rem;">
                        <i class="bi bi-arrow-left-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary" style="background-color: #1E293B; color: #FFFFFF; border: none; border-radius: 8px; padding: 0.625rem 1.5rem;">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
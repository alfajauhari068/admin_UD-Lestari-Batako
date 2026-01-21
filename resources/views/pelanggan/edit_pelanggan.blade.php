{{-- filepath: d:\KULIAH\Semester4\Interaksi Manusia dan Komputer\tugas-3\ud_lestari-batako\resources\views\pelanggan\edit_pelanggan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="page-container p-fluid">
        <h2 class="mb- mt- pt- fw-bold text-primary">Edit Pelanggan</h2>

        <div class="card custom-card p-5 max-w-900 mx-auto">
            <div class="card-body p-0">
                <h5 class="fw-bold text-primary mb-5">Edit Data Pelanggan</h5>

                <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label for="nama" class="form-label">Nama *</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" 
                               value="{{ old('nama', $pelanggan->nama) }}" required
                               placeholder="Masukkan nama pelanggan">
                        @error('nama')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                               value="{{ old('email', $pelanggan->email) }}"
                               placeholder="Masukkan email pelanggan">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="mb-4">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" 
                               value="{{ old('no_hp', $pelanggan->no_hp) }}"
                               placeholder="Masukkan nomor HP pelanggan">
                        @error('no_hp')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-4">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control form-textarea @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4"
                                  placeholder="Masukkan alamat pelanggan">{{ old('alamat', $pelanggan->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary btn-secondary-custom">
                            <i class="bi bi-arrow-left-circle me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-primary-custom">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
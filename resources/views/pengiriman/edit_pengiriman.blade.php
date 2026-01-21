{{-- filepath: d:\KULIAH\Semester4\Interaksi Manusia dan Komputer\tugas-3\ud_lestari-batako\resources\views\pengiriman\edit_pengiriman.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="page-container">
    <h2 class="mb-5 fw-bold text-primary text-center">Edit Pengiriman</h2>

    <div class="card custom-card mx-auto max-w-600">
        <div class="card-body p-0">
            <form action="{{ route('pengiriman.update', $pengiriman->id_pengiriman) }}" method="POST">
                @csrf
                @method('PUT')

                <h4 class="fw-bold mb-5 text-primary">Edit Pengiriman</h4>

                {{-- Informasi Pesanan --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">ID Pesanan</label>
                    <input type="text" class="form-control" value="{{ $pengiriman->pesanan->id_pesanan }}" readonly>
                </div>

                {{-- Informasi Pelanggan --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Nama Pelanggan</label>
                    <input type="text" class="form-control" value="{{ $pengiriman->pesanan->pelanggan->nama }}" readonly>
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="mb-4">
                    <label for="alamat_pengiriman" class="form-label fw-semibold">Alamat Pengiriman *</label>
                    <textarea class="form-control form-textarea" id="alamat_pengiriman" name="alamat_pengiriman" rows="4" required>{{ old('alamat_pengiriman', $pengiriman->alamat_pengiriman) }}</textarea>
                </div>

                {{-- Tanggal Pengiriman --}}
                <div class="mb-4">
                    <label for="tanggal_pengiriman" class="form-label fw-semibold">Tanggal Pengiriman</label>
                    <input type="date" class="form-control" id="tanggal_pengiriman" name="tanggal_pengiriman" value="{{ old('tanggal_pengiriman', $pengiriman->tanggal_pengiriman ? $pengiriman->tanggal_pengiriman->format('Y-m-d') : '') }}">
                </div>

                {{-- Jasa Kurir --}}
                <div class="mb-4">
                    <label for="jasa_kurir" class="form-label fw-semibold">Jasa Kurir</label>
                    <input type="text" class="form-control" id="jasa_kurir" name="jasa_kurir" placeholder="Contoh: JNE, TIKI, SiCepat, Lestari Express" value="{{ old('jasa_kurir', $pengiriman->jasa_kurir) }}">
                </div>

                {{-- Nomor Resi --}}
                <div class="mb-4">
                    <label for="no_resi" class="form-label fw-semibold">No Resi</label>
                    <input type="text" class="form-control" id="no_resi" name="no_resi" placeholder="Opsional: Jika tersedia" value="{{ old('no_resi', $pengiriman->no_resi) }}">
                </div>

                <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                    <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary-custom">
                        <i class="bi bi-arrow-left-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
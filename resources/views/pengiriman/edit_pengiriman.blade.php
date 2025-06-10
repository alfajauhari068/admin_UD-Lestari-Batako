{{-- filepath: d:\KULIAH\Semester4\Interaksi Manusia dan Komputer\tugas-3\ud_lestari-batako\resources\views\pengiriman\edit_pengiriman.blade.php --}}
@extends('layouts.navbar')

@section('content')
<div class="container py-4 p-5">
    <h2 class="mb-4 fw-bold text-primary pt-5 text-center">Edit Pengiriman</h2>

    <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px; border-radius: 15px;">
        <div class="card-body p-4">
            <form action="{{ route('pengiriman.update', $pengiriman->id_pengiriman) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Informasi Pesanan --}}
                <div class="mb-3">
                    <label for="id_pesanan" class="form-label fw-semibold">Pesanan</label>
                    <input type="text" class="form-control bg-light" id="id_pesanan" value="{{ $pengiriman->pesanan->id_pesanan }}" readonly>
                </div>

                {{-- Informasi Pelanggan --}}
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label fw-semibold">Nama Pelanggan</label>
                    <input type="text" class="form-control bg-light" id="nama_pelanggan" value="{{ $pengiriman->pesanan->pelanggan->nama }}" readonly>
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="mb-3">
                    <label for="alamat_pengiriman" class="form-label fw-semibold">Alamat Pengiriman</label>
                    <textarea class="form-control" id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required>{{ old('alamat_pengiriman', $pengiriman->alamat_pengiriman) }}</textarea>
                </div>

                {{-- Tanggal Pengiriman --}}
                <div class="mb-3">
                    <label for="tanggal_pengiriman" class="form-label fw-semibold">Tanggal Pengiriman</label>
                    <input type="date" class="form-control" id="tanggal_pengiriman" name="tanggal_pengiriman" value="{{ old('tanggal_pengiriman', $pengiriman->tanggal_pengiriman ? $pengiriman->tanggal_pengiriman->format('Y-m-d') : '') }}">
                </div>

                {{-- Jasa Kurir --}}
                <div class="mb-3">
                    <label for="jasa_kurir" class="form-label fw-semibold">Jasa Kurir</label>
                    <input type="text" class="form-control" id="jasa_kurir" name="jasa_kurir" value="{{ old('jasa_kurir', $pengiriman->jasa_kurir) }}">
                </div>

                {{-- Nomor Resi --}}
                <div class="mb-3">
                    <label for="no_resi" class="form-label fw-semibold">No Resi</label>
                    <input type="text" class="form-control" id="no_resi" name="no_resi" value="{{ old('no_resi', $pengiriman->no_resi) }}">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                    <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
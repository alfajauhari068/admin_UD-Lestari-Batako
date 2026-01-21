{{-- filepath: d:\KULIAH\Semester4\Pemrograman FrameWork\ud_lestari-batako\resources\views\pengiriman\create_pengiriman.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="page-container">
<div class="">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Pengiriman', 'url' => route('pengiriman.index')],
                    ['name' => 'Tambah Pengiriman', 'url' => route('pelanggan.create')]
                ])
            @endcomponent
            </div>
    <h4 class="mb- fw-bold text-primary">Atur Pengiriman</h4>
    <div class="card custom-card max-w-900">
        <div class="card-body p-0">
            <form action="{{ route('pengiriman.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">
                <input type="hidden" name="id_pelanggan" value="{{ $pesanan->pelanggan->id_pelanggan }}">

                <div class="mb-4">
                    <label for="alamat_pengiriman" class="form-label fw-semibold">Alamat Pengiriman *</label>
                    <textarea class="form-control form-textarea" id="alamat_pengiriman" name="alamat_pengiriman" rows="4" required>{{ $pesanan->pelanggan->alamat }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="tanggal_pengiriman" class="form-label fw-semibold">Tanggal Pengiriman *</label>
                    <input type="date" class="form-control" id="tanggal_pengiriman" name="tanggal_pengiriman" required>
                </div>

                <div class="mb-4">
                    <label for="jasa_kurir" class="form-label fw-semibold">Jasa Kurir *</label>
                    <input type="text" class="form-control" id="jasa_kurir" name="jasa_kurir" required placeholder="Masukkan nama jasa kurir">
                </div>

                <div class="mb-4">
                    <label for="no_resi" class="form-label fw-semibold">No Resi</label>
                    <input type="text" class="form-control" id="no_resi" name="no_resi" placeholder="Masukkan nomor resi">
                </div>

                <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary-custom">
                        <i class="bi bi-arrow-left-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan Pengiriman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
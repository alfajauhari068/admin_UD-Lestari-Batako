{{-- filepath: d:\KULIAH\Semester4\Pemrograman FrameWork\ud_lestari-batako\resources\views\pengiriman\create_pengiriman.blade.php --}}

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> <!-- Jika ada file CSS kustom -->
</head>
@extends('layouts.navbar')

@section('content')
<div class="container py-4 p-5">
<div class="mt-5 pt-5">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Pengiriman', 'url' => route('pengiriman.index')],
                    ['name' => 'Tambah Pengiriman', 'url' => route('pelanggan.create')]
                ])
            @endcomponent
            </div>
    <h4 class="mb-4  fw-bold text-primary">Atur Pengiriman</h4>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pengiriman.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan }}">
                <input type="hidden" name="id_pelanggan" value="{{ $pesanan->pelanggan->id_pelanggan }}">

                <div class="mb-3">
                    <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
                    <textarea class="form-control" id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required>{{ $pesanan->pelanggan->alamat }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="tanggal_pengiriman" class="form-label">Tanggal Pengiriman</label>
                    <input type="date" class="form-control" id="tanggal_pengiriman" name="tanggal_pengiriman" required>
                </div>

                <div class="mb-3">
                    <label for="jasa_kurir" class="form-label">Jasa Kurir</label>
                    <input type="text" class="form-control" id="jasa_kurir" name="jasa_kurir" required>
                </div>

                <div class="mb-3">
                    <label for="no_resi" class="form-label">No Resi</label>
                    <input type="text" class="form-control" id="no_resi" name="no_resi">
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pengiriman</button>
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
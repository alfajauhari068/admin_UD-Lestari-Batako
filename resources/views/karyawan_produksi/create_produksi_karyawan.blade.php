@extends('layouts.navbar')

@section('content')
<div class="container py-5 mt-5">
<div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produksi Karyawan', 'url' => route('karyawan_produksi.index')],
                    ['name' => 'Tambah Produksi Karyawan', 'url' => route('karyawan_produksi.create')]
                ])
            @endcomponent
    </div>
    <h2 class="mb-4">Tambah Produksi Karyawan</h2>
    <form action="{{ route('karyawan_produksi.store') }}" method="POST">
        @csrf
        <!-- Pilih Nama Produksi -->
        <div class="mb-3">
        
            <label for="id_produksi" class="form-label">Nama Produksi</label>
            <select class="form-control" id="id_produksi" name="id_produksi" required>
                <option value="">Pilih Produksi</option>
                @foreach($produksis as $produksi)
                    <option value="{{ $produksi->id_produksi }}">{{ $produksi->nama_produksi }}</option>
                @endforeach
            </select>
        </div>

        <!-- Input Tanggal Produksi -->
        <div class="mb-3">
            <label for="tanggal_produksi" class="form-label">Tanggal Produksi</label>
            <input type="date" class="form-control" id="tanggal_produksi" name="tanggal_produksi" required>
        </div>

        <!-- Input Jumlah Unit -->
        <div class="mb-3">
            <label for="jumlah_unit" class="form-label">Jumlah Unit</label>
            <input type="number" class="form-control" id="jumlah_unit" name="jumlah_unit" required>
            <small class="text-muted">Masukkan total jumlah unit yang diproduksi oleh tim pada tanggal ini.</small>
        </div>

        <!-- Pilih Karyawan (Tim Produksi) -->
        <div class="mb-3">
            <label for="karyawan_ids" class="form-label">Pilih Tim Produksi</label>
            <select multiple class="form-control" id="karyawan_ids" name="karyawan_ids[]" required>
                @foreach($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama }}</option>
                @endforeach
            </select>
            <small class="text-muted">Pilih karyawan yang tergabung dalam tim produksi. Tekan <kbd>Ctrl</kbd> (atau <kbd>Cmd</kbd> di Mac) untuk memilih lebih dari satu karyawan.</small>
        </div>

        <!-- Tombol Simpan dan Batal -->
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('karyawan_produksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
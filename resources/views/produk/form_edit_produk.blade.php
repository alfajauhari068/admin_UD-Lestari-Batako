<!-- filepath: d:\KULIAH\Semester4\Interaksi Manusia dan Komputer\tugas-3\ud_lestari-batako\resources\views\form_edit_produk.blade.php -->
@extends('layouts.navbar')

@section('content')
<div class="container py-4">
    <h2>Edit Produk</h2>
    <form action="{{ route('produk.update', $produk->id_produk ?? $produk->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
        </div>
        <div class="mb-3">
            <label for="harga_satuan" class="form-label">Harga Satuan</label>
            <input type="number" step="0.01" class="form-control" id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan', $produk->harga_satuan) }}" required>
        </div>
        <div class="mb-3">
            <label for="stok_tersedia" class="form-label">Stok Tersedia</label>
            <input type="number" class="form-control" id="stok_tersedia" name="stok_tersedia" value="{{ old('stok_tersedia', $produk->stok_tersedia) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
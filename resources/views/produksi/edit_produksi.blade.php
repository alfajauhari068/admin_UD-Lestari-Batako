@extends('layouts.navbar')

@section('content')
<div class="container py-5">
            <div class="mt-5 pt-5">
            @component('components.breadcrumb')
                    @slot('breadcrumbs', [
                        ['name' => 'Produksi', 'url' => route('produksi.index')],
                        ['name' => 'Edit Produksi', 'url' => route('produksi.edit', $produksi->id_produksi)]
                    ])
                @endcomponent
            </div>
    <h2 class="mb-4">Edit Produksi</h2>
    <form action="{{ route('produksi.update', $produksi->id_produksi) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama_produksi" class="form-label">Nama Produksi</label>
            <input type="text" class="form-control" id="nama_produksi" name="nama_produksi" value="{{ $produksi->nama_produksi }}" required>
        </div>
        <div class="mb-3">
            <label for="kriteria_gaji" class="form-label">Kriteria Gaji</label>
            <input type="text" class="form-control" id="kriteria_gaji" name="kriteria_gaji" value="{{ $produksi->kriteria_gaji }}" required>
        </div>
        <div class="mb-3">
            <label for="gaji_per_unit" class="form-label">Gaji Per Unit</label>
            <input type="number" class="form-control" id="gaji_per_unit" name="gaji_per_unit" value="{{ $produksi->gaji_per_unit }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('produksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
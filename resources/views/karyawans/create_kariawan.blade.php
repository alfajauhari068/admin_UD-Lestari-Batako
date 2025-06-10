@extends('layouts.navbar')

@section('content')
<div class="container py-5 mt-5">
        <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Karyawan', 'url' => route('karyawans.index')],
                    ['name' => 'Tambah Karyawan', 'url' => route('karyawans.create_kariawan')]
                ])
            @endcomponent
            <div>
            <div class="col-auto">
                <h4 class="fw-bold text-primary">Tambah Karyawan</h4>
            </div>
    <form action="{{ route('karyawans.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Posisi</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" required>
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('karyawans.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
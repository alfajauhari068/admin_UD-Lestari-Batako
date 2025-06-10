<!-- filepath: resources/views/karyawans/Edit_kariawan.blade.php -->
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
            <div class="col-auto">
                <h4 class="fw-bold text-primary">Edit Karyawan</h4>
            </div>
    <form action="{{ route('karyawans.update', $karyawan->id_karyawan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $karyawan->nama }}" required>
        </div>
        <div class="mb-3">
            <label for="jabatan" class="form-label">Jabatan</label>
            <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $karyawan->jabatan }}" required>
        </div>
        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $karyawan->no_hp }}" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $karyawan->alamat }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('karyawans.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
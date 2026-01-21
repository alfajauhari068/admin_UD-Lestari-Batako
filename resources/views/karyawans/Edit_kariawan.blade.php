<!-- filepath: resources/views/karyawans/Edit_kariawan.blade.php -->
@extends('layouts.app')

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
    <div class="col-12 grid-margin">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Edit Data Karyawan</h4>
      <form action="{{ route('karyawans.update', $karyawan->id_karyawan) }}" method="POST" class="form-sample">
        @csrf
        @method('PUT')

        <p class="card-description">Informasi Karyawan</p>

        <div class="row">
          <!-- Nama -->
          <div class="col-md-6">
            <div class="form-group row">
              <label for="nama" class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $karyawan->nama }}" required>
              </div>
            </div>
          </div>

          <!-- Jabatan -->
          <div class="col-md-6">
            <div class="form-group row">
              <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $karyawan->jabatan }}" required>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- No HP -->
          <div class="col-md-6">
            <div class="form-group row">
              <label for="no_hp" class="col-sm-3 col-form-label">No HP</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ $karyawan->no_hp }}" required>
              </div>
            </div>
          </div>

          <!-- Alamat -->
          <div class="col-md-6">
            <div class="form-group row">
              <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-9">
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $karyawan->alamat }}</textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-4">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <a href="{{ route('karyawans.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>

</div>
@endsection
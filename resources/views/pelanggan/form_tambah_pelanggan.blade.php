<!-- filepath: d:\KULIAH\Semester4\Interaksi Manusia dan Komputer\tugas-3\ud_lestari-batako\resources\views\pelanggan\form_tambah_pelanggan.blade.php -->
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"> <!-- Jika ada file CSS kustom -->
</head>
@extends('layouts.navbar')
<body class="bg-white">

<div class="container py-4 p-5">
<div class=" pt-5">
    @section('content')
<div class="mt-5">
         @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Pesanan', 'url' => route('pesanan.index')],
                    ['name' => 'Tambah Pesanan', 'url' => route('pesanan.create')]
                ])
            @endcomponent</div>
    <h2 class="mb-4 mt-2 fw-bold text-primary">Tambah Pelanggan</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
</body>
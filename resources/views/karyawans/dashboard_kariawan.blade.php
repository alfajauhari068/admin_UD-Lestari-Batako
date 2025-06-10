@extends('layouts.navbar')
@extends('layouts.sidebar')

@section('content')
<div class="d-flex">
    <!-- Main Content -->
    <div class="container-fluid py-5 p-5 mt-5" style="margin-left: 250px; padding-top: 80px; background:rgba(252, 252, 252, 0.61); min-height: 100vh;">
    <div class="mt-4">
        @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Karyawan', 'url' => route('karyawans.index')]
                ])
            @endcomponent
            </div>

        <div class="row justify-content-between align-items-center mb-3">
            <div class="col-auto">
                <h4 class="fw-bold text-primary">Daftar Karyawan</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('karyawans.create_kariawan') }}" class="btn btn-primary rounded-circle mb-3" style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center;">
                    <i class="bi bi-plus-circle fs-4"></i>
                </a>
            </div>
        </div>


        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill text-success me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger mt-3 shadow-sm">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="bi bi-exclamation-circle-fill text-danger me-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Nama</center></th>
                                <th><center>Posisi</center></th>
                                <th><center>No HP</center></th>
                                <th><center>Alamat</center></th>
                                <th><center>Aksi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawans as $karyawan)
                            <tr>
                                <td><center>{{ $loop->iteration }}</center></td>
                                <td><center>{{ $karyawan->nama }}</center></td>
                                <td><center>{{ $karyawan->jabatan }}</center></td>
                                <td><center>{{ $karyawan->no_hp }}</center></td>
                                <td><center>{{ $karyawan->alamat }}</center></td>
                                <td><center>
                                    <div class="d-flex gap-2 justify-content-center">
                                        

                                        <!-- Tombol Edit -->
                                        <button class="btn btn-primary btn-sm d-flex align-items-center gap-1" 
                                                data-mdb-ripple-init type="button" 
                                                onclick="window.location.href='{{ route('karyawans.edit', $karyawan->id_karyawan) }}'" 
                                                data-bs-toggle="tooltip" title="Edit Karyawan">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button class="btn btn-danger btn-sm d-flex align-items-center gap-1 rounded-circle" 
                                                    data-mdb-ripple-init type="submit" 
                                                    onclick="return confirm('Yakin ingin menghapus karyawan ini?')" 
                                                    data-bs-toggle="tooltip" title="Hapus Karyawan" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;">
                                                <i class="bi bi-trash"></i>
                                        <form action="{{ route('karyawans.destroy', $karyawan->id_karyawan) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            
                                            </button>
                                        </form>
                                    </div>
                                </center></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data karyawan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end small text-muted">
                UD Lestari Batako &copy; {{ date('Y') }}
            </div>
        </div>
    </div>
</div>
@endsection

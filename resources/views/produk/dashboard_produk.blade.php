<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <title>Data Mahasiswa</title>
</head>
<body>
<script src="/js/bootstrap.bundle.min.js"></script>
@extends('layouts.navbar')

@section('content')
<div class="container py-4">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold text-primary">Daftar Produk</h4>
                <a href="{{ route('produk.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </a>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Dibuat</th>
                                    <th>Diupdate</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($KurirData as $produk)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $produk->nama_produk }}</td>
                                    <td>Rp{{ number_format($produk->harga_satuan, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $produk->stok_tersedia > 0 ? 'success' : 'danger' }}">
                                            {{ $produk->stok_tersedia }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-secondary" title="{{ $produk->created_at }}">
                                            {{ $produk->created_at ? $produk->created_at->format('d M Y H:i') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-secondary" title="{{ $produk->updated_at }}">
                                            {{ $produk->updated_at ? $produk->updated_at->format('d M Y H:i') : '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Tombol Aksi Modern -->
                                        <div class="d-flex gap-2">
                                            <!-- Tombol Detail -->
                                            <a href="{{ route('produk.show', $produk->id) }}" 
                                               class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center gap-1" 
                                               data-bs-toggle="tooltip" title="Lihat Detail Produk">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('produk.edit', $produk->id) }}" 
                                               class="btn btn-outline-warning btn-sm rounded-pill d-flex align-items-center gap-1" 
                                               data-bs-toggle="tooltip" title="Edit Produk">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('produk.delete', $produk->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-outline-danger btn-sm rounded-pill d-flex align-items-center gap-1" 
                                                        onclick="return confirm('Yakin hapus produk ini?')" 
                                                        data-bs-toggle="tooltip" title="Hapus Produk">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada produk.</td>
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
</div>
@endsection
</body>
</html>
@extends('layouts.app')

@section('content')
<div class="d-flex">
    {{-- Sidebar (included in layouts.app) --}}

    {{-- Main Content --}}
    <div class="container-fluid p-5 py-5" style="min-height: 100vh; background: #f9f9f9;">
        
        {{-- Header --}}
        <section class="dashboard-header">
            <h1>Daftar Produksi</h1>
            <p>Manajemen produksi UD. Lestari Batako</p>
        </section>

        {{-- Breadcrumb --}}
        <div class="">
            @component('components.breadcrumb')
                @slot('breadcrumbs', [
                    ['name' => 'Produksi', 'url' => route('produksi.index')]
                ])
            @endcomponent
        </div>

        {{-- Header & Button --}}
        <div class="row justify-content-between align-items-center mb-4">
            <div class="col-auto">
                <h4 class="fw-bold text-primary">
                    <i class="bi bi-tools"></i>Daftar Produksi
                </h4>
            </div>
            <div class="col-auto">
                     <a href="{{ route('produksi.create_produksi') }}"
                   class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Produksi
                </a>
            </div>
        </div>

        {{-- Card Container --}}
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body">

                {{-- Success Alert --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2 text-success"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                {{-- Error Alert --}}
                @if($errors->any())
                    <div class="alert alert-danger shadow-sm">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="bi bi-exclamation-circle-fill text-danger me-2"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Table --}}
                <div class="table-industrial-wrapper">
                    <table class="table table-industrial striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produksi</th>
                                <th>Kriteria Gaji</th>
                                <th>Gaji Per Unit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produksis as $produksi)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $produksi->produk->nama_produk ?? 'N/A' }}</td>
                                    <td class="text-start">{{ $produksi->kriteria_gaji }}</td>
                                    <td>Rp{{ number_format((float) $produksi->gaji_per_unit, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Edit --}}
                                            <a href="{{ route('produksi.edit', $produksi->id_produksi) }}"
                                               class="btn btn-sm btn-warning rounded-circle"
                                               data-bs-toggle="tooltip" title="Edit Produksi"
                                               style="width: 32px; height: 32px;">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('produksi.destroy', $produksi->id_produksi) }}"
                                                  method="POST" onsubmit="return confirm('Yakin ingin menghapus produksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger rounded-circle"
                                                        data-bs-toggle="tooltip" title="Hapus Produksi"
                                                        style="width: 32px; height: 32px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted fst-italic">
                                        Belum ada data produksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Footer --}}
            <div class="card-footer text-end small text-muted bg-white">
                UD Lestari Batako &copy; {{ date('Y') }}
            </div>
        </div>
    </div>
</div>
@endsection

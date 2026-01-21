@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mt-4">
        @component('components.breadcrumb')
            @slot('breadcrumbs', [
                ['name' => 'Produksi Karyawan Tim', 'url' => route('tim_produksi.index')],
                ['name' => 'Edit Tim', 'url' => '#']
            ])
        @endcomponent
    </div>

    <h2 class="mb-4">Kelola Anggota Tim - {{ $produksi->produk->nama_produk ?? 'N/A' }} ({{ \Carbon\Carbon::parse($tanggalCarbon)->format('d M Y') }})</h2>

    <div class="card shadow-sm p-4 mb-4">
        <h5 class="card-title mb-3">Daftar Anggota</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Jumlah Unit</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotaTim as $anggota)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $anggota->karyawan->nama ?? 'N/A' }}</td>
                            <td>{{ $anggota->jumlah_unit }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('tim_produksi.member.edit', ['id' => $anggota->id]) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('tim_produksi.member.destroy', ['id' => $anggota->id]) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada anggota untuk produksi ini pada tanggal tersebut.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ route('tim_produksi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection

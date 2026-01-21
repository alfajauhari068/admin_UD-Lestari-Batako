@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="container max-w-900">
        <section class="dashboard-header mb-3">
            <h1>Detail Pesanan</h1>
            <p class="text-muted">Informasi lengkap dan item pada pesanan</p>
        </section>

        @component('components.breadcrumb')
            @slot('breadcrumbs', [
                ['name' => 'Pesanan', 'url' => route('pesanan.index')],
                ['name' => 'Detail Pesanan']
            ])
        @endcomponent

    {{-- Informasi Pesanan Utama --}}
    <div class="card custom-card mb-4 shadow-sm border-0">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold text-primary">Informasi Pesanan</h5>
            <p><strong>Nama Pelanggan:</strong> {{ $pesanan->pelanggan->nama ?? 'Tidak Diketahui' }}</p>
            <p><strong>Alamat:</strong> {{ $pesanan->pelanggan->alamat ?? 'Tidak Diketahui' }}</p>
            <p><strong>Catatan:</strong> {{ $pesanan->catatan ?? '-' }}</p>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($pesanan->status == 'Selesai') bg-success 
                    @elseif($pesanan->status == 'Dikirim') bg-warning 
                    @else bg-secondary 
                    @endif">
                    {{ $pesanan->status ?? 'Diproses' }}
                </span>
            </p>
            <p><strong>Total Bayar:</strong> Rp{{ number_format($pesanan->detailPesanan->sum('total_bayar'), 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Daftar Produk yang Dipesan --}}
    <div class="table-industrial-wrapper">
        <div class="p-3">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-primary mb-0">Produk yang Dipesan</h5>
                     <a href="{{ route('detail_pesanan.create', ['id_pesanan' => $pesanan->id_pesanan]) }}"
                   class="btn btn-sm btn-primary btn-icon"
                   data-bs-toggle="tooltip" title="Tambah Produk">
                    <i class="bi bi-plus-circle"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table custom-table striped">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Total Bayar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan->detailPesanan as $item)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td>{{ $item->produk->nama_produk ?? '-' }}</td>
                                <td class="text-center align-middle">{{ $item->jumlah }}</td>
                                <td class="text-center align-middle">Rp{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="text-center align-middle">
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('detail_pesanan.edit', $item->id_detail_pesanan) }}"
                                           class="btn btn-sm btn-warning btn-icon"
                                           data-bs-toggle="tooltip" title="Edit Detail">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('detail_pesanan.destroy', ['id_detail_pesanan' => $item->id_detail_pesanan]) }}"
                                              method="POST"
                                              class="delete-detail-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger btn-icon"
                                                    data-bs-toggle="tooltip" title="Hapus Produk">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">Tidak ada produk yang dipesan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


        <a href="{{ route('pesanan.index') }}" class="btn btn-secondary rounded-pill shadow-sm mt-3">Kembali</a>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>

<script>
    // Enhance DELETE forms: send DELETE via fetch with CSRF, fallback to normal submit
    document.addEventListener('DOMContentLoaded', function () {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrf = tokenMeta ? tokenMeta.getAttribute('content') : null;

        document.querySelectorAll('.delete-detail-form').forEach(form => {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                if (!confirm('Yakin ingin menghapus produk ini?')) return;

                try {
                    const res = await fetch(form.action, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrf || '',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (res.ok) {
                        // reload to reflect deletion
                        window.location.reload();
                        return;
                    }
                } catch (err) {
                    // ignore and fallback
                }

                // fallback: submit the form normally (will use method spoofing)
                form.submit();
            });
        });
    });
</script>

@endsection

{{-- filepath: d:\KULIAH\Semester4\Pemrograman FrameWork\ud_lestari-batako\resources\views\pesanan\edit_pesanan.blade.php --}}
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> <!-- Jika ada file CSS kustom -->
</head>
@extends('layouts.navbar')

@section('content')
<div class="container py-4 pt-5 p-5" style="padding-top: 80px;"> <!-- Tambahkan padding-top untuk menghindari tumpang tindih dengan navbar -->
    <h2 class="mb-4 pt-5 fw-bold text-primary">Edit Pesanan</h2>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pesanan.update', $pesanan->id_pesanan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Informasi Pelanggan --}}
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan', $pesanan->pelanggan->nama) }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan', $pesanan->catatan) }}</textarea>
                </div>

                {{-- Daftar Produk --}}
                <h5 class="mb-3">Produk yang Dipesan</h5>
                <div id="produk-container">
                    @foreach ($pesanan->detailPesanan as $index => $detail)
                    <div class="row mb-3 produk-row">
                        <div class="col-md-4">
                            <label for="produk_{{ $index }}" class="form-label">Produk</label>
                            <select class="form-select produk-select" id="produk_{{ $index }}" name="id[]" required>
                                <option value="" disabled>Pilih Produk</option>
                                @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_satuan }}" {{ $produk->id == $detail->id_produk ? 'selected' : '' }}>
                                    {{ $produk->nama_produk }} - Rp{{ number_format($produk->harga_satuan, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="jumlah_{{ $index }}" class="form-label">Jumlah</label>
                            <input type="number" class="form-control jumlah-input" id="jumlah_{{ $index }}" name="jumlah[]" value="{{ $detail->jumlah }}" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label for="total_harga_{{ $index }}" class="form-label">Total Harga</label>
                            <input type="text" class="form-control total-harga" id="total_harga_{{ $index }}" value="Rp{{ number_format($detail->total_bayar, 0, ',', '.') }}" readonly>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const produkRows = document.querySelectorAll('.produk-row');

        produkRows.forEach(row => {
            const jumlahInput = row.querySelector('.jumlah-input');
            const produkSelect = row.querySelector('.produk-select');
            const totalHargaInput = row.querySelector('.total-harga');

            // Fungsi untuk menghitung total harga
            const calculateTotalHarga = () => {
                const selectedOption = produkSelect.options[produkSelect.selectedIndex];
                const hargaSatuan = parseInt(selectedOption.dataset.harga || 0);
                const jumlah = parseInt(jumlahInput.value || 0);
                const totalHarga = hargaSatuan * jumlah;

                totalHargaInput.value = `Rp${totalHarga.toLocaleString('id-ID')}`;
            };

            // Event listener untuk perubahan jumlah
            jumlahInput.addEventListener('input', calculateTotalHarga);

            // Event listener untuk perubahan produk
            produkSelect.addEventListener('change', calculateTotalHarga);
        });
    });
</script>
@endsection
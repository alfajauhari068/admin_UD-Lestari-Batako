{{-- filepath: d:\KULIAH\Semester4\Pemrograman FrameWork\ud_lestari-batako\resources\views\pesanan\edit_pesanan.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4 pt-5 p-5">
    <h2 class="mb-5 pt-5 fw-bold text-primary">Edit Pesanan</h2>

    <div class="card custom-card max-w-900">
        <div class="card-body p-0">
            <form action="{{ route('pesanan.update', $pesanan->id_pesanan) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Informasi Pelanggan --}}
                <div class="mb-4">
                          <label for="nama_pelanggan" class="form-label fw-semibold">Nama Pelanggan</label>
                          <input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" 
                              value="{{ old('nama_pelanggan', $pesanan->pelanggan->nama) }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="catatan" class="form-label fw-semibold">Catatan</label>
                    <textarea class="form-control form-textarea" id="catatan" name="catatan" rows="4">{{ old('catatan', $pesanan->catatan) }}</textarea>
                </div>

                {{-- Daftar Produk --}}
                <h5 class="mb-4 fw-bold text-primary">Produk yang Dipesan</h5>
                <div id="produk-container">
                    @foreach ($pesanan->detailPesanan as $index => $detail)
                    <div class="row mb-4 produk-row">
                        <div class="col-md-4">
                            <label for="produk_{{ $index }}" class="form-label fw-semibold">Produk</label>
                            <select class="form-select produk-select form-control" id="produk_{{ $index }}" name="id[]" required>
                                <option value="" disabled>Pilih Produk</option>
                                @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_satuan }}" {{ $produk->id == $detail->id_produk ? 'selected' : '' }}>
                                    {{ $produk->nama_produk }} - Rp{{ number_format($produk->harga_satuan, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="jumlah_{{ $index }}" class="form-label fw-semibold">Jumlah</label>
                            <input type="number" class="form-control jumlah-input" id="jumlah_{{ $index }}" name="jumlah[]" 
                                value="{{ $detail->jumlah }}" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label for="total_harga_{{ $index }}" class="form-label fw-semibold">Total Harga</label>
                            <input type="text" class="form-control total-harga" id="total_harga_{{ $index }}" 
                                value="Rp{{ number_format($detail->total_bayar, 0, ',', '.') }}" readonly>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end gap-2 mt-5 pt-3">
                    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary-custom">
                        <i class="bi bi-arrow-left-circle me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
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
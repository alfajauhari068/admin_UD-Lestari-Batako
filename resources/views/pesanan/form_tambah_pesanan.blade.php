@extends('layouts.navbar')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 fw-bold text-primary">Tambah Pesanan untuk {{ $pelanggan->nama }}</h2>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('pesanan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pelanggan" value="{{ $pelanggan->id_pelanggan }}">

                <div id="produk-container">
                    <div class="row mb-3 produk-row">
                        <div class="col-md-4">
                            <label for="produk" class="form-label">Produk</label>
                            <select class="form-select produk-select" name="id[]" required>
                                <option value="" selected disabled>Pilih Produk</option>
                                @foreach($produks as $produk)
                                <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_satuan }}">
                                    {{ $produk->nama_produk }} - Rp{{ number_format($produk->harga_satuan, 0, ',', '.') }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control jumlah-input" name="jumlah[]" value="1" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label for="total-harga" class="form-label">Total Harga</label>
                            <input type="text" class="form-control total-harga" value="Rp0" readonly>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-danger btn-sm remove-produk">Hapus</button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-produk" class="btn btn-success btn-sm mb-3">Tambah Produk</button>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="grand-total" class="form-label">Total Pembayaran</label>
                    <input type="text" id="grand-total" class="form-control" name="total_bayar" value="Rp0" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menghitung total harga per produk
    function calculateTotalHarga(row) {
        const harga = parseInt(row.querySelector('.produk-select').selectedOptions[0].dataset.harga || 0);
        const jumlah = parseInt(row.querySelector('.jumlah-input').value || 0);
        const totalHarga = harga * jumlah;
        row.querySelector('.total-harga').value = `Rp${totalHarga.toLocaleString('id-ID')}`;
        calculateGrandTotal();
    }

    // Fungsi untuk menghitung total pembayaran (grand total)
    function calculateGrandTotal() {
        let grandTotal = 0;
        document.querySelectorAll('.produk-row').forEach(row => {
            const harga = parseInt(row.querySelector('.produk-select').selectedOptions[0].dataset.harga || 0);
            const jumlah = parseInt(row.querySelector('.jumlah-input').value || 0);
            grandTotal += harga * jumlah;
        });
        document.getElementById('grand-total').value = `Rp${grandTotal.toLocaleString('id-ID')}`;
    }

    // Tambahkan event listener untuk tombol tambah produk
    document.getElementById('add-produk').addEventListener('click', function () {
        const container = document.getElementById('produk-container');
        const row = document.querySelector('.produk-row').cloneNode(true);
        row.querySelector('.produk-select').value = '';
        row.querySelector('.jumlah-input').value = 1;
        row.querySelector('.total-harga').value = 'Rp0';
        container.appendChild(row);
    });

    // Tambahkan event listener untuk tombol hapus produk
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-produk')) {
            e.target.closest('.produk-row').remove();
            calculateGrandTotal();
        }
    });

    // Tambahkan event listener untuk perubahan pada dropdown produk atau input jumlah
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('produk-select') || e.target.classList.contains('jumlah-input')) {
            const row = e.target.closest('.produk-row');
            calculateTotalHarga(row);
        }
    });
</script>
@endsection
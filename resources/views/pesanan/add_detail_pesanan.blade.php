@extends('layouts.app')

@section('title', 'Tambah Produk ke Pesanan')

@section('content')
<?php
$produks = $produks ?? collect([]);
$pesanan = $pesanan ?? null;
?>
<div class="container-fluid py-4">

    {{-- Page Header --}}
    @component('components.page-header', [
        'title' => 'Tambah Produk ke Pesanan',
        'subtitle' => 'Pilih dan tambahkan produk ke dalam pesanan',
        'breadcrumbs' => [
            ['label' => 'Pesanan', 'url' => route('pesanan.index')],
            ['label' => 'Detail', 'url' => $pesanan ? route('pesanan.detail', $pesanan->id_pesanan) : '#'],
            ['label' => 'Tambah Produk']
        ]
    ])
    @endcomponent

    {{-- Pesanan Info Card --}}
    @if($pesanan)
        <div class="row mb-4">
            <div class="col-12">
                @component('components.card', ['title' => 'Informasi Pesanan'])
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>No. Pesanan:</strong> #{{ $pesanan->id_pesanan }}</p>
                            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Pelanggan:</strong> {{ $pesanan->pelanggan->nama ?? '-' }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge 
                                    @if($pesanan->status == 'selesai') bg-success 
                                    @elseif($pesanan->status == 'dibatalkan') bg-danger 
                                    @elseif($pesanan->status == 'diproses') bg-primary
                                    @else bg-warning text-dark
                                    @endif">
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Produk Dipesan:</strong> {{ $pesanan->detailPesanan->count() }} item</p>
                            <p><strong>Total:</strong> Rp{{ number_format($pesanan->calculateTotal(), 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endcomponent
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    @component('components.card', ['title' => 'Tambah Detail Produk'])
        <form action="{{ route('detail_pesanan.store') }}" method="POST">
            @csrf

            {{-- Hidden field for pesanan ID --}}
            <input type="hidden" name="id_pesanan" value="{{ $pesanan->id_pesanan ?? '' }}">

            {{-- Validation Errors --}}
            @include('components.errors')

            {{-- Product Details Table --}}
            <div class="table-industrial-wrapper">
                <div class="p-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="text-muted mb-0">Pilih produk dan masukkan jumlah yang akan ditambahkan</p>
                        <button type="button" class="btn btn-sm btn-success" id="addRow">
                            <i class="bi bi-plus-circle me-1"></i>Tambah Baris
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table striped" id="productTable">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 40px;">No</th>
                                    <th>Produk</th>
                                    <th class="text-center" style="width: 120px;">Jumlah</th>
                                    <th class="text-center" style="width: 150px;">Harga Satuan</th>
                                    <th class="text-center" style="width: 150px;">Total</th>
                                    <th class="text-center" style="width: 60px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="productRows">
                                <!-- Rows will be added here dynamically -->
                            </tbody>
                        </table>
                        @error('id_produk')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                        @error('jumlah')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                <a href="{{ $pesanan ? route('pesanan.detail', $pesanan->id_pesanan) : route('pesanan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle me-1"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save2 me-1"></i>Simpan Produk
                </button>
            </div>
        </form>
    @endcomponent

</div>

<script>
const products = {!! json_encode($produks->map(function($p) { return ['id_produk' => $p->id_produk, 'nama_produk' => $p->nama_produk, 'harga_satuan' => $p->harga_satuan, 'stok_tersedia' => $p->stok_tersedia]; })->values()->toArray()) !!};
let rowCount = 0;

function createProductRow(index = null) {
    const rowIndex = index !== null ? index : rowCount++;
    const row = `
        <tr class="product-row" data-row="${rowIndex}">
            <td class="text-center">
                <span class="row-number">${rowIndex + 1}</span>
            </td>
            <td>
                <select name="id_produk[]" class="form-select product-select" required>
                    <option value="">Pilih Produk</option>
                    ${products.map(p => `
                        <option value="${p.id_produk}" data-price="${p.harga_satuan}" data-stok="${p.stok_tersedia}">
                            ${p.nama_produk} (Stok: ${p.stok_tersedia})
                        </option>
                    `).join('')}
                </select>
            </td>
            <td class="text-center">
                <input type="number" name="jumlah[]" class="form-control form-control-sm jumlah-input" 
                       min="1" max="999" value="1" required style="width: 100%;">
            </td>
            <td class="text-center price-display">Rp0</td>
            <td class="text-center total-display">Rp0</td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-danger btn-icon remove-row" title="Hapus baris">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    `;
    return row;
}

function updateRowNumbers() {
    document.querySelectorAll('.row-number').forEach((el, idx) => {
        el.textContent = idx + 1;
    });
}

function calculateRowTotal(row) {
    const select = row.querySelector('.product-select');
    const jumlah = parseInt(row.querySelector('.jumlah-input').value) || 0;
    const price = parseFloat(select.options[select.selectedIndex].dataset.price) || 0;
    
    const total = price * jumlah;
    row.querySelector('.price-display').textContent = 'Rp' + price.toLocaleString('id-ID', {maximumFractionDigits: 0});
    row.querySelector('.total-display').textContent = 'Rp' + total.toLocaleString('id-ID', {maximumFractionDigits: 0});
}

function attachRowListeners(row) {
    const productSelect = row.querySelector('.product-select');
    const jumlahInput = row.querySelector('.jumlah-input');
    const removeBtn = row.querySelector('.remove-row');

    productSelect.addEventListener('change', function() {
        const stok = parseInt(this.options[this.selectedIndex].dataset.stok) || 0;
        jumlahInput.max = stok;
        if (jumlahInput.value > stok) {
            jumlahInput.value = stok;
        }
        calculateRowTotal(row);
    });

    jumlahInput.addEventListener('input', function() {
        const stok = parseInt(productSelect.options[productSelect.selectedIndex].dataset.stok) || 0;
        if (this.value > stok) {
            this.value = stok;
        }
        if (this.value < 1) {
            this.value = 1;
        }
        calculateRowTotal(row);
    });

    removeBtn.addEventListener('click', function(e) {
        e.preventDefault();
        row.remove();
        updateRowNumbers();
    });
}

document.getElementById('addRow').addEventListener('click', function() {
    const tbody = document.getElementById('productRows');
    const newRow = document.createElement('tr');
    newRow.innerHTML = createProductRow().replace(/<tr[^>]*>/, '').replace(/<\/tr>/, '');
    tbody.appendChild(newRow);
    const realRow = tbody.querySelector(`tr:last-child`);
    attachRowListeners(realRow);
});

// Attach listeners to initial rows (if any)
document.querySelectorAll('.product-row').forEach(row => {
    attachRowListeners(row);
});

// Form validation before submit
document.querySelector('form').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('.product-row');
    if (rows.length === 0) {
        e.preventDefault();
        alert('Minimal tambahkan 1 produk!');
        return false;
    }

    let hasError = false;
    rows.forEach((row, idx) => {
        const select = row.querySelector('.product-select');
        const jumlah = row.querySelector('.jumlah-input');
        if (!select.value) {
            select.classList.add('is-invalid');
            hasError = true;
        }
        if (!jumlah.value || jumlah.value < 1) {
            jumlah.classList.add('is-invalid');
            hasError = true;
        }
    });

    if (hasError) {
        e.preventDefault();
        alert('Periksa kembali data produk Anda!');
        return false;
    }
});
</script>
@endsection

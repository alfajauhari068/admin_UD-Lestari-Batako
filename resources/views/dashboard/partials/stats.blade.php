<div class="stats-grid">
    <div class="stat-card">
        <i class="bi bi-box"></i>
        <div>
            <h6>Total Produk</h6>
            <div class="value">{{ $totalProduk ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card">
        <i class="bi bi-exclamation-triangle"></i>
        <div>
            <h6>Stok Kritis</h6>
            <div class="value">{{ $produkKritis ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card">
        <i class="bi bi-cart-check"></i>
        <div>
            <h6>Pesanan Hari Ini</h6>
            <div class="value">{{ $pesananHariIni ?? 0 }}</div>
        </div>
    </div>
</div>

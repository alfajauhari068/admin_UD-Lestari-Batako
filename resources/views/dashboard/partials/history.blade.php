<ul class="list-group list-group-flush">
    @forelse($historyProduksiKaryawan as $h)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>{{ optional($h->karyawan)->nama ?? 'N/A' }} – {{ optional(optional($h->produksi)->produk)->nama_produk ?? 'N/A' }}</span>
        <span class="badge bg-primary">{{ $h->tanggal_produksi }}</span>
    </li>
    @empty
    <li class="list-group-item text-center text-muted">Belum ada history</li>
    @endforelse
</ul>
<ul class="list-group list-group-flush dashboard-history-list">
    @forelse($historyProduksiKaryawan as $h)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div class="history-info">
            <div class="history-user">
                {{ optional($h->karyawan)->nama ?? 'N/A' }}
            </div>
            <div class="history-meta text-muted">
                {{ optional(optional($h->produksi)->produk)->nama_produk ?? 'N/A' }}
            </div>
        </div>

        <span class="badge badge-warning">
            {{ $h->tanggal_produksi }}
        </span>
    </li>
    @empty
    <li class="list-group-item text-center text-muted py-4">
        Belum ada history produksi
    </li>
    @endforelse
</ul>

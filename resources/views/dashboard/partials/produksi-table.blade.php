<div class="table-responsive">
    <table class="table table-sm align-middle dashboard-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Produksi</th>
                <th>Karyawan</th>
                <th class="text-end">Unit</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produksiKaryawanTims as $d)
            <tr>
                <td class="text-muted"><center>{{ $loop->iteration }}</center></td>
                <td>
                <center>
                    <span class="fw-medium">
                        {{ optional(optional($d->produksi)->produk)->nama_produk ?? 'N/A' }}
                    </span>
                </center>
                </td>
                <td>
                <center>
                    <span class="table-user">
                        {{ optional($d->karyawan)->nama ?? 'N/A' }}
                    </span>
                </center>
                </td>
                <td class="text-end">
                <center>
                    <span class="badge badge-info">
                        {{ $d->jumlah_unit }} unit
                    </span>
                </center>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                <center>
                    Belum ada data produksi
                </center>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

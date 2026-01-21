<div class="table-responsive">
    <table class="table table-sm align-middle dashboard-table">
        <thead>
            <tr>
                
                <th>ID Pesanan</th>
                <th>Pelanggan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesananTerbaru as $p)
            <tr>
                
                <td>
                <center>
                    <span class="fw-semibold text-primary">
                        #{{ $p->id_pesanan }}
                    </span>
                </center>
                </td>
                <td>
                <center>
                    <span class="table-user">
                        {{ $p->pelanggan->nama ?? '-' }}
                    </span>
                </center>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center text-muted py-4">
                    Tidak ada pesanan terbaru
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

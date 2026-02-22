<?php

namespace App\Observers;

use App\Models\DetailPesanan;

class DetailPesananObserver
{
    /**
     * Handle the DetailPesanan "created" event.
     * Update pesanan total after detail is created
     */
    public function created(DetailPesanan $detailPesanan): void
    {
        $detailPesanan->pesanan->updateTotal();
    }

    /**
     * Handle the DetailPesanan "updated" event.
     * Update pesanan total after detail is updated
     */
    public function updated(DetailPesanan $detailPesanan): void
    {
        $detailPesanan->pesanan->updateTotal();
    }

    /**
     * Handle the DetailPesanan "deleted" event.
     * Update pesanan total after detail is deleted
     */
    public function deleted(DetailPesanan $detailPesanan): void
    {
        $detailPesanan->pesanan->updateTotal();
    }

    /**
     * Handle the DetailPesanan "restored" event.
     */
    public function restored(DetailPesanan $detailPesanan): void
    {
        $detailPesanan->pesanan->updateTotal();
    }

    /**
     * Handle the DetailPesanan "force deleted" event.
     */
    public function forceDeleted(DetailPesanan $detailPesanan): void
    {
        $detailPesanan->pesanan->updateTotal();
    }
}

<?php

namespace App\Observers;

use App\Models\ProduksiTim;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProduksiTimObserver
{
  public function creating(ProduksiTim $model): void
  {
    $this->validateAndCompute($model);
  }

  public function updating(ProduksiTim $model): void
  {
    $this->validateAndCompute($model);
  }

  protected function validateAndCompute(ProduksiTim $model): void
  {
    // Validate inputs
    $data = [
      'jumlah_unit' => $model->jumlah_unit,
    ];

    Validator::make($data, [
      'jumlah_unit' => ['required', 'integer', 'min:1'],
    ])->validate();
    // No computation of upah_total or use of upah_per_unit here.
    // This observer only validates jumlah_unit as a participation log.
  }
}

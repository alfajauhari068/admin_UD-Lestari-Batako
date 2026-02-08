<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimProduksiRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'id_produksi' => 'required|exists:produksis,id_produksi',
      'id_karyawan' => 'required|array|min:1',
      'id_karyawan.*' => 'required|exists:karyawans,id_karyawan',
      'jumlah_unit' => 'required|integer|min:1',
      'tanggal_produksi' => 'required|date',
    ];
  }
}

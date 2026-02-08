<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduksiRequest extends FormRequest
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
      'id_produk' => 'required|exists:produks,id_produk',
      'kriteria_gaji' => 'required|string|max:255',
      'gaji_per_unit' => 'required|integer|min:1',
      'jumlah_per_unit' => 'required|integer|min:1',
    ];
  }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePesananRequest extends FormRequest
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
      'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
      'catatan' => 'nullable|string',
      'id_produk' => 'sometimes',
      'id_produk.*' => 'exists:produks,id_produk',
      'jumlah' => 'sometimes',
      'jumlah.*' => 'integer|min:1',
    ];
  }
}

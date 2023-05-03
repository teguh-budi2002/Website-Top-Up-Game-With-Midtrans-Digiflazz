<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required',
            'item_name' => 'required',
            'nominal' => 'required',
            'price' => 'required|integer'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'item_name.required' => 'Nama Item Tidak Boleh Kosong.',
            'nominal.required' => 'Jumlah Nominal Pada Item Tidak Boleh Kosong.',
            'price.required' => 'Harga Harus Dicantumkan.',
            'price.integer' => 'Harga Harus Berupa Angka.',
        ];
    }
}

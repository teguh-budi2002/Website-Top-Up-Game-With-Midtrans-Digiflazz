<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'product_id' => 'required|integer',
            'email' => 'required',
            'number_phone' => 'required|integer',
            'UID' => 'required',
            'qty' => 'required',
            'payment_status' => 'in:Pending,Success,Expired'
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
            'email.required' => 'Alamat Email Harus Di Isi.',
            'number_phone.required' => 'Nomer HP Harus Di Isi.',
            'number_phone.integer' => 'Nomer HP Harus Berupa Angka.',
            'UID' => 'Player ID Tidak Boleh Kosong.',
            'qty.required' => 'Cantumkan Jumlah Order',
        ];
    }
}

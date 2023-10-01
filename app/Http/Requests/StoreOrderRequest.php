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
            'product_id'    => 'required|integer',
            'payment_id'    => 'required',
            'email'         => 'nullable|email|ends_with:@gmail.com',
            'player_id'     => 'required|regex:/^[^\s\p{P}]+$/',
            'qty'           => 'required',
            'price'         => 'required',
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
            'email.email'           => 'Alamat Email Harus Valid.',
            'email.ends_with'       => 'Alamat Email Harus Terdaftar Dari Domain @gmail.com',
            'player_id.required'    => 'Game ID Tidak Boleh Kosong.',
            'player_id.regex'       => 'Format Player ID Tidak Valid.',
            'payment_id.required'   => 'Metode Pembayaran Wajib Dipilih.',
            'qty.required'          => 'Cantumkan Jumlah Order.',
            'price'                 => "Pilih Minimal Satu Item Agar Dapat Melanjutkan Pembelian."
        ];
    }
}

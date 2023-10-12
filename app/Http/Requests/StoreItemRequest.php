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
            'product_id'    => 'required',
            'item_name'     => 'required',
            'code_item'     =>  'required',
            'nominal'       => 'required',
            'price'         => 'required|integer'
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
            'item_name.required'    => 'Name of Item Cannot Be Null.',
            'code_item.required'    => 'Code of Item Cannot Be Null.',
            'nominal.required'      => 'Nominal of Item Cannot Be Null.',
            'price.required'        => 'Price of Item Cannot Be Null.',
            'price.integer'         => 'Allowed Character is Only Numeric.',
        ];
    }
}

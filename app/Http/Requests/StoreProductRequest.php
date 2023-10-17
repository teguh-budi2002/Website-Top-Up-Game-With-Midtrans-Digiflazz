<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'product_name' => 'required',
            'code_product' => 'required',
            'category_id'  => 'required',
            'img_url' => 'required|image|mimes:webp,png,jpg,jpeg|max:2048'
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
            'product_name.required' => "The Name Of Product Can't Be Null",
            'code_product.required' => "The Code of Product Can't Be Null",
            'category_id.required' => "Category Of Product Can't Be Null",
            'img_url.required' => 'The Product Must Have a Photo.',
            'img_url.uploaded' => 'Maximum Image Size Allowed is 2MB'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'product_type_id' => 'required|exists:product_types,id',
            'price_sign_id' => 'required|exists:price_signs,id',
            'currency_type_id' => 'required|exists:currency_types,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image_link' => 'required|url',
            'description' => 'required|string|max:1000',
            'is_active' => 'required|boolean'       
        ];
    }
}

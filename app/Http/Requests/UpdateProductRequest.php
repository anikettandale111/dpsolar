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
            'cat_id' => 'required',
            'sub_cat_id' => 'required',
            'product_name' => 'required|string|max:1000',
            'description' => 'required|string|max:1000',
            'features' => 'required|string|max:1000',
            'user_rating' => 'required',
            'display_price' => 'required',
            'selling_price' => 'required',
            'avbl_stock' => 'required',
        ];
    }
}

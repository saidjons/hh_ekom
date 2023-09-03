<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "title"=>["nullable","string","max:200"],
            "image"=>["nullable","string"],
            "price"=>["nullable","numeric"],
            "description"=>["string","nullable"],
            "in_stock"=>["nullable","boolean"],

        ];
    }
}

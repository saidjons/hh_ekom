<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "title"=>["required","string","max:200"],
            "image"=>["required","image:jpg,png,jpeg","max:5048"],
            "price"=>["required","numeric"],
            "description"=>["string","required"],
            "in_stock"=>["required","boolean"],

        ];
    }
}

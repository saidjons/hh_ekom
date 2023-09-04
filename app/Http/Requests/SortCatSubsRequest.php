<?php

namespace App\Http\Requests;

use App\Rules\CategorySubs;
use App\Rules\CategorySubsWithIds;
use Illuminate\Foundation\Http\FormRequest;

class SortCatSubsRequest extends FormRequest
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
            "subs"=>["required","array",new CategorySubsWithIds()],
        ];
    }
}

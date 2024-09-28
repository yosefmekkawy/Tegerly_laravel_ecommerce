<?php

namespace App\Http\Requests;

use App\Actions\HandleRulesValidation;
use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
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
        $arr=[
            'id'=>'filled',
            'price'=>'required|numeric|min:0',
            'published_by'=>'filled',
            'category'=>'required'

        ];
        $rules=HandleRulesValidation::handle($arr,['title:required','description:required']);
        return $rules;
    }
}

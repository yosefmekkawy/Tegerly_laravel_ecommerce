<?php

namespace App\Http\Requests;

use App\Actions\HandleRulesValidation;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    private array $arr;

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
        $this->arr=[
            'id'=>'filled',
        ];
        return HandleRulesValidation::handle($this->arr,['name:required']);
    }
}

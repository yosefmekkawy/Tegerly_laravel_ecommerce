<?php

namespace App\Http\Resources;

use App\Actions\DisplayDataWithCurrentLang;
use App\Actions\HandleRulesValidation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=> str_contains(request()->fullUrl(), 'categories') &&
            str_contains(request()->fullUrl(), 'edit') ?
                $this->name :DisplayDataWithCurrentLang::display($this->name),
            'image'=>$this->whenLoaded('image'),
        ];


    }
}

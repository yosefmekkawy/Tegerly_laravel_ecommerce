<?php

namespace App\Http\Resources;

use App\Actions\DisplayDataWithCurrentLang;
use App\Actions\HandleRulesValidation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'title'=>str_contains(request()->fullUrl(), 'edit') == false ? DisplayDataWithCurrentLang::display($this->title) :$this->title,
            'description'=>str_contains(request()->fullUrl(), 'edit') == false ? DisplayDataWithCurrentLang::display($this->description):$this->description,
            'price'=>$this->price,
            'images' =>$this->whenLoaded('images'),
            'user' => $this->whenLoaded('user'),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}

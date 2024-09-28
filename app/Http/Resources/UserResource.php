<?php

namespace App\Http\Resources;

use App\Actions\DisplayDataWithCurrentLang;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username'=>$this->username,
            'image'=>$this->whenLoaded('image'),
            'email'=>$this->email,
            'phone'=>$this->phone,
            'type'=>$this->type,
        ];
    }
}

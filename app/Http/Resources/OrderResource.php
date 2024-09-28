<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'ordered_by' => $this->ordered_by,
            'status' => $this->status,
            'items' => OrderItemResource::collection($this->whenLoaded('items'))->resolve(),
        ];
    }
}

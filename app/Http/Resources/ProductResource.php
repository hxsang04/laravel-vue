<?php

namespace App\Http\Resources;

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
            'id' => $this->id,
            'name' => $this->name,
            'price' => number_format($this->price),
            'description' => $this->description,
            'image' => '/storage/'.$this->image,
            'created_at' => date_format($this->created_at,"Y/m/d H:i:s"),
            'updated_at' => date_format($this->updated_at,"Y/m/d H:i:s"),
        ];
    }
}

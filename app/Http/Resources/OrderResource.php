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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'total_price' => number_format($this->total_price),
            'message' => $this->message,
            'created_at' => date_format($this->created_at,"Y/m/d H:i:s"),
            'products' => $this->products->map(function ($product){
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => '/storage/'. $product->image,
                    'quantity' => $product->pivot->quantity,
                    'unit_price' => number_format($product->pivot->unit_price),
                    'total'=> number_format($product->pivot->unit_price * $product->pivot->quantity),
                ];
            }),
        ];
    }
}

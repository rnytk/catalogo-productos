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
            'sort' => $this->sort,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price, 
            'brand' => $this->brand->name ?? null,
            'category' => $this->category->name ?? null,
            'color_category' => $this->category->color ?? null,
            'image_url' => $this->imagen
                ? asset('storage/' . $this->imagen)
                : null,
        ];
    }
}

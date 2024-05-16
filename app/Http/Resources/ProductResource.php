<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [

            'id' => $this->id,
            'brand_id' => BrandResource::collection($this->whenLoaded('brands')),
            'category_id' => CategoryResource::collection($this->whenLoaded('categories')),
            'product_type_id' => ProductTypeResource::collection($this->whenLoaded('product_types')),
            'price_sign_id' => PriceSignResource::collection($this->whenLoaded('price_signs')),
            'currency_type_id' => CurrencyTypeResource::collection($this->whenLoaded('currency_types')),
            'name' => $this->name,
            'price'=> $this->price,
            'image_link' => $this->image_link,
            'description'=> $this->description,
            'is_active' => $this->is_active,
        ];
    }
}

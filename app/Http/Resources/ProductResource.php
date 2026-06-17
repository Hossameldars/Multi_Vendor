<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'slug'                => $this->slug,
            'description'         => $this->description,~
            'price'               => $this->price,
            'compare_price'       => $this->whenNotNull($this->compare_price),
            'discount_percentage' => $this->discount_percentage,

            'options'             => $this->options,
            'featured'            => (bool) $this->featured,
            'status'              => $this->status,

            'category' => $this->whenLoaded('category', fn() => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
            ]),

            'store' => $this->whenLoaded('store', fn() => [
                'id'   => $this->store->id,
                'name' => $this->store->name,
            ]),

            'tags' => $this->whenLoaded('tags', fn() =>
                $this->tags->map(fn($tag) => [
                    'id'   => $tag->id,
                    'name' => $tag->name,
                ])
            ),

            'images' => $this->whenLoaded('images', fn() => [
                'id'  => $this->images->id,
                'url' => $this->images->url,
            ]),

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
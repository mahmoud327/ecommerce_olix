<?php

namespace App\Http\Resources\Refactoring;

use App\Http\Resources\FeaturResource;
use App\Http\Resources\FilterResource;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request                                          $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->resource->id,
            'name'            => $this->resource->name,
            'organization'    => OrganizationResource::make($this->whenLoaded('organization')),
            'description'     => $this->resource->description,
            'note'            => $this->resource->note,
            'isFavorite'      => ($this->resource->is_favorite ? 'true' : 'false') ?? 'false',
            'discount'        => $this->resource->discount,
            'price'           => (string) $this->resource->price,
            'finalPrice'      => (string) $this->resource->final_price,
            'featuredImage'   => $this->resource->featured_image,
            'images'          => $this->resource->images,
            'link'            => $this->resource->link,

            'username'        => $this->resource->username ?? optional($this->user)->name ?? 'suiiz',
            'phones'          => $this->phone,
            'contact'         => $this->contact,
            'properties'      => PropertyResource::collection($this->properties),
            'filters'         => FilterResource::collection($this->filters),
            'features'        => FeaturResource::collection($this->features),

            'cityName'        => optional($this->resource->city)->name ?? '',
            'cityId'          => $this->resource->city_id,
            'categoryId'      => $this->resource->category_id,
            'categoryName'    => optional($this->category)->name ?? '',
            'governorateName' => optional(optional($this->resource->city)->governorate)->name ?? __('lang.cities.cairo'),
            'phonesCount'     => (string) $this->resource->count_phone,
            'viewsCount'      => (string) $this->resource->count_view,
            'chatsCount'      => (string) $this->resource->count_chat,
            'favouritesCount' => (string) $this->resource->favourites_count,
            'createdAt'       => $this->resource->created_at ?? now(),
            'updatedAt'       => $this->resource->updated_at,
        ];
    }
}

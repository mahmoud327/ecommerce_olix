<?php

namespace App\Http\Resources\Refactoring;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'note'            => $this->resource->note,
            'isFavorite'      => ($this->resource->is_favorite ? 'true' : 'false') ?? 'false',
            'discount'        => $this->resource->discount,
            'price'           => (string) $this->resource->price,
            'finalPrice'      => (string) $this->resource->final_price,
            'featuredImage'   => $this->resource->featured_image,
            'cityName'        => optional($this->resource->city)->name ?? '',
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

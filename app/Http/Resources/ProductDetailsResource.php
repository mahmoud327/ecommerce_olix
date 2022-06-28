<?php

namespace App\Http\Resources;

use App\Http\Resources\FeaturResource;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\OrganizationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
{

    /**
     * @param $request
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'username'         => $this->username,
            'user_image'       => $this->user_image,
            'phone'            => $this->phone,
            'quantity'         => $this->quantity,
            'count_of_view'    => (string) $this->count_view,
            'organization'     => new OrganizationResource($this->organization),
            'category_id'      => $this->category_id,
            'category_name'    => $this->category ? $this->category->name : null,
            'status'           => $this->status,
            'user_id'          => $this->user_id,
            'contact'          => $this->contact,
            'link'             => $this->link,
            'discount'         => $this->discount ? (string) $this->discount : null,
            'description'      => $this->description,
            'note'             => $this->note,
            'price'            => (string) $this->price,
            'total'            => $this->priceAfterdiscount,
            'created_at'       => $this->user_id == null ? null : $this->created_at,
            'updated_at'       => $this->user_id == null ? null : $this->updated_at,
            'city_name'        => $this->city ? $this->city->name : 'Egypt',
            'governorate_name' => $this->city ? $this->city->governorate->name : $this->cairo->name,
            'is_favorites'     => $this->resource->is_favorited,
            'features'         => FeaturResource::collection($this->features ?? collect([])),
            'filters'          => FilterResource::collection($this->filters ?? collect([])),
            'properties'       => PropertyResource::collection($this->properties),
            'images'           => $this->resource->images,
        ];
    }
}

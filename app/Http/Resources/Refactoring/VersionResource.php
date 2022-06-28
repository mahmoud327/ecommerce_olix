<?php

namespace App\Http\Resources\Refactoring;

use Illuminate\Http\Resources\Json\JsonResource;

class VersionResource extends JsonResource
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
            'number'      => $this->resource->number,
            'description' => $this->resource->description,
            'priority'    => $this->resource->priority,
            'createdAt'   => $this->resource->created_at ?? now(),
        ];
    }
}

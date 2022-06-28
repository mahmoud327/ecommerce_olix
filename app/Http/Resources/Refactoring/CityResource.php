<?php

namespace App\Http\Resources\Refactoring;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    /**
     * @param $request
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'governorate_id'   => $this->governorate_id,
            'governorate_name' => optional($this->resource->governorate)->name,
        ];
    }
}

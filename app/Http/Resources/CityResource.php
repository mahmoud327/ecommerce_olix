<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            
            'id'                        => $this->id,
            'name'                      => $this->name,
            'governorate_id'            => $this->governorate_id,
            'governorate_name'          => $this->governorate->name,


         ];
    }
}

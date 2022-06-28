<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CityResource;
use URL;

class GovernorateResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            
            'id'            => $this->id,
            'name'          => $this->name,
            'cities'        => CityResource::collection($this->cities),
                    
         ];
    }
}

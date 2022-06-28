<?php

namespace App\Http\Resources;

use App\Models\Filter;
use URL;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubPropertyResource;

class PropertyResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                    'id'                        => $this->id,
                    'name'                      => $this->name,
                    'sub_properties'            => SubPropertyResource::collection($this->subProperties),
               ];
    }
}

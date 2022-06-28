<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URl;

class SubPropertyResource extends JsonResource
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
                    'price'                     =>(string) $this->products->first()->pivot->price
               ];
    }
}

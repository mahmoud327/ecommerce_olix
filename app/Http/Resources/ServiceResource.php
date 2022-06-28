<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubAccountResource;
use App\Models\SubAccount;

class ServiceResource extends JsonResource
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
                    'id'                    => $this->id,
                    'name'                  => $this->name,
                    'price'                =>(string) $this->organizationService->first()->pivot->price

                ];
    }
}

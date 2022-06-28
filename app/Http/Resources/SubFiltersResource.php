<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class SubFiltersResource extends JsonResource
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
                    'image'                     =>env('AWS_S3_URL').'/uploads/RecuringSubFilter/'. $this->image,
       
               ];
    }
}

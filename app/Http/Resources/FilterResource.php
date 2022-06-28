<?php

namespace App\Http\Resources;

use App\Models\Filter;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubFiltersResource;
use URL;

class FilterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
                    'id'                        => $this->id,
                    'name'                      => $this->name,
                    'image'                     => $this->image ? env('AWS_S3_URL').'/uploads/RecuringFilter/'.$this->image : env('AWS_S3_URL') .'/uploads/avatar.png',
                    'category_id'               => $this->category_id,
                    'sub_filters'               => SubFiltersResource::collection($this->subFiltersRecurring),
               ];
    }
}

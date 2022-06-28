<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CityResource;
use URL;

class PaginationResource extends JsonResource
{
    public function toArray($request)
    {
        return [

            'total' => $this->total(),
            'count' => $this->count(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'total_pages' => $this->lastPage()
            
        ];
    }
}
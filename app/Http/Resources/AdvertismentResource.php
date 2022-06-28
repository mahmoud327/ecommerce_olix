<?php

namespace App\Http\Resources;

use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use URL;

class AdvertismentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            
            'id'                        => $this->id,
            'link'                      => $this->link,
            'type'                      => $this->type,
            'type_id'                   => $this->type_id,
            'image'                     => $this->image ? env('AWS_S3_URL') .'/uploads/advertisments/'.$this->image : env('AWS_S3_URL') .'/uploads/avatar.png',


                    
         ];
    }
}

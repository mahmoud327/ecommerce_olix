<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubAccountResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\ReplyResource;
use URL;

use App\Models\SubAccount;

class AboutUsResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {


        // return $this->post->organization->media;

        return[
                'id'  =>$about_us
               
            ];
    }
}

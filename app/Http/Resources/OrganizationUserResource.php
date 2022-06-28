<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class OrganizationUserResource extends JsonResource
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
                    'link'                      => $this->link,
                    'description'               => $this->description,
                    'phones'                    => $this->phones,
                    'latitude'                  => $this->latitude,
                    'langitude'                  =>$this->langitude,
                    'background_cover'          =>URL::to('/').$this->background_cover,
                    'image'                     => $this->media ? env('AWS_S3_URL').'/'.$this->media->path : env('AWS_S3_URL').'/uploads/avatar.png',

                ];
    }
}

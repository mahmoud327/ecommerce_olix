<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'image' => $this->media ? env('AWS_S3_URL') . '/' . $this->media->path : env('AWS_S3_URL') . '/uploads/avatar.png',
        ];
    }
}

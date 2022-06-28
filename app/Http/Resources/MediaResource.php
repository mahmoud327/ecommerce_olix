<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'id'          => $this->resource->id,
            'original'    => config('filesystems.disks.s3.url') . '/' . $this->path,
            'large'       => config('filesystems.disks.s3.url') . '/' . $this->path,
            'medium'      => config('filesystems.disks.s3.url') . '/' . $this->path,
            'thumb'       => config('filesystems.disks.s3.url') . '/' . $this->path,
            'order'       => $this->position,
            'position'    => $this->position,
            'is_featured' => $this->position === 1,
        ];
    }
}

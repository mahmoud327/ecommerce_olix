<?php

namespace App\Http\Resources\Refactoring;

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
            'id'    => $this->resource->id,
            'name'  => $this->resource->name,
            'image' => config('filesystems.disks.s3.url') . '/' . ($this->resource->media ? $this->media->path : 'uploads/avatar.png'),
        ];
    }
}

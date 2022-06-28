<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubAccountResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\ReplyResource;
use URL;

use App\Models\SubAccount;

class CommentResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image = ['full_file' => env('AWS_S3_URL') . '/' . $this->user->image ];

        // return $this->post->organization->media;

        return[
                'id'                    => $this->id,
                'comment'               => $this->comment,
                'user_id'               => $this->user_id,
                'user_name'             => $this->post->organization_id == $this->user->organization_id ? $this->user->organization->name : $this->user->name,
                'user_image'            => $this->post->organization_id == $this->user->organization_id ? ($this->post->organization->media != null ?  new MediaResource($this->post->organization->media) : $image)  : $image,
                'replies'               => ReplyResource::collection($this->replies)
            ];
    }
}

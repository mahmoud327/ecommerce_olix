<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubAccountResource;
use App\Http\Resources\MediaResource;
use URL;

use App\Models\SubAccount;

class ReplyResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image = ['full_file' => URL::to('/'). $this->user->image ];

        return[
         
                'id'                    => $this->id,
                'reply'                 => $this->reply,
                'user_id'               => $this->user_id,
                'user_name'             => $this->comment->post->organization_id == $this->user->organization_id ? $this->user->organization->name : $this->user->name,
                'user_image'            => $this->comment->post->organization_id == $this->user->organization_id ? ($this->comment->post->organization->media != null ?  new MediaResource($this->comment->post->organization->media) : $image)  : $image,

            ];
    }
}

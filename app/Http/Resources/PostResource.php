<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\MediaResource;
use App\Models\Comment;
use App\Models\Like;

use URL;

class PostResource extends JsonResource
{
    public function toArray($request)
    {
        $medias= ['full_file' => env('AWS_S3_URL').'/uploads/avatar.png' ];
        $comments = Comment::where('post_id', $this->id)->get();
        $like_count = Like::where('post_id', $this->id)->count();

        return [
            
            'id'                        => $this->id,
            'content'                   => $this->content,
            'user_id'                   => $this->user_id,
            'organization_id'           => $this->organization_id,
            'organization_name'         => $this->organization->name,
            'medias'                    => $this->medias()->count() ? $this->medias : [$medias] ,
            'like_count'                => $like_count,
            'comments_count'            => count($comments) ,
            'comments'                  => CommentResource::collection($comments),
                    
         ];
    }
}

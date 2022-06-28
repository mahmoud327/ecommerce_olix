<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'posts';

    protected $softDelete = true;
    protected $dates = ['deleted_at'];




    protected $fillable = [
      'content',
      'user_id',
      'organization_id',

  ];


    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediaable');
    }


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
        return $this->belongsToMany('App\Models\User', 'comments')->withPivot('comment');
    }

    public function likes()
    {
        return $this->belongsToMany('App\Models\User', 'likes');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }


    public static function boot()
    {
        parent::boot();

        self::deleting(function (Post $post) {
            if ($post->forceDeleting) {
                foreach ($post->medias()->get() as $media) {
                    \Storage::disk('s3')->delete($media->path);
                    $media->forceDelete();
                }

                $post->comments()->detach();
                $post->likes()->detach();
                $comments_ids = Comment::where('post_id', $post->id)->pluck('id');
                $replies = Reply::whereIn('comment_id', $comments_ids);
                $replies->forceDelete();
            }
        });
    }
}

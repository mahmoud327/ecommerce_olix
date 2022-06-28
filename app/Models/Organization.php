<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Organization extends Model
{
    use SoftDeletes,HasTranslations,HasFactory;
    public $translatable = ['name'];
    protected $table = 'organizations';
    protected $softDelete = true;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name','background_cover','link','phones','description','langitude',  'latitude','byadmin','organization_type_id'

    ];
    protected $casts = [
        'phones' => 'array'
    ];

    protected $hidden = [
    'created_at',
    'updated_at',
    'deleted_at',
];


    public function media()
    {
        return $this->morphOne('App\Models\Media', 'mediaable');
    }


    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }


    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Organization $organization) {
            if ($organization->forceDeleting) {
                $media = $organization->media;
                if ($media) {
                    \Storage::disk('s3')->delete($media->path);
                }

                // to force delete all products of organization
                $organization->products()->get()
                    ->each(function ($product) {
                        $product->forceDelete();
                    });

                // to force delete all posts of organization
                $organization->posts()->get()
                    ->each(function ($post) {
                        $post->forceDelete();
                    });
            } else {

                // to delete all products of organization
                $organization->products()->get()
                    ->each(function ($product) {
                        $product->delete();
                    });

                // to delete all posts of organization
                $organization->posts()->get()
                    ->each(function ($post) {
                        $post->delete();
                    });
            }
        });


        static::restoring(function (Organization $organization) {


            // to restore all products of organization
            $organization->products()->onlyTrashed()->get()
            ->each(function ($product) {
                $product->restore();
            });

            // to restore all posts of organization
            $organization->posts()->onlyTrashed()->get()
                ->each(function ($post) {
                    $post->restore();
                });
        });
    }
}

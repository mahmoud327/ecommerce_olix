<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class View extends Model
{
    protected $table = 'views';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'image');

    public function categories()
    {
        return $this->hasMany('App\Models\Category');
    }

    public function categoriesRecurring()
    {
        return $this->hasMany('App\Models\CategoryRecurring', 'view_id');
    }


    public function getImageAttribute($value)
    {
        if ($value) {
            return env('AWS_S3_URL').'/'.$value;
        } else {
            return asset('/uploads/avatar.png');
        }
    }
}

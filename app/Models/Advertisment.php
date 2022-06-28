<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Advertisment extends Model
{
    protected $table = 'advertisments';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('link','category_id','type_id','image','code');

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    
    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediaable');
    }
}

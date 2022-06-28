<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Governorate extends Model
{
    use SoftDeletes, HasTranslations;
    
    public $translatable = ['name'];

    protected $table = 'governorates';
    public $timestamps = true;
    protected $fillable = array('name');

    protected $dates = ['deleted_at'];

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}

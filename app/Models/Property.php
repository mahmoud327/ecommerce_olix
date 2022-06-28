<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Property extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $table = 'properties';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name');

    public function subProperties()
    {
        return $this->hasMany('App\Models\SubProperty');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class SubProperty extends Model
{
    use HasTranslations;
    use SoftDeletes;

    protected $table = 'sub_properties';

    protected $fillable = array('name', 'property_id');

    public $translatable = ['name'];

    public $timestamps = true;

    protected $dates = ['deleted_at'];

    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_sub_properties')->withPivot('price');
    }

    public function productProperties()
    {
        return $this->hasMany('App\Models\ProductSubProperty', 'sub_property_id');
    }
}

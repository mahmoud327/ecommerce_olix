<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use SoftDeletes, HasTranslations;

    public $translatable = ['name'];

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name', 'governorate_id');
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function governorate()
    {
        return $this->belongsTo('App\Models\Governorate');
    }

    /*
     * ----------------------------------------------------------------- *
     * ----------------------------- Scopes ---------------------------- *
     * ----------------------------------------------------------------- *
     */
    

    public function scopeGovernorate($query, $id)
    {
        $query->where('governorate_id', $id);
    }
}

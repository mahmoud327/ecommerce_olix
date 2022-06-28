<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FilterType extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $table = 'filter_types';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name');

    public function recurringFilters()
    {
        return $this->hasMany('App\Models\FilterRecurring');
    }
}

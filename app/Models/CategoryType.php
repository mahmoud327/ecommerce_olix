<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class CategoryType extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $table = 'category_types';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name');

    public function recurringCategories()
    {
        return $this->hasMany('App\Models\CategoryRecurring');
    }
}

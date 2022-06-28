<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class SubFilterRecurring extends Model
{
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['name'];

    protected $table = 'sub_filters_recurring';
    public $timestamps = true;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'filter_recurring_id','image', 'position');

    public function filtersRecurring()
    {
        return $this->belongsTo('App\Models\FilterRecurring', 'filter_recurring_id');
    }

    public function subFilters()
    {
        return $this->hasMany('App\Models\SubFilter', 'recurring_sub_filter_id');
    }


    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_sub_filter_recurring');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (SubFilterRecurring $recurring_sub_filter) {
            if ($recurring_sub_filter->forceDeleting) {
                if ($recurring_sub_filter->image) {
                    \Storage::disk('s3')->delete('uploads/SubFilters/'.$recurring_sub_filter->image);
                }


                $recurring_sub_filter->products()->detach();
            }
        });
    }
}

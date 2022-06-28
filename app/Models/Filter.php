<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Filter extends Model
{
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['name'];

    protected $table = 'filters';
    public $timestamps = true;

    protected $hidden = array('created_at', 'updated_at', 'deleted_at', 'filter_recurring_id', 'product_id');

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'filter_recurring_id', 'category_id','product_id','image');



    public function subAccounts()
    {
        return $this->belongsToMany('App\Models\SubAccount', 'filter_sub_accounts');
    }

    public function subFilters()
    {
        return $this->hasMany('App\Models\SubFilter');
    }

    public function filterRecurring()
    {
        return $this->belongsTo('App\Models\FilterRecurring', 'filter_recurring_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'filter_product');
    }


    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }





    public static function boot()
    {
        parent::boot();

        self::deleting(function (Filter $filter) {
            if ($filter->forceDeleting) {

                    // to delete all sub filters of filter
                $filter->subFilters()->withTrashed()->get()
                    ->each(function ($sub_filter) {
                        $sub_filter->forceDelete();
                    });

                $filter->products()->detach();
                $filter->subAccounts()->detach();
            } else {
                // to delete all sub filters of filter
                $filter->subFilters()->get()
                    ->each(function ($sub_filter) {
                        $sub_filter->delete();
                    });
            }
        });


        static::restoring(function (Filter $filter) {

            // to restore all sub filters of filter
            $filter->subFilters()->onlyTrashed()->get()
            ->each(function ($sub_filter) {
                $sub_filter->restore();
            });
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class FilterRecurring extends Model
{
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['name'];

    protected $table = 'filters_recurring';
    public $timestamps = true;


    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'filter_type_id','image');

    public function filters()
    {
        return $this->hasMany('App\Models\Filter', 'filter_recurring_id');
    }

    public function subFiltersRecurring()
    {
        return $this->hasMany('App\Models\SubFilterRecurring');
    }

    public function subAccounts()
    {
        return $this->belongsToMany('App\Models\SubAccount', 'filter_recurring_sub_accounts');
    }

    public function filterType()
    {
        return $this->belongsTo('App\Models\FilterType');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_filter_recurring')->using(CategoryFilterRecurring::class);
    }


    public static function boot()
    {
        parent::boot();

        self::deleting(function (FilterRecurring $recurring_filter) {
            if ($recurring_filter->forceDeleting) {
                if ($recurring_filter->image) {
                    \Storage::disk('s3')->delete('uploads/RecuringFilter/'.$recurring_filter->image);
                }
                // to delete all filters of recurring_filter
                $recurring_filter->categories()->detach();

                // to delete all sub recurring_filters of recurring_filter
                $recurring_filter->subFiltersRecurring()->withTrashed()->get()
                    ->each(function ($sub_recurring_filter) {
                        $sub_recurring_filter->forceDelete();
                    });
            } else {

                    // to delete all sub recurring_filters of recurring_filter
                $recurring_filter->subFiltersRecurring()->get()
                    ->each(function ($sub_recurring_filter) {
                        $sub_recurring_filter->delete();
                    });
            }
        });


        static::restoring(function (FilterRecurring $recurring_filter) {

              // to restore all sub recurring_filters of recurring_filter
            $recurring_filter->subFiltersRecurring()->withTrashed()->get()
              ->each(function ($sub_recurring_filter) {
                  $sub_recurring_filter->restore();
              });
        });
    }
}

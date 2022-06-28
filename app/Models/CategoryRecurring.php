<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class CategoryRecurring extends Model
{
    use HasTranslations;

    public $translatable = ['name','description','text1','text2'];

    protected $table = 'categories_recurring';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name','description','text1','text2','image','view_id', 'is_all', 'position');


    public function recurringParents()
    {
        return $this->belongsTo('App\Models\CategoryRecurring', 'parent_id', 'id');
    }
    

    public function recurringChilds()
    {
        return $this->hasMany('App\Models\CategoryRecurring', 'parent_id', 'id');
    }


    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'category_recurring_id');
    }

    public function view()
    {
        return $this->belongsTo('App\Models\View', 'view_id');
    }

    public function subAccounts()
    {
        return $this->belongsToMany('App\Models\SubAccount', 'categories_recurring_sub_accounts');
    }

    public function getParentsNames()
    {
        $parents = collect([]);
    
        if ($this->recurringParents) {
            $parent = $this->recurringParents;
            while (!is_null($parent)) {
                $parents->push($parent);
                $parent = $parent->recurringParents;
            }
            return $parents;
        } else {
            return $this->name;
        }
    }
    
    public static function boot()
    {
        parent::boot();

        self::deleting(function (CategoryRecurring $category) {
            if ($category->forceDeleting) {
                foreach ($category->categories()->get() as $cat) {
                    $cat->subAccounts()->detach();
                    $cat->forceDelete();
                }

                foreach ($category->recurringChilds as $sub) {
                    // $sub->subAccounts()->detach();
                    $sub->forceDelete();
                }
            } else {
                foreach ($category->categories()->get() as $cat) {
                    $cat->delete();
                }

                foreach ($category->recurringChilds as $sub) {
                    $sub->delete();
                }
            }
        });


        static::restoring(function (CategoryRecurring $category) {
            $category->categories()->withTrashed()->get()
                ->each(function ($cat) {
                    $arr = array();
                    $cat->restore();
                    $category_ids = lastCategoriesIds($cat->id, $arr) ;
                    Product::whereIn('category_id', $category_ids)->onlyTrashed()->restore();
                });

            $category->recurringChilds()->withTrashed()->get()
                ->each(function ($sub) {
                    $sub->restore();
                });
        });
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return env('AWS_S3_URL').'/'.$value;
        } else {
            return asset('/uploads/avatar.png');
        }
    }
}

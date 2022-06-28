<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Category extends Model
{
    use HasTranslations,
        SearchableTrait;

    /**
     * @var array
     */
    protected $searchable = [

        'columns' => [
            'categories.name' => 100,
            'views.name'      => 20,

        ],
        'joins'   => [
            'views' => ['categories.view_id', 'views.id'],
        ],
    ];

    /**
     * @var array
     */
    public $translatable = ['name', 'description', 'text1', 'text2', 'text3'];

    /**
     * @var string
     */
    protected $table = 'categories';
    /**
     * @var array
     */
    protected $appends = ['view_name'];

    /**
     * @var mixed
     */
    public $timestamps = true;

    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = array('name', 'description', 'view_id', 'image', 'text1', 'text2', 'parent_id', 'is_all', 'category_recurring_id', 'position', 'text3');
    /**
     * @var array
     */
    protected $hidden = ['deleted_at', 'updated_at', 'created_at', 'category_recurring_id', 'pivot'];

    /**
     * @return mixed
     */
    public function getViewNameAttribute()
    {
        $view_name = $this->view()->where('id', $this->view_id)->pluck('name');

        return $view_name[0];
    }

    /**
     * @return mixed
     */
    public function parents()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    /**
     * @return mixed
     */
    public function organizationServices()
    {
        return $this->belongsToMany('App\Models\OrganizationServices', 'category_organization_service');
    }

    /**
     * @return mixed
     */
    public function childs()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * @return mixed
     */
    public function nestedChildren()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * @return mixed
     */
    // public function childrenRecursive()
    // {
    //     if (Auth::guard('api')->check()) {
    //         $user = User::find(Auth::guard('api')->user()->id);
    //         $sub_accounts_user_id = $user->subAccounts()->pluck('sub_account_id');
    //         $sub_accounts_category_id = CategorySubAccount::whereIn('sub_account_id', $sub_accounts_user_id)->pluck('category_id');
    //         return $this->childs()->with('childrenRecursive')->whereIn('id', $sub_accounts_category_id);

    //     } else {
    //         return $this->childs()->with('childrenRecursive');
    //     }
    // }

    /**
     * @return mixed
     */
    public function childrenRecursive()
    {
        return $this->childs()->with('childrenRecursive');
    }

    /**
     * @return mixed
     */
    public function view()
    {
        return $this->belongsTo('App\Models\View');
    }

    /**
     * @return mixed
     */
    public function categoryRecurring()
    {
        return $this->belongsTo('App\Models\CategoryRecurring', 'category_recurring_id');
    }

    /**
     * @return mixed
     */
    public function filters()
    {
        return $this->hasMany('App\Models\Filter');
    }

    /**
     * @return mixed
     */
    public function subAccounts()
    {
        return $this->belongsToMany('App\Models\SubAccount', 'category_sub_accounts');
    }

    /**
     * @return mixed
     */
    public function filterRecurrings()
    {
        return $this->belongsToMany('App\Models\FilterRecurring', 'category_filter_recurring');
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * @return mixed
     */
    public function getNestedChildrenIds()
    {
        $ids = [$this->id];

        $this->childrenRecursive->each(function ($category, $key) use (&$ids) {
            getNestedAttribute($category, 'id', 'childrenRecursive', $ids);
        });

        return $ids;
    }

    /**
     * @return mixed
     */
    public function getParentsNames()
    {
        $parents = collect([]);

        if ($this->parents) {
            $parent = $this->parents;
            while (!is_null($parent)) {
                $parents->push($parent);
                $parent = $parent->parents;
            }
            return $parents;
        } else {
            return $this->name;
        }
    }

    /**
     * @return mixed
     */
    public function getBreadcrumbsAttribute()
    {
        $parents = collect([]);

        if ($parent = $this->parents) {
            while (!is_null($parent)) {
                $parents->push($parent);
                $parent = $parent->parents;
            }
            $path = array_reverse($parents->pluck('name')->toArray());
            array_push($path, $this->name);
            return $path;
        } else {
            return $this->name;
        }
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Category $category) {
            if ($category->forceDeleting) {
                $category->subAccounts()->detach();

                foreach ($category->products()->withTrashed()->get() as $product) {
                    $product->forceDelete();
                }

                $category->filterRecurrings()->detach();

                $category->childs()->onlyTrashed()->get()
                         ->each(function ($sub) {
                             $sub->forceDelete();
                         });
            } else {
                foreach ($category->products()->get() as $product) {
                    $product->delete();
                }

                foreach ($category->childs as $sub) {
                    foreach ($sub->products()->get() as $product) {
                        $product->delete();
                    }
                    $sub->delete();
                }
            }
        });

        static::restoring(function (Category $category) {
            $category->childs()->onlyTrashed()->get()
                     ->each(function ($sub) {
                         $sub->restore();
                     });
        });
    }
}

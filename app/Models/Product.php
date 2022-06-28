<?php

namespace App\Models;

use App\Http\Resources\MediaCenterResource;
use App\Http\Resources\MediaResource;
use App\Notifications\SendOtpNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Znck\Eloquent\Traits\BelongsToThrough;

class Product extends Model implements HasMedia
{
    use BelongsToThrough;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasTranslations;
    use SearchableTrait;

    /**
     * @var array
     */
    public $translatable = ['note', 'name'];

    /**
     * @var array
     */
    public $with = ['media', 'medias'];

    /**
     * @var array
     */
    protected $searchable = [

        'columns' => [
            'products.name' => 100,
            'products.phone' => 100,
            'products.price' => 10,
            'products.quantity' => 10,
            'categories.name' => 20,
            'users.mobile' => 20,
            'users.email' => 20,

        ],
        'joins' => [
            'categories' => ['products.category_id', 'categories.id'],
            'users' => ['products.user_id', 'users.id'],
        ],
    ];

    use HasFactory;
    /**
     * @var string
     */
    protected $table = 'products';
    /**
     * @var mixed
     */
    protected $softDelete = true;
    /**
     * @var array
     */
    protected $appends = ['is_favorites'];
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var array
     */
    protected $dates = ['deleted_at', 'promote_to', 'date_old_position'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'note',
        'organization',
        'contact',
        'discount',
        'quantity',
        'user_id',
        'category_id',
        'city_id',
        'link',
        'price',
        'description',
        'byadmin',
        'position',
        'old_position',
        'longitude',
        'latitude',
        'organization_id',
        'city_name',
        'phone',
        'verify_phone',
        'pin_code',
        'rejected_reason',
        'images',
        'status',
        'username',
    ];

    /**
     * @var array
     */
    protected $nullable = [
        'marketer_code_id',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'deleted_at',

        'organization_id',

    ];

    /**
     * Register the media collections.
     *
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images');
    }

    /**
     * @param Media $media
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit('crop', 20, 20)
            ->performOnCollections('images');

        $this->addMediaConversion('medium')
            ->width(200)
            ->performOnCollections('images');

        // Perform a resize on every collection
        $this->addMediaConversion('large')
            ->width(500)
            ->performOnCollections('images');
    }

    /**
     * @var array
     */
    protected $casts = [
        'phone' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Product $product) {
            if ($product->forceDeleting) {
                foreach ($product->medias()->get() as $media) {
                    Storage::disk('s3')->delete($media->path);
                }

                $product->medias()->forceDelete();
                $product->favourites()->detach();
                $product->subFilters()->detach();
                $product->features()->detach();
            }
        });
    }

    /**
     * ----------------------------------------------------------------- *
     * --------------------------- Relations --------------------------- *
     * ----------------------------------------------------------------- *.
     */
    /**
     * @return mixed
     */
    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    /**
     * @return mixed
     */
    public function favourites()
    {
        return $this->belongsToMany('App\Models\User', 'product_favourite_user');
    }

    /**
     * @return mixed
     */
    public function features()
    {
        return $this->belongsToMany('App\Models\Feature');
    }

    /**
     * @return mixed
     */
    public function supFilter()
    {
        return $this->belongsToMany('App\Models\SubFilter', 'sub_filter_product');
    }

    /**
     * @return mixed
     */
    public function subFilters()
    {
        return $this->belongsToMany(SubFilterRecurring::class)
            ->wherePivotNull('deleted_at')
            ->using(ProductSubFilterRecurring::class);
    }

    /**
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * @return mixed
     */
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * @return mixed
     */
    public function subProperties()
    {
        return $this->belongsToMany('App\Models\SubProperty', 'product_sub_properties')->withPivot('price');
    }

    /**
     * @return mixed
     */
    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediaable');
    }

    /**
     * @return mixed
     */
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization')->with('media');
    }

    /*
     * ----------------------------------------------------------------- *
     * --------------------------- Accessors --------------------------- *
     * ----------------------------------------------------------------- *
     */

    /**
     * @return mixed
     */
    public function getImagesAttribute()
    {
        if (($images = $this->getMedia('images'))->count()) {
            return MediaCenterResource::collection($images->sortBy(function ($image) {
                return !$image->getCustomProperty('isFeatured', false);
            }));
        }

        return $this->medias->count()
        ? MediaResource::collection($this->medias->sortBy('position'))
        : [[
            'id' => 0,
            'original' => config('filesystems.disks.s3.url') . '/uploads/avatar.png',
            'large' => config('filesystems.disks.s3.url') . '/uploads/avatar.png',
            'medium' => config('filesystems.disks.s3.url') . '/uploads/avatar.png',
            'thumb' => config('filesystems.disks.s3.url') . '/upload  s/avatar.png',
            'order' => 1,
            'position' => 1,
            'is_featured' => true,
        ]];
    }

    /**
     * @return mixed
     */
    public function getFeaturedImageAttribute()
    {
        if ($this->getMedia('images')->count()) {
            return MediaCenterResource::make($this->getMedia('images', ['isFeatured' => true])->first());
        }

        return $this->medias->count()
        ? MediaResource::make($this->medias->sortBy('position')->first())
        : [
            'id' => 0,
            'original' => config('filesystems.disks.s3.url') . '/uploads/avatar.png',
            'large' => config('filesystems.disks.s3.url') . '/uploads/avatar.png',
            'medium' => config('filesystems.disks.s3.url') . '/uploads/avatar.png',
            'thumb' => config('filesystems.disks.s3.url') . '/uploads/avatar.png',
            'order' => 1,
            'position' => 1,
            'is_featured' => true,
        ];
    }

    /**
     * @return mixed
     */
    public function getFinalPriceAttribute($discount)
    {
        return $discount ? $this->price * $discount / 100 : $this->price;
    }

    /**
     * @return mixed
     */
    public function getDiscountAttribute($value)
    {
        if (blank($value)) {
            return;
        }

        return (string) $value;
    }

    public function getIsFavoritesAttribute()
    {
        if (Auth::guard('api')->check()) {
            $statusFavorites = $this->favourites()->where('user_id', Auth::guard('api')->user()->id)->where('status', '!=', 0)->first();
            if ($statusFavorites) {
                return "true";
            } else {
                return "false";
            }
        }
    }

    /*
     * ----------------------------------------------------------------- *
     * ---------------------------- Mutators --------------------------- *
     * ----------------------------------------------------------------- *
     */

    /**
     * @return void
     */
    public function setImagesAttribute($images)
    {
        uploadMedia($this, $images);
    }

    /*
     * ----------------------------------------------------------------- *
     * ----------------------------- Scopes ---------------------------- *
     * ----------------------------------------------------------------- *
     */

    /**
     * Scope a query to get all product which belongs to the given category or one of it's children.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @param  string                                  $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategory($query, $categoryId)
    {
        return $query->whereIn(
            'category_id',
            optional(Category::with(['childrenRecursive'])->find($categoryId))->getNestedChildrenIds()
        );
    }

    /**
     * Scope a query to get all product which belongs to the given governorate or one of it's children.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @param  string                                  $governorateId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGovernorate($query, $governorateId)
    {
        return $query->whereHas('city', function ($query) use ($governorateId) {
            $query->where('governorate_id', $governorateId);
        });
    }

    /**
     * Scope a query to get all product where price between range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @param  string                                  $governorateId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePriceRange($query, string $range)
    {
        $range = explode('-', $range);

        return $query->where(function ($query) use ($range) {
            $query->whereBetween('price', [$range[0], $range[1]]);
        });
    }

    /**
     * Scope a query to get all product where price between range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @param  string|array                            $subFilters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubFilters($query, $subFilters)
    {
        if (is_string($subFilters)) {
            $subFilters = explode(',', $subFilters);
        }

        $query->whereHas('subFilters', function ($query) use ($subFilters) {
            $query->whereIn('sub_filter_recurring_id', $subFilters);
        });
    }

    /**
     * Scope a query to get all product where city.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @param  string                                  $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCity($query, $id)
    {
        $query->where('city_id', $id);
    }

    /**
     * Scope a query to get all products which Favorite by auth user or given id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder   $query
     * @param  string                                  $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFavoriteBy($query, $id = 'me')
    {
        if ($id === 'me') {
            $id = optional(auth('api')->user())->id;
        }

        $query->whereHas('favourites', function ($q) use ($id) {
            $q->where('user_id', $id)->where('status', 1);
        });
    }

    /*
     * ----------------------------------------------------------------- *
     * ------------------------------ Misc ----------------------------- *
     * ----------------------------------------------------------------- *
     */

    /**
     * Send the mobile verification notification.
     *
     * @return void
     */
    public function sendOtpNotification($code = null, $message = null)
    {
        $this->notify(new SendOtpNotification($code, $message));
    }
}

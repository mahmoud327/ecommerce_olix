<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\SendOtpNotification;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */

        'columns' => [
            'users.name'   => 100,
            'users.email'  => 10,
            'users.mobile' => 20,

        ],
    ];

    protected $table = 'users';

    /**
     * @var array
     */
    protected $appends = ['account_type', 'token'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'mobile',
        'mobile_type',
        'fcm_token',
        'organization_id',
        'image',
        'lang',
        'activate',
        'created_at',
        'pin_code',
        'verify_phone',
        'email',
        'marketer_code_id',
        'points',

    ];

    // protected $nullable = [
    //     'marketer_code_id',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return mixed
     */
    public function getAccountTypeAttribute()
    {
        $accountType = $this->subAccounts()->orderBy('id', 'desc')->where('user_id', $this->id)->first();

        if ($accountType) {
            return $accountType->name;
        } else {
            return "null";
        }
    }

    /**
     * @return mixed
     */
    public function getTokenAttribute()
    {
        $user = User::where('id', $this->id)->first();
        $token = $user->createToken('authToken')->accessToken;
        if ($token) {
            return $token;
        } else {
            return "null";
        }
    }

    /**
     * @return mixed
     */
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization')->with('media');
    }

    /**
     * @return mixed
     */
    public function favourites()
    {
        return $this->belongsToMany('App\Models\Product', 'product_favourite_user');
    }

    // relation to get all save search of the user
    /**
     * @return mixed
     */
    public function searches()
    {
        return $this->belongsToMany('App\Models\Category', 'search_user');
    }

    /**
     * @return mixed
     */
    public function subAccounts()
    {
        return $this->belongsToMany('App\Models\SubAccount');
    }

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
    public function marketerCode()
    {
        return $this->belongsTo('App\Models\MarketerCode');
    }

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->belongsToMany('App\Models\Post', 'comments');
    }

    /**
     * @return mixed
     */
    public function likes()
    {
        return $this->belongsToMany('App\Models\Post', 'likes');
    }

    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    /**
     * @return mixed
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

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

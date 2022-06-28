<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFavouriteUser extends Model
{
    protected $table = 'product_favourite_user';
    public $timestamps = true;

    use SoftDeletes,HasFactory;

    protected $dates = ['deleted_at'];
    protected $fillable = array('user_id','product_id','status');


    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'product_favourite_user');
    }
}

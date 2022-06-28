<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SearchUser extends Model
{
    use SoftDeletes;


    protected $table = 'search_user';
    public $timestamps = true;
    protected $dates = ['deleted_at'];


    protected $fillable = array('user_id', 'category_id');
}

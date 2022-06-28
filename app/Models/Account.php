<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    protected $table = 'accounts';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name');

    public function subAccounts()
    {
        return $this->hasMany('App\Models\SubAccount');
    }
}

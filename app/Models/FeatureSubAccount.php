<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureSubAccount extends Model
{
    use SoftDeletes;

    protected $table = 'feature_sub_account';
    public $timestamps = true;


    protected $dates = ['deleted_at'];
    protected $fillable = array('feature_id', 'sub_account_id');
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubAccount extends Model
{
    protected $table = 'sub_accounts';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'account_id');

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }


    public function filters()
    {
        return $this->belongsToMany('App\Models\Filter', 'filter_sub_accounts');
    }


    public function features()
    {
        return $this->belongsToMany('App\Models\Feature');
    }


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_sub_accounts');
    }


    public function firltersRecurring()
    {
        return $this->belongsToMany('App\Models\FilterRecurring', 'filter_recurring_sub_accounts');
    }

    public function categoriesRecurring()
    {
        return $this->belongsToMany('App\Models\FilterRecurring', 'categories_recurring_sub_accounts');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;

class Feature extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use HasTranslations;



    public $translatable = ['name'];

    protected $table = 'features';
    public $timestamps = true;
    // protected $appends = ['is_status'];


    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name','product_id');


    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }
  
    public function subAccounts()
    {
        return $this->belongsToMany('App\Models\SubAccount');
    }


    // public function getIsStatusAttribute()
    // {
      
    //     // $sub_account =
        
    //     $status= $this->subAccounts()->get();
        
    //     // $status= $this->


    //     // whereHas('subAccounts',function ($q)
    //     //     {

    //     //         $q->whereIn('user_id',$this->user_id);


    //     //     })->tosql();

    //     if($status)
    //     {
    //         return "true";
    //     }

    //     else
    //     {
    //         return "false";
    //     }
      
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MarketerCode extends Model
{
    protected $table = 'marketer_codes';
    public $timestamps = true;
    protected $fillable = array('code');


    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
  
    public function user()
    {
        return $this->hasOne('App\Models\User');
    }
}

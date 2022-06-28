<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $table = 'services';
    public $timestamps = true;

    protected $fillable = array('name','price');

    public function organizationService()
    {
        return $this->belongsToMany('App\Models\OrganizationService')->withPivot('price');
        ;
    }
}

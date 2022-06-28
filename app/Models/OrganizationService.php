<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class OrganizationService extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $table = 'organization_services';
    public $timestamps = true;

    protected $fillable = ['name','image','links','phones','description','position','city_name','google_map_link','city_id'];

    protected $casts = [ 'phones' => 'array' ,'links'=>'array'];
        
    public function services()
    {
        return $this->belongsToMany('App\Models\Service')->withPivot('price');
        ;
    }


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'category_organization_service');
    }
    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}

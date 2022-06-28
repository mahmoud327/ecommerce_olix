<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\Translatable\HasTranslations;

class OrganizationType extends Model
{
    use HasTranslations,HasFactory;


    public $translatable = ['name'];

    protected $table = 'organization_types';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name');

    public function organizations()
    {
        return $this->hasMany('App\Models\Organization');
    }
}

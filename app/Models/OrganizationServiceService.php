<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrganizationServiceService extends Model
{
    // use HasFactory;
    
    protected $table = 'organization_service_service';
    public $timestamps = true;


    protected $fillable = array('service_id','organization_service_id','price');
}

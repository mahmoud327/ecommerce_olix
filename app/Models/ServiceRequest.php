<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ServiceRequest extends Authenticatable
{
    use HasFactory;
    protected $table = 'service_requests';
 
      
    protected $fillable = [
      'phone',
      'user_id',
      'message',
      'service_id',
      'organization_service_id'
      
  ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }

    public function organizationService()
    {
        return $this->belongsTo('App\Models\OrganizationService');
    }
}

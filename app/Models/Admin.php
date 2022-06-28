<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

use Laravel\Passport\HasApiTokens;
use Auth;

class Admin extends Authenticatable
{
    use  HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'admins';


    protected $fillable = [
        'name',
        'email',
        'password',
         'phone',
         'image',
         'activate',
        'created_at',
        'roles_name'
    ];

    protected $nullable = [
        'marketer_code_id',
        'organization_service_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'roles_name' => 'array',

    ];


    public function code()
    {
        return $this->belongsTo('App\Models\MarketerCode', 'marketer_code_id');
    }

    public function organizationService()
    {
        return $this->belongsTo('App\Models\OrganizationService');
    }
}

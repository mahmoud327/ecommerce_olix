<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UpgradeRequest extends Model
{
    protected $table = 'upgrade_requests';
    public $timestamps = true;

    use SoftDeletes;

    

    protected $dates = ['deleted_at'];

    protected $fillable = array(

        'name',
        'organization_name',
        'phone',
        'latitude',
        'longitude',
        'user_id',
        'sub_account_id',
        'category_id',
        'status',
        'organization_id'
    );

    protected $nullable = array(

        'note',
        'rejected_reason'

    );

    public function medias()
    {
        return $this->morphMany('App\Models\Media', 'mediaable');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function subAccount()
    {
        return $this->belongsTo('App\Models\SubAccount');
    }
    
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization')->with('media');
    }
}

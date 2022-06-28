<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */

    protected $table = 'medias';
    protected $fillable = array( 'url', 'mediaable_id', 'mediaable_type','full_file','path', 'position', 'upload_key');
    public $timestamps = true;

    use SoftDeletes;



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'mediaable_type',
        'mediaable_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'url',
        // 'path'
    ];





    public function mediaable()
    {
        return $this->morphTo();
    }
}

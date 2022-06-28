<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Notification extends Model
{
    use HasTranslations;

    protected $table = 'notifications';

    public $translatable = ['title', 'content'];

    protected $dates = ['deleted_at'];

    public $timestamps = true;
    protected $fillable = array('title', 'content', 'notificationable_id', 'notificationable_type');

    public function notificationable()
    {
        return $this->morphTo();
    }
}

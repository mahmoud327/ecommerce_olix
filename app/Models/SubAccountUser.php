<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class SubAccountUser extends Pivot
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $table = 'sub_account_user';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('user_id', 'sub_account_id');
}

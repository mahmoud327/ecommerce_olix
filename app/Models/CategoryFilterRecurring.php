<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryFilterRecurring extends Pivot
{
    // use HasFactory;

    /**
     * @var string
     */
    protected $table = 'category_filter_recurring';
    /**
     * @var mixed
     */
    public $timestamps = true;

    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * @var array
     */
    protected $fillable = array('category_id', 'filter_recurring_id');
}

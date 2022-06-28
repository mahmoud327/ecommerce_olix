<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductSubFilterRecurring extends Pivot
{
    // use HasFactory;

    /**
     * @var string
     */
    protected $table = 'product_sub_filter_recurring';
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
    protected $fillable = array('product_id', 'sub_filter_recurring_id');
}

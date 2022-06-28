<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryRecurringSubAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "categories_recurring_sub_accounts";
}

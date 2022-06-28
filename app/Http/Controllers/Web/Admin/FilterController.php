<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\FilterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Account;
use App\Models\FilterRecurring;

use Illuminate\Support\Facades\Storage;

class FilterController extends Controller
{

    // function __construct()
    // {
  
    //     $this->middleware('permission:filters', ['only' => ['index']]);
    //     $this->middleware('permission:create_filter', ['only' => ['create','store']]);
    //     $this->middleware('permission:update_filter', ['only' => ['edit','update']]);
    //     $this->middleware('permission:delete_filter', ['only' => ['destroy']]);
  
    // }

    // to show all filters to spacifc category
    public function index($category_id)
    {
        $filters = FilterRecurring::whereHas('categories', function ($q) use ($category_id) {
            $q->where('category_filter_recurring.category_id', $category_id);
        })->get();

        return view('web.admin.filters.index', compact('filters', 'category_id'));
    }
}

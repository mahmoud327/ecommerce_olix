<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\SubFilterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubFilterRecurring;
use App\Models\Category;
use App\Models\Account;
use App\Models\Filter;
use Illuminate\Support\Facades\Storage;

class SubFilterController extends Controller
{
    // to show all filters to spacifc category
    public function index($filter_id)
    {
        $sub_filters = SubFilterRecurring::orderBy('id', 'desc')->where('filter_recurring_id', $filter_id)->get();
        return view('web.admin.filters.sub_filters.index', compact('sub_filters', 'filter_id'));
    }
}

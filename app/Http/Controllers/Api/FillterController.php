<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\SubAccount;
use App\Models\FilterRecurring;
use App\Models\SubFilterRecurring;
use App\Http\Controllers\Controller;
use App\Http\Resources\FilterResource;

class FillterController extends Controller
{

    /**
     * @param $cat_id
     * @param $tap
     */
    public function getFilters($cat_id, $tap)
    {
        if ($tap == 1) {
            $sub_account = SubAccount::where('name', 'like', '%' . 'personal' . '%')->pluck('id');
            $catgory = Category::find($cat_id);

            $filters = FilterRecurring::orderby('position', 'asc')->whereHas('categories', function ($q) use ($cat_id) {
                $q->where('category_filter_recurring.category_id', $cat_id);
            })->with(array('subFiltersRecurring' => function ($q) {
                $q->orderby('position');
            }))->get();

            if ($filters) {
                return sendJsonResponse(FilterResource::collection($filters), 'filters');
            } else {
                return sendJsonError('dont found  filter ');
            }
        } else {
            $catgory = Category::find($cat_id);
            if ($catgory) {
                $filters = FilterRecurring::orderby('position', 'asc')->whereHas('categories', function ($q) use ($cat_id) {
                    $q->where('category_filter_recurring.category_id', $cat_id);
                })->with(array('subFiltersRecurring' => function ($q) {
                    $q->orderby('position');
                }))->get();

                if ($filters) {
                    return sendJsonResponse(FilterResource::collection($filters), 'filters');
                } else {
                    return sendJsonError('dont found  filter ');
                }
            } else {
                return sendJsonError('dont found  catgory ');
            }
        }
    }

    public function getSubFilters()
    {
        $subFilters = SubFilterRecurring::orderby('position', 'asc')->all();
        return sendJsonResponse(SubFilterResource::collection($subFilters), 'filters');
    }
}

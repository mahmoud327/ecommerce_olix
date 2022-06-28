<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use Illuminate\Http\Request;
use App\Models\City;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

use Auth;

class CityController extends BaseApiController
{

    // to search in cities
    public function searchInCities(Request $request)
    {
        $cities = City::whereRaw('LOWER(`name`) like ?', ['%'.($request->name).'%'])->orwhere('name->ar', 'LIKE', '%'. $request->name .'%')->get();
        return $this->sendResponse(CityResource::collection($cities), 'cities', 200);
    }
}

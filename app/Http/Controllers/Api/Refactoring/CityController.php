<?php

namespace App\Http\Controllers\Api\Refactoring;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use ArinaSystems\JsonResponse\Facades\JsonResponse;

class CityController extends Controller
{

    // to search in cities
    /**
     * @param Request $request
     */
    public function searchInCities(Request $request)
    {
        $cities = (new QueryBuilder(City::with('governorate')))
            ->defaultSort('id')
            ->allowedSorts('id')
            ->allowedFilters([
                'name',
                AllowedFilter::scope('governorate'),
            ])
            ->get();

        return JsonResponse::json('ok', ['data' => CityResource::collection($cities)]);
    }
}

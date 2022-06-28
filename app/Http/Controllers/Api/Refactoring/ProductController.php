<?php

namespace App\Http\Controllers\Api\Refactoring;

use App\Models\Feature;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\FilterRecurring;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\Refactoring\ProductResource;
use ArinaSystems\JsonResponse\Facades\JsonResponse;
use App\Http\Resources\Refactoring\ProductDetailsResource;

class ProductController extends Controller
{
    /**
     * Count a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function count(Request $request)
    {
        $products = Product::query()
            ->where('status', "approve")
            ->with(['organization', 'city'])
            ->withCount(['favourites as is_favorite' => function ($query) {
                $query->whereUserId(optional(auth('api')->user())->id)
                      ->whereStatus(1);
            }]);

        $productsCount = (new QueryBuilder($products))
            ->defaultSort('-promote_to', '-position')
            ->allowedIncludes(['organization'])
            ->allowedSorts(['id', 'created_at', 'updated_at', 'price', 'promote_to', 'position'])
            ->allowedFilters([
                'name',
                'description',
                AllowedFilter::scope('category'),
                AllowedFilter::scope('governorate'),
                AllowedFilter::scope('price_range'),
                AllowedFilter::scope('sub_filters', null, false),
                AllowedFilter::scope('city'),
                AllowedFilter::scope('favorite_by'),
            ])
            ->count();

        return JsonResponse::json('ok', ['data' => ['count' => $productsCount]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('status', "approve")
            ->with(['city', 'city.governorate'])
            ->withCount([
                'favourites as is_favorite' => function ($query) {
                    $query->whereUserId(optional(auth('api')->user())->id)
                          ->whereStatus(1);
                },
                'favourites'                => function ($query) {
                    $query->whereStatus(1);

                },
            ]);

        $products = (new QueryBuilder($products))
            ->defaultSort('-promote_to', '-position')
            ->allowedIncludes(['organization'])
            ->allowedSorts(['id', 'created_at', 'updated_at', 'price', 'promote_to', 'position'])
            ->allowedFilters([
                'name',
                'description',
                AllowedFilter::scope('category'),
                AllowedFilter::scope('governorate'),
                AllowedFilter::scope('price_range'),
                AllowedFilter::scope('sub_filters', null, false),
                AllowedFilter::scope('city'),
                AllowedFilter::scope('favorite_by'),
            ])
            ->paginate($request->paginate);

        return JsonResponse::json('ok', ['data' => ProductResource::collection($products)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // abort_unless($product->status === 'approve', 404);

        $product->load(['user', 'organization', 'category', 'subFilters', 'subProperties'])
                ->loadCount(['favourites as is_favorite' => function ($query) {
                    $query->whereUserId(optional(auth('api')->user())->id)
                          ->whereStatus(1);
                }]);

        $product->username = $product->username ?? ($product->user_id
            ? ($product->organization_id ? optional($product->organization)->name : optional($product->user)->name)
            : 'suiiz');

        $product->user_image = $product->user_image ?? ($product->user_id
            ? ($product->organization_id
                ? config('filesystems.disks.s3.url') . '/' . (optional($product->organization)->media ? optional($product->organization->media)->path : 'uploads/avatar.png')
                : config('filesystems.disks.s3.url') . '/' . $product->user->image)
            : 'suiiz');

        $subFiltersIds = $product->subFilters->sortBy('position')->pluck('pivot.sub_filter_recurring_id')->toArray();

        $product->filters = FilterRecurring::orderby('position', 'asc')
            ->whereHas('categories', function ($q) use ($product) {
                $q->where('category_filter_recurring.category_id', $product->category_id);
            })
            ->with(array('subFiltersRecurring' => function ($q) use ($subFiltersIds) {
                $q->whereIn('id', $subFiltersIds)->orderby('position');
            }))
            ->get();

        $subPropertiesId = $product->subProperties->pluck('id');
        $propertiesId = $product->subProperties->pluck('property_id');
        $product->properties = Property::whereIn('id', $propertiesId)
            ->with(['subProperties' => function ($q) use ($subPropertiesId, $product) {
                $q->whereIn('id', $subPropertiesId)->with(['products' => function ($q) use ($product) {
                    $q->where('product_id', $product->id);
                }]);
            }])
            ->get();

        $product->features = Feature::get();

        return JsonResponse::json('ok', ['data' => ProductDetailsResource::make($product)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}

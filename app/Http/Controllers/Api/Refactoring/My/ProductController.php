<?php

namespace App\Http\Controllers\Api\Refactoring\My;

use App\Models\Feature;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\FilterRecurring;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Actions\Product\DeleteProduct;
use App\Actions\Product\UpdateProduct;
use Spatie\QueryBuilder\AllowedFilter;
use App\Actions\Product\CreateNewProduct;
use App\Http\Resources\Refactoring\ProductResource;
use ArinaSystems\JsonResponse\Facades\JsonResponse;
use App\Http\Resources\Refactoring\My\ProductDetailsResource;

class ProductController extends Controller
{
    /**
     * Count a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function count()
    {
        $products = Product::query()
            ->where('user_id', auth('api')->user()->id)
            ->withCount([
                'favourites as is_favorite' => function ($query) {
                    $query->whereUserId(optional(auth('api')->user())->id)
                          ->whereStatus(1);
                },
                'favourites'                => function ($query) {
                    $query->whereStatus(1);

                },
            ]);

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
                AllowedFilter::exact('status'),
            ])
            ->count();

        return JsonResponse::json('ok', ['data' => ['count' => $productsCount]]);
    }

    /**
     * Display the tmp resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTemp()
    {
        /**
         * @var \App\Models\User
         */
        $user = auth('api')->user();

        $product = $user->products()->whereStatus('temp')->firstOrFail();

        abort_unless($product->user_id === optional($user = auth('api')->user())->id, 404);

        $product->user = $user;

        $product->load(['category', 'user', 'organization', 'category.filterRecurrings', 'subFilters', 'subProperties'])
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
            ->whereHas('subFiltersRecurring', function ($q) use ($subFiltersIds) {
                $q->whereIn('id', $subFiltersIds);
            })
            ->with(array('subFiltersRecurring' => function ($q) use ($subFiltersIds) {
                $q->whereIn('id', $subFiltersIds)->orderby('position');
            }))
            ->get();

        $subPropertiesId = $product->subProperties->pluck('sub_property_id');
        $propertiesId = $product->subProperties->pluck('property_id');
        $product->properties = Property::whereIn('id', $propertiesId)
            ->with(['subProperties' => function ($q) use ($subPropertiesId, $product) {
                $q->whereIn('id', $subPropertiesId)->with(['products' => function ($q) use ($product) {
                    $q->where('product_id', $product->id);
                }]);
            }])
            ->get();

        $product->features = Feature::get();

        $product->row_images = $product->getMedia('images')->count() ? $product->images : [];

        return JsonResponse::json('ok', ['data' => ProductDetailsResource::make($product)]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('user_id', auth('api')->user()->id)
            ->with(['organization', 'city', 'city.governorate'])
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
            ->defaultSort('-position')
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
                AllowedFilter::exact('status'),
            ])
            ->paginate($request->paginate);

        return JsonResponse::json('ok', ['data' => ProductResource::collection($products)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tempProduct = optional(auth('api')->user())->products()->whereStatus('temp')->first();

        $tempProduct = !is_null($tempProduct)
        ? UpdateProduct::run($request->all() + ['product' => $tempProduct, 'byadmin' => false])
        : CreateNewProduct::run($request->all() + ['byadmin' => false, 'status' => 'temp']);

        $tempProduct->load(['city']);

        return JsonResponse::json('ok', ['data' => ProductDetailsResource::make($tempProduct)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        abort_unless($product->user_id === optional($user = auth('api')->user())->id, 404);

        $product->user = $user;

        $product->load(['category', 'user', 'organization', 'category.filterRecurrings', 'subFilters', 'subProperties'])
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
            ->whereHas('subFiltersRecurring', function ($q) use ($subFiltersIds) {
                $q->whereIn('id', $subFiltersIds);
            })
            ->with(array('subFiltersRecurring' => function ($q) use ($subFiltersIds) {
                $q->whereIn('id', $subFiltersIds)->orderby('position');
            }))
            ->get();

        $subPropertiesId = $product->subProperties->pluck('sub_property_id');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = UpdateProduct::run($request->all() + ['product' => $product, 'byadmin' => false, 'status' => $product->status]);

        $product->load(['city']);

        return JsonResponse::json('ok', ['data' => ProductDetailsResource::make($product)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product         $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        abort_unless(in_array($product->status, ['finished', 'temp']) && $product->user_id === optional(auth('api')->user())->id, 403);

        DeleteProduct::run(compact(['product']));

        return JsonResponse::json('ok', ['message' => __('lang.model_deleted', ['model' => 'product'])]);
    }
}

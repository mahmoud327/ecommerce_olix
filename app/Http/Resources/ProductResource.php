<?php

namespace App\Http\Resources;

use Auth;
use App\Models\Property;
use App\Models\Governorate;
use App\Models\ProductFavouriteUser;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\OrganizationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    /**
     * @param $request
     */
    public function toArray($request)
    {
        $cairo = Governorate::where('name', 'Cairo')->first();

        return
            [

            'success' => true,

            'data'    => $this->resource->transform(function ($item) use ($cairo) {
                if ($item->discount) {
                    $discount = $item->price * $item->discount / 100;
                    $priceAfterdiscount = $item->price - $discount;
                } else {
                    $priceAfterdiscount = null;
                }

                /*********** Start Query to the filters ***********/

                if (Auth::guard('api')->check()) {
                    $userProduct = ProductFavouriteUser::where('product_id', $item->id)->where('user_id', Auth::guard('api')->user()->id)->first();
                } else {
                    $userProduct = '';
                }
                /*********** End Query to the filters ***********/
                $subPropertiesId = $item->subProperties->pluck('pivot.sub_property_id');
                // $subPropertiesId = $item->subProperties->pluck('sub_property_id');
                $propertiesId = $item->subProperties->pluck('property_id');

                $properties = Property::whereIn('id', $propertiesId)->with(array('subProperties' => function ($q) use ($subPropertiesId, $item) {
                    $q->whereIn('id', $subPropertiesId)->with(array('products' => function ($q2) use ($item) {
                        $q2->where('product_id', $item->id);
                    }));
                }))->get();

                // $city =  City::whereRaw('LOWER(`name`) like ?', ['%'.($item->city_name).'%'])->orwhere('name->ar','LIKE', '%'. $item->city_name .'%')->first();

                // $subFiltersIds = $item->subFilters()->orderby('position', 'asc')->pluck('sub_filter_recurring_id');
                // $ids = $item->subFilters()->orderby('position', 'asc')->pluck('filter_recurring_id');

                // $filtersIds = FilterRecurring::whereIn('id', $ids)->where('name', 'LIKE', '%Year%')->orWhere('name', 'LIKE', '%Kilometers%')->pluck('id');

                // $filters = FilterRecurring::orderby('position', 'asc')->whereIn('id', $filtersIds)->with(array('subFiltersRecurring' => function($q) use ($subFiltersIds)
                // {
                //     $q->whereIn('id', $subFiltersIds)->orderby('position');

                // }))->get();
                if ($item->category) {
                    if ($item->category->parents->name != 'New') {
                        $created_at = $item->created_at;
                    } else {
                        $created_at = null;
                    }
                }
                return [
                    'id'               => $item->id,
                    'name'             => $item->name,
                    'username'         => $item->user ? $item->user->name : null,
                    'phone'            => $item->phone,
                    'organization'     => $item->organization ? new OrganizationResource($item->organization) : null,
                    'category_id'      => $item->category_id ? $item->category_id : null,
                    'category_name'    => $item->category ? $item->category->name : '',
                    'user_id'          => $item->user_id,
                    'contact'          => $item->contact,
                    'link'             => $item->link,
                    'discount'         => $item->discount ? (string) $item->discount : null,
                    'note'             => $item->note,
                    'price'            => (string) $item->price,
                    'total'            => $priceAfterdiscount ? (string) $priceAfterdiscount : null,
                    'created_at'       => $item->user_id == null ? null : $item->created_at,
                    'updated_at'       => $item->user_id == null ? null : $item->updated_at,
                    'is_favorites'     => $userProduct ? $userProduct->status == '0' ? 'false' : 'true' : 'false',
                    'city_id'          => $item->city_id,
                    'city_name'        => $item->city ? $item->city->name : 'null',
                    'created_at'       => $item->user_id == null ? ($created_at ?? now()) : $item->created_at,
                    'governorate_name' => $item->city ? optional($item->city->governorate)->name : optional($cairo)->name,
                    'verify_phone'     => (integer) $item->verify_phone,
                    // 'medias'           => $item->medias->count() ? MediaResource::collection(Media::where('mediaable_id', $item->id)->where('mediaable_type', 'App\Models\Product')->orderBy('position')->get()) : [$medias],
                    'properties'       => PropertyResource::collection($properties),

                    // 'filters'                   => FilterResource::collection($filters),
                    'images'           => $item->images,

                ];
            }),

            'meta'    => [
                // 'total' => $this->total(),
                'count'        => $this->count(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages'  => $this->lastPage(),
            ],

            'message' => 'success',

        ];
    }
    /**
     * @param $request
     * @param $response
     */
    public function withResponse($request, $response)
    {
        $jsonResponse = json_decode($response->getContent, true);
        unset($jsonResponse['links'], $jsonResponse['meta']);
        $response->setContent(json_encode($jsonResponse));
    }
}

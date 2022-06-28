<?php

namespace App\Http\Resources;

use Auth;
use App\Models\City;
use App\Models\Feature;
use App\Models\Property;
use App\Models\Governorate;
use App\Models\FilterRecurring;
use App\Models\ProductFavouriteUser;
use App\Http\Resources\FeaturResource;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\OrganizationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOfUserResource extends JsonResource
{

    /**
     * @param $request
     */
    public function toArray($request)
    {
        return [

            'success' => true,
            'data'    => $this->resource->transform(function ($item) {
                // $medias = ['full_file' => env('AWS_S3_URL') . '/uploads/avatar.png'];
                if ($item->discount) {
                    $discount = $item->price * $item->discount / 100;
                    $priceAfterdiscount = $item->price - $discount;
                } else {
                    $priceAfterdiscount = null;
                }

                $userProduct = ProductFavouriteUser::where('product_id', $item->id)->where('user_id', Auth::guard('api')->user()->id)->first();
                $subFiltersIds = $item->subFilters()->orderby('position', 'asc')->pluck('sub_filter_recurring_id');
                $filtersIds = $item->subFilters()->orderby('position', 'asc')->pluck('filter_recurring_id');
                $favourite = ProductFavouriteUser::where('product_id', $item->id)->where('status', 1)->count();

                $subPropertiesId = $item->subProperties()->pluck('sub_property_id');
                $propertiesId = $item->subProperties()->pluck('property_id');

                $filters = FilterRecurring::orderby('position', 'asc')->whereIn('id', $filtersIds)->with(array('subFiltersRecurring' => function ($q) use ($subFiltersIds) {
                    $q->whereIn('id', $subFiltersIds);
                }))->get();

                $properties = Property::whereIn('id', $propertiesId)->with(array('subProperties' => function ($q) use ($subPropertiesId) {
                    $q->whereIn('id', $subPropertiesId)->with(array('products' => function ($q2) {
                        $q2->where('product_id', $item->id);
                    }));
                }))->get();
                $city = City::whereRaw('LOWER(`name`) like ?', ['%' . ($item->city_name) . '%'])->orwhere('name->ar', 'LIKE', '%' . $item->city_name . '%')->first();
                $cairo = Governorate::where('name', 'LIKE', '%Cairo%')->first();

                return
                    [

                    'id'                        => $item->id,
                    'name'                      => $item->name,
                    'username'                  => $item->user ? $item->user->name : null,
                    'phone'                     => $item->phone,
                    'description'               => $item->description,
                    'organization'              => $item->organization ? new OrganizationResource($item->organization) : null,
                    'category_id'               => $item->category_id,
                    'category_name'             => $item->category ? $item->category->name : '',
                    'category_breadcrumbs_path' => optional($item->category)->breadcrumbs,
                    'user_id'                   => $item->user_id,
                    'status'                    => $item->status,
                    'contact'                   => $item->contact,
                    'link'                      => $item->link,
                    'discount'                  => $item->discount ? (string) $item->discount : null,
                    'note'                      => $item->note,
                    'price'                     => (string) $item->price,
                    'count_of_phone'            => (string) $item->count_phone,
                    'count_of_view'             => (string) $item->count_view,
                    'count_of_chat'             => (string) $item->count_chat,
                    'count_of_favourite'        => (string) $favourite,
                    'total'                     => $priceAfterdiscount ? (string) $priceAfterdiscount : null,
                    'created_at'                => $item->byadmin ? null : $item->created_at,
                    'updated_at'                => $item->byadmin ? null : $item->updated_at,
                    'is_favorites'              => $userProduct ? $userProduct->status == '0' ? 'false' : 'true' : 'false',
                    'city_id'                   => $item->city_id,
                    'city_name'                 => $item->city ? $item->city->name : 'null',
                    'governorate_name'          => $item->city ? $item->city->governorate->name : $cairo->name,
                    'verify_phone'              => (integer) $item->verify_phone,
                    // 'medias'             => $item->medias()->count() ? MediaResource::collection(Media::where('mediaable_id', $item->id)->where('mediaable_type', 'App\Models\Product')->orderBy('position')->get()) : [$medias],
                    'properties'                => PropertyResource::collection($properties),
                    'features'                  => FeaturResource::collection(Feature::all()),
                    'filters'                   => FilterResource::collection($filters),
                    'images'                    => $item->images,
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

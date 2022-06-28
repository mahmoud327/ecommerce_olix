<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Property;
use App\Models\Governorate;
use App\Models\ProductFavouriteUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\OrganizationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCreateResource extends JsonResource
{

    /**
     * @param $request
     */
    public function toArray($request)
    {
        if ($this->discount) {
            $discount = $this->price * $this->discount / 100;
            $priceAfterdiscount = $this->price - $discount;
        } else {
            $priceAfterdiscount = null;
        }

        if (Auth::guard('api')->check()) {
            $userProduct = ProductFavouriteUser::where('product_id', $this->id)->where('user_id', Auth::guard('api')->user()->id)->first();
        } else {
            $userProduct = '';
        }

        $subPropertiesId = $this->subProperties()->pluck('sub_property_id');
        $propertiesId = $this->subProperties()->pluck('property_id');

        $properties = Property::whereIn('id', $propertiesId)->with(array('subProperties' => function ($q) use ($subPropertiesId) {
            $q->whereIn('id', $subPropertiesId)->with(array('products' => function ($q2) {
                $q2->where('product_id', $this->id);
            }));
        }))->get();

        $city = City::whereRaw('LOWER(`name`) like ?', ['%' . ($this->city_name) . '%'])->orwhere('name->ar', 'LIKE', '%' . $this->city_name . '%')->first();

        $cairo = Governorate::where('name', 'LIKE', '%Cairo%')->first();

        return [

            'id'                        => $this->id,
            'name'                      => $this->name,
            'username'                  => $this->user ? $this->user->name : null,
            'phone'                     => $this->phone,
            'organization'              => new OrganizationResource($this->organization),
            'category_id'               => $this->category_id,
            'category_name'             => $this->category_name ?? optional($this->category)->name ?? '',
            'category_breadcrumbs_path' => $this->category_breadcrumbs_path,
            'user_id'                   => $this->user_id,
            'contact'                   => $this->contact,
            'link'                      => $this->link,
            'discount'                  => $this->discount ? (string) $this->discount : null,
            'note'                      => $this->note,
            'price'                     => (string) $this->price,
            'total'                     => $priceAfterdiscount ? (string) $priceAfterdiscount : null,
            'created_at'                => $this->byadmin ? null : $this->created_at,
            'updated_at'                => $this->byadmin ? null : $this->updated_at,
            'is_favorites'              => $userProduct ? $userProduct->status == '0' ? 'false' : 'true' : 'false',
            'city_id'                   => $this->city_id,
            'city_name'                 => $city ? $city->name : $this->city_name,
            'governorate_name'          => $city ? $city->governorate->name : $cairo->name,
            'verify_phone'              => (integer) $this->verify_phone,
            'properties'                => PropertyResource::collection($properties),
            'images'                    => $this->resource->images,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Category;
use App\Models\Property;
use App\Models\Governorate;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductOfCategoryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        //    $medias= ['full_file' =>env('AWS_S3_URL').'/uploads/avatar.png' ];

        $discount = $this->price * $this->discount / 100;
        $priceAfterdiscount = $this->price - $discount;

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
            'id'               => $this->id,
            'name'             => $this->name,
            'username'         => $this->user ? $this->user->name : null,
            'phone'            => $this->phone,
            'quantity'         => $this->quantity,
            'organization'     => new OrganizationResource($this->organization),
            'category_id'      => $this->category_id,
            'category_name'    => $this->category->name,
            'status'           => $this->status,
            'user_id'          => $this->user_id,
            'contact'          => $this->contact,
            'link'             => $this->link,
            'discount'         => $this->discount ? (string) $this->discount : null,
            'note'             => $this->note,
            'price'            => (string) $this->price,
            'total'            => $priceAfterdiscount ? (string) $priceAfterdiscount : null,
            'created_at'       => $this->byadmin ? null : $this->created_at,
            'updated_at'       => $this->byadmin ? null : $this->updated_at,
            'city_name'        => $this->city ? $this->city->name : 'null',
            'governorate_name' => $city ? $city->governorate->name : $cairo->name,
            // 'is_favorites'              => $this->favourites?'true':'false' ,
            // 'medias'           => $this->medias->count() ? Media::where('mediaable_id', $this->id)->where('mediaable_type', 'App\Models\Product')->orderBy('position')->get() : [$medias],
            // 'features'                  => $this->features,
            'images'           => $this->images,
            'properties'       => PropertyResource::collection($properties),

        ];
    }
}

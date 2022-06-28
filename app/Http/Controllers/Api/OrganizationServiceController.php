<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrganizationService;
use App\Models\Category;
use App\Models\City;
use App\Models\OrganizationServiceService;
use App\Http\Resources\OrganizationServiceResource;

use App\Http\Requests\Web\Admin\OrganizationServiceRequest;

class OrganizationServiceController extends Controller
{
  

    // to add an orgnization_type
    public function getOrganizationService(Request $request)
    {
        $organization_services = OrganizationService::orderby('position');

        if ($request->has('category_id')) {
            $arr = array();
            $last_categories_ids = lastCategoriesIds($request->category_id, $arr);

            $organization_services = $organization_services->where(function ($q) use ($last_categories_ids) {
                $q->whereHas('categories', function ($q2) use ($last_categories_ids) {
                    $q2->whereIn('category_id', $last_categories_ids);
                });
            });
        }


        //  if($request->has('city_name'))
        // {


        //  $city = City::whereRaw('(name like "%' . strtolower($request->city_name) . '%" or name->"$.ar" like "%' . strtolower($request->city_name) . '%")')->first();

        //     if($city)
        //     {
        //         $city_name_en = $city->getTranslation('name', 'en');
        //         $city_name_ar = $city->getTranslation('name', 'ar');

                
        //         $organization_services->where(function($q) use($city_name_en, $city_name_ar ){

        //             $organization_services = $q->where('city_name', 'LIKE', "%{$city_name_en}%")->orWhere('city_name', 'LIKE', "%{$city_name_ar}%");
                
        //         });

        //     }else
        //     {
        //         $organization_services->where(function($q) use($request){

        //             $organization_services = $q->where("city_name" ,"like", "%". $request->city_name ."%" )->orWhere('city_name', "like", "%". $request->city_name ."%" );

        //         });
                
        //     }
        // }

        if ($request->has('city_id')) {
            $organization_services->where(function ($q) use ($request) {
                $organization_services = $q->where('city_id', $request->city_id);
            });
        }
            
        if ($request->has('governorate_id')) {
            $citie_ids=City::where('governorate_id', $request->governorate_id)->pluck('id');
            $organization_services->where(function ($q) use ($citie_ids) {
                $products = $q->whereIn('city_id', $citie_ids);
            });
        }
           

       
        $organization_services = $organization_services->paginate(10);
         
        return response()->json(new OrganizationServiceResource($organization_services));
    }
}

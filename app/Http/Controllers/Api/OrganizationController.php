<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OrganizationResource;
use App\Http\Resources\OrganizationUserResource;
use App\Models\Organization;
use App\Models\Product;
use App\Models\Media;
use App\Models\User;
use App\Traits\mediaTrait;
use App\Http\Resources\ProductOfUserResource;

class OrganizationController extends Controller
{
    use mediaTrait;



    public function organizations(Request $request)
    {
        $Organizations = Organization::get();

        return sendJsonResponse(OrganizationResource::collection($Organizations), 'organization');
    }


    public function updateOrganization(Request $request)
    {
        if ($request->user()->organization) {
            if ($request->phones) {
                $request->user()->organization->update($request->all());
            } else {
                $request->user()->organization->phones= $request->user()->organization->phones;
                $request->user()->organization->update($request->all());
            }


            if ($request->hasFile('back_image')) {
                $request->user()->$organization->media ? $url = $request->user()->$organization->media()->first()->url : $url = null;
                Storage::disk('s3')->delete($url);

                $file_name = $request->file('back_image')->store('uploads/organiztions', 's3');
                Storage::disk('s3')->setVisibility($file_name, 'public');
                $request->user()->organization->background_cover = $file_name;

                $request->user()->organization->update();
            }

            if ($request->has('front_image')) {
                $request->user()->organization->media ? $url =  $request->user()->organization->media()->first()->url : $url = null;
                $request->user()->organization->media()->forceDelete();

                \Storage::disk('s3')->delete($url);

                $file_name = $request->file('front_image')->store('uploads/organiztions', 's3');
                \Storage::disk('s3')->setVisibility($file_name, 'public');


                $request->user()->organization->media()->create([

                  'url'       =>  $file_name,
                  'path'      =>  $file_name,
                  'full_file' =>'http://' .\Request::getHost() .''.$file_name,

                ]);
            }

            return sendJsonResponse('Success', 'Inserted successfully');
        }

        return sendJsonError('dont found organization for user');
    }



    public function getOrganizationUser(Request $request)
    {
        if ($request->user()->organization) {
            $Organization_user =$request->user()->organization;
            return sendJsonResponse(new OrganizationUserResource($Organization_user), 'organization_page');
        }

        return sendJsonError('dont found organization for user');
    }



    public function getOrgainzation($id)
    {
        $orgainzation = Organization::find($id);

        if ($orgainzation) {
            return sendJsonResponse(new OrganizationUserResource($orgainzation), 'organization_page');
        }

        return sendJsonError('dont found organization for user');
    }


    public function organizationProduct($id)
    {
        $organization_products=Product::where('organization_id', $id)->get();
        return sendJsonResponse(ProductOfUserResource::collection($organization_products), 'organization of products');
    }
}

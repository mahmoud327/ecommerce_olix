<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UpgradeRequest;
use App\Traits\mediaTrait;
use App\Models\Organization;

use Auth;

use Hash;
use URL;

class UpgradeRequestController extends BaseApiController
{
    use mediaTrait;

    public function upgrade_request(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'organization_name'      => 'required',
            'category_id'           => 'required|integer',
            'sub_account_id'         => 'required|integer',
            'phone'                 =>'required',
            'files'                 =>'required',
            'organization_id'       =>'integer'

        ]);

        $organiztions = Organization::get();


        foreach ($organiztions as  $organiztion) {
            if ($request->organization_name ==$organiztion->name) {
                return sendJsonError('organization_name is exits');
            }
        }
        if ($validator->fails()) {
            return sendJsonError($validator->errors(), '500');
            // return sendJsonError('Please make sure that the data entered is correct','409');
        }

        $upgrade_rqeuest                            = new UpgradeRequest;
        $upgrade_rqeuest->organization_name         = $request->organization_name;
        $upgrade_rqeuest->category_id               = $request->category_id;
        $upgrade_rqeuest->organization_id           = $request->organization_id;
        $upgrade_rqeuest->latitude                  = $request->latitude;
        $upgrade_rqeuest->longitude                 = $request->longitude;
        $upgrade_rqeuest->phone                     = $request->phone;
        $upgrade_rqeuest->user_id                   = Auth::guard('api')->user()->id;
        $upgrade_rqeuest->save();


        if ($request->has('files')) {
            $files = $request->file('files');

            foreach ($files as $file) {
                $file_name = $file->store('uploads/upgrade-requests', 's3');
                \Storage::disk('s3')->setVisibility($file_name, 'public');

                $upgrade_rqeuest->medias()->create([

                    'url'       =>  $file_name,
                    'path'      =>  $file_name,
                    'full_file' =>  $request->getSchemeAndHttpHost().$file_name,

                ]);
            }
        }

        return sendJsonResponse('Success', 'send successfully ');
    }
}

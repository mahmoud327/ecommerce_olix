<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisment;
use App\Models\ServiceRequest;

use App\Http\Resources\ProductOfUserResource;

class ServiceRequestController extends Controller
{
    public function serviceRequestStore(Request $request)
    {
        $lang = $request->header('x-localization');


        $validator = validator()->make($request->all(), [

          'service_id'        => 'integer',
          'phone'            => 'required',
          "message"          =>"required",


      ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '500');
        }

        if ($request->code) {
            $validator = validator()->make($request->all(), [

              'category_id'        => 'required|integer',
          ]);

            if ($validator->fails()) {
                return sendJsonError($validator->errors()->first(), '500');
            }


            $advertisment=Advertisment::where('category_id', $request->category_id)->first();


            if ($advertisment) {
                if ($advertisment->code==$request->code) {
                    $string = $lang == 'ar' ? "تم ارسال بنجاح" : "message has been sent";


                    return sendJsonResponse('Success', $string);
                } else {
                    $string_code = $lang == 'ar' ? "الكود غير صحيح" : "please check your code";

                    return sendJsonError($string_code);
                }
            } else {
                return sendJsonError('advertisment dont exist');
            }
        } else {
            $service_request               =new ServiceRequest;
            $service_request->phone        =$request->phone;
            $service_request->message      =$request->message;
            $service_request->user_id      =auth()->guard('api')->user()->id;
            $service_request->service_id   =$request->service_id;
            $service_request->organization_service_id   =$request->organization_service_id;

            $service_request->save();
            $sring = $lang == 'ar' ? "تم اضافة البيانات بنجاح" : "Add sucessfully";


            return sendJsonResponse('Success', $sring);
        }
    }
}

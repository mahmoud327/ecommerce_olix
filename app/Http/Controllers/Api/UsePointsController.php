<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;

class UsePointsController extends BaseApiController
{
    public function promoteProduct(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'product_id'                    =>'required|exists:products,id',
            'package_duration'              =>'required',
            'points'                        =>'required|numeric|min:0|not_in:0',

          ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }

        $user = auth()->guard('api')->user();

        if ($user->points >= $request->points) {
            $new_points = $user->points - $request->points;

            $product = Product::find($request->product_id);


            if ($user->update([ 'points'  =>  $new_points])) {
                if ($product->promote_to == null) {
                    $daysToAdd = $request->package_duration;
                    $date = Carbon::now()->addDays($daysToAdd);
                    $product->promote_to = $date;
                    $product->update();
                } else {
                    $daysToAdd = $request->package_duration;
                    $date = $product->promote_to->addDays($daysToAdd);
                    $product->promote_to = $date;
                    $product->update();
                }
            }

            $string_code = $lang == 'ar' ? "تم جعل المنتج في بداية الصفحة" : "the product has been promoted sucessfully";

            return $this->sendResponse(new UserResource($user), $string_code, 200);
        } else {
            return sendJsonError('There is not enough points');
        }
    }



    public function productRenewal(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'product_id'                    =>'required|exists:products,id',
            'package_duration'              =>'required',
            'points'                        =>'required|numeric|min:0|not_in:0',

        ]);

        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), 200);
        }

        $user = auth()->guard('api')->user();

        if ($user->points >= $request->points) {
            $new_points = $user->points - $request->points;

            $product = Product::find($request->product_id);
            $max_position = Product::where('category_id', $product->category_id)->max('position');


            if ($user->update([ 'points'  =>  $new_points])) {
                if ($product->date_old_position == null) {
                    $daysToAdd = $request->package_duration;
                    $date = Carbon::now()->addDays($daysToAdd);
                    $product->date_old_position = $date;
                    $product->old_position = $product->position;
                    $product->position = $max_position + 1;
                    $product->update();
                } else {
                    $daysToAdd = $request->package_duration;
                    $date = $product->date_old_position->addDays($daysToAdd);
                    $product->date_old_position = $date;
                    $product->old_position = $product->position;
                    $product->position = $max_position + 1;
                    $product->update();
                }
            }

            $string_code = $lang == 'ar' ? "تم تجديد المنتج بنجاح" : "the product has been renewaled sucessfully";

            return $this->sendResponse(new UserResource($user), $string_code, 200);
        } else {
            return sendJsonError('There is not enough points');
        }
    }
}

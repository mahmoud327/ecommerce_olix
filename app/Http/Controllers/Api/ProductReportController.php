<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReport;
use App\Http\Resources\AccountResource;

class ProductReportController extends BaseApiController
{
    public function product_reports(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'product_id'        => 'required|exists:products,id',
            'message'             => 'required',
            'select_message'             => 'required',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $product_report = new ProductReport();

        $product_report ->product_id       = (integer)$request->product_id;
        $product_report ->message        = $request->message;
        $product_report ->select_message        = $request->select_message;
        $product_report->user_id         =auth()->user()->id;

        $product_report->save();



        return $this->sendResponse($product_report, 'Report has been added succesfuly', 200);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complainment;
use App\Http\Resources\AccountResource;

class ComplainmentController extends BaseApiController
{
    public function complain(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'phone'        => 'required',
            'message'             => 'required',
            'name'             => 'required',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $complain = Complainment::create([

            "phone"       => $request->phone,
            "message"    => $request->message,
            "name"         => $request->name,

        ]);


        return $this->sendResponse($complain, 'Complain has been added succesfuly', 200);
    }
}

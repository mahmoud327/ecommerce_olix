<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Resources\AccountResource;

class ContactController extends BaseApiController
{
    public function contact(Request $request)
    {
        $lang = $request->header('x-localization');

        $validator = validator()->make($request->all(), [

            'phone'        => 'required',
            'message'             => 'required',
            'name'             => 'required',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $contact = Contact::create([

            "phone"       => $request->phone,
            "message"    => $request->message,
            "name"         => $request->name,

        ]);

        $string = $lang == 'ar' ? "تمت ارسال جهة الاتصال بنجاح " : "Contact has been added succesfuly";

        return $this->sendResponse($contact, $string, 200);
    }
}

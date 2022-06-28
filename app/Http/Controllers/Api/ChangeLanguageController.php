<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ChangeLanguageController extends BaseApiController
{
    public function change_language(Request $request)
    {
        if (Auth::guard('api')->check()) {
            $validator = validator()->make($request->all(), [

            'lang' =>'required',

        ]);


            if ($validator->fails()) {
                return sendJsonError('lang is required');
            }

            $user = User::where('id', Auth::guard('api')->user()->id)->first();
            $user->lang = $request->lang;
            $user->save();

            return sendJsonResponse('Success', 'send successfully ');
        } else {
            return sendJsonError('dont auth');
        }
    }
}

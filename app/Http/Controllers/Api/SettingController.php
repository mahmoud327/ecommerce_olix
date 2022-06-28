<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SettingResource;
use App\Models\Setting ;

class SettingController extends Controller
{
    public function setting(Request $request)
    {
        $settings=Setting::get();
        return sendJsonResponse(SettingResource::collection($settings), 'settings');
    }
}

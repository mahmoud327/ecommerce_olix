<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GovernorateResource;
use Illuminate\Http\Request;
use App\Models\Governorate;
use App\Models\City;
use Auth;

class GovernorateController extends BaseApiController
{
    
    // to get all governorates
    public function allGovernorates()
    {
        $governorates = Governorate::all();
        return $this->sendResponse(GovernorateResource::collection($governorates), 'all governorates', 200);
    }
}

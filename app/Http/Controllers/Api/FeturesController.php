<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Traits\mediaTrait;
use App\Models\User;
use App\Models\SubAccountUser;
use App\Models\FeatureSubAccount;
use App\Http\Resources\FeaturResource;
use Auth;

use App\Models\Feature;

class FeturesController extends Controller
{
    public function getFeatures()
    {
        $features = Feature::all();
        return sendJsonResponse(FeaturResource::collection($features), 'all_features');
    }
}

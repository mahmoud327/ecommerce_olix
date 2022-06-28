<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisment;
use App\Http\Resources\AdvertismentResource;

use App\Models\Media;
use App\Models\Category;

class AdvertismentController extends Controller
{
    public function getAdvertisment($category_id)
    {
        $advertisments=Advertisment::where('category_id', $category_id)->get();
        if ($advertisments->count()) {
            return sendJsonResponse(AdvertismentResource::collection($advertisments), 'advertisments');
        } else {
            return sendJsonError('dont found advertisments for  category_id ');
        }
    }
}

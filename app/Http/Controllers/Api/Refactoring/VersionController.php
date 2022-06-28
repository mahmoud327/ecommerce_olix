<?php

namespace App\Http\Controllers\Api\Refactoring;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Version\ListVersions;
use App\Http\Resources\Refactoring\VersionResource;
use ArinaSystems\JsonResponse\Facades\JsonResponse;

class VersionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $versions = ListVersions::run($request->all());

        return JsonResponse::json('ok', ['data' => VersionResource::collection($versions)]);
    }
}

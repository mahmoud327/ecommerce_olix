<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisment;
use App\Models\ServiceRequest;

use App\Http\Resources\ProductOfUserResource;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $service_requests=ServiceRequest::where('organization_service_id', auth()->user()->organization_service_id)->get();
      
        return view('web.admin.service_requests.index', compact('service_requests'));
    }
}

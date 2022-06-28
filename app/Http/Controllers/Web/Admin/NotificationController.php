<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function notification(Request $request)
    {
        $notifications  = Notification::where('is_read', 0)->where('notificationable_type', 'App\Models\Product')->orderBy('id', 'DESC')->take(25)->get();
        $response    = [
         'status'  => 1,
         'message' =>'success',
         'data'    => $notifications
       ];
        return response()->json($response);
    }
}

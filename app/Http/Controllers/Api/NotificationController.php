<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $notifications= $request->user()->notifications()->get();

        if ($notifications->count()) {
            return sendJsonResponse(NotificationResource::collection($notifications), ' notifications');
        } else {
            return sendJsonError('dont found  notifications for user');
        }
    }

    public function sendNotificationInChat(Request $request)
    {
        $receiver = User::find($request->receiver_id);


        if (! $receiver) {
            return sendJsonError('the receiver dose not exist');
        }

        $tokens = $receiver->fcm_token;

        if ($tokens) {
            $title = $request->product_name;
            $body = $request->message;
            $data = [

               'receiver_id'            => $request->receiver_id,
               'sender_id'            => $request->sender_id,
               'product_id'             => $request->product_id,
               'product_name'           => $request->product_name,
               'chat_room_id'           => $request->chat_room_id,
               'receiver_name'          =>$request->receiver_name,
               'message'                =>$request->message

            ];


            $send = notifyByFirebase($title, $body, (array)$tokens, $data);

            return sendJsonResponse(null, 'notifications has been send successfully.');
        }

        return sendJsonError('the resiver unauthrized');
    }
}

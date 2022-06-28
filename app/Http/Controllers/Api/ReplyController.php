<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReplyResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;
use App\Models\Post;
use Auth;

class ReplyController extends BaseApiController
{
    // to get replies of comment
    public function repliesOfComment($id)
    {
        $replies = Reply::where('comment_id', $id)->get();
        return $this->sendResponse(ReplyResource::collection($replies), 'succses', 200);
    }

    // to add a reply
    public function addReply(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'comment_id'        => 'required|exists:comments,id',
            'reply'             => 'required',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $user = Auth::guard('api')->user();
        $reply = Reply::create([

            "user_id"       => $user->id,
            "comment_id"    => $request->comment_id,
            "reply"         => $request->reply,

        ]);


        return $this->sendResponse(new ReplyResource($reply), 'reply has been added succesfuly', 200);
    }


    // to update a reply
    public function updateReply(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'reply_id'          => 'required|exists:replies,id',
            'reply'             => 'required',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $user = Auth::guard('api')->user();

        $reply = reply::find($request->reply_id);
        $post = Post::find($reply->comment->post_id);

        if ($user->organization_id == $post->organization_id && $reply->user->organization_id == $post->organization_id) {
            $reply->update([

                'reply'   => $request->reply
            ]);

            return $this->sendResponse(new ReplyResource($reply), 'reply has been updated succesfuly', 200);
        }

        if ($user->id == $reply->user_id) {
            $reply->update([

                'reply'   => $request->reply
            ]);

            return $this->sendResponse(new ReplyResource($reply), 'reply has been updated succesfuly', 200);
        }
        return $this->sendResponse(null, 'you can\'t update this reply', 200);
    }

    // to delete a reply
    public function deleteReply(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'reply_id'      => 'required|exists:replies,id',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $user = Auth::guard('api')->user();

        $reply = reply::find($request->reply_id);
        $post = Post::find($reply->comment->post_id);

        if ($user->organization_id == $post->organization_id && $reply->user->organization_id == $post->organization_id) {
            $reply->delete();
            return $this->sendResponse(null, 'reply has been deleted succesfuly', 200);
        }

        if ($user->id == $reply->user_id) {
            $reply->delete();
            return $this->sendResponse(null, 'reply has been deleted succesfuly', 200);
        }

        return $this->sendResponse(null, 'you can\'t delete this reply', 200);
    }
}

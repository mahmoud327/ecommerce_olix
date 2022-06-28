<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Auth;

class LikeController extends BaseApiController
{

    // to toggle a like
    public function like(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'post_id'      => 'required|exists:posts,id',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $post = Post::find($request->post_id);
        $user = Auth::guard('api')->user();

        $user->likes()->toggle($post);

        return $this->sendResponse(null, 'like is toggled', 200);
    }
}

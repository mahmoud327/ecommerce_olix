<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CommentResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Auth;

class CommentController extends BaseApiController
{
    // to get posts of organzation
    public function commentsOfPost($id)
    {
        $comments = Comment::where('post_id', $id)->get();
        return $this->sendResponse(CommentResource::collection($comments), 'succses', 200);
    }

    // to add a comment
    public function addComment(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'post_id'      => 'required|exists:posts,id',
            'comment'      => 'required',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $user = Auth::guard('api')->user();
        $comment = Comment::create([

            "user_id"  => $user->id,
            "post_id"  => $request->post_id,
            "comment"  => $request->comment,

        ]);


        return $this->sendResponse(new CommentResource($comment), 'comment has been added succesfuly', 200);
    }


    // to update a comment
    public function updateComment(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'comment_id'        => 'required|exists:comments,id',
            'comment'           => 'required',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $user = Auth::guard('api')->user();

        $comment = Comment::find($request->comment_id);
        $post = Post::find($comment->post_id);


        if ($user->organization_id == $post->organization_id && $comment->user->organization_id == $post->organization_id) {
            $comment->update([

                'comment'   => $request->comment
            ]);

            return $this->sendResponse(new CommentResource($comment), 'comment has been updated succesfuly', 200);
        }

        if ($user->id == $comment->user_id) {
            $comment->update([

                'comment'   => $request->comment
            ]);

            return $this->sendResponse(new CommentResource($comment), 'comment has been updated succesfuly', 200);
        }
        return $this->sendResponse(null, 'you can\'t update this comment', 200);
    }

    // to delete a comment
    public function deleteComment(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'comment_id'      => 'required|exists:comments,id',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $user = Auth::guard('api')->user();

        $comment = Comment::find($request->comment_id);
        $post = Post::find($comment->post_id);

        if ($user->organization_id == $post->organization_id && $comment->user->organization_id == $post->organization_id) {
            $comment->replies()->delete();
            $comment->delete();

            return $this->sendResponse(null, 'comment has been deleted succesfuly', 200);
        }

        if ($user->id == $comment->user_id) {
            $comment->replies()->delete();
            $comment->delete();

            return $this->sendResponse(null, 'comment has been deleted succesfuly', 200);
        }

        return $this->sendResponse(null, 'you can\'t delete this comment', 200);
    }
}

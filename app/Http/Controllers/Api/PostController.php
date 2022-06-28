<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\mediaTrait;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Post;

use Auth;

class PostController extends BaseApiController
{
    use mediaTrait;

    // to get posts of organzation
    public function postsOfOrganization($id)
    {
        $post = Post::with('comments')->where('organization_id', $id)->orderBy('id', 'DESC')->get();
        return $this->sendResponse(PostResource::collection($post), 'succses', 200);
    }

    // to add a post
    public function addPost(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'content'               => 'required',
            'organization_id'       => 'required',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $user = Auth::guard('api')->user();

        $post = $user->posts()->create([

            'content'           => $request->content,
            'organization_id'   => $user->organization_id,

        ]);

        if ($post) {
            if ($request->has('files')) {
                $files = $request->file('files');

                foreach ($files as $file) {
                    $file_name = $file->store('uploads/posts', 's3');
                    \Storage::disk('s3')->setVisibility($file_name, 'public');

                    $post->medias()->create([

                        'url'       =>  $file_name,
                        'full_file' =>  $request->getSchemeAndHttpHost().$file_name,
                        'path'      =>  $file_name

                    ]);
                }
            }

            return $this->sendResponse(new PostResource($post), 'succses', 200);
        }
    }

    // to update a post
    public function updatePost(Request $request)
    {
        $validator = validator()->make($request->all(), [

            'post_id'        => 'required|exists:posts,id',

        ]);


        if ($validator->fails()) {
            return sendJsonError($validator->errors()->first(), '409');
        }

        $user = Auth::guard('api')->user();

        $post = Post::find($request->post_id);

        if ($user->organization_id == $post->organization_id && $post->user->organization_id == $post->organization_id) {
            $post->update([

                'content'   => $request->content
            ]);

            if ($request->has('files')) {
                $files = $request->file('files');

                foreach ($files as $file) {
                    $file_name = $this->saveFile($file, '/posts');

                    $post->medias()->create([

                        'url'       =>  $file_name,
                        'full_file' =>  $request->getSchemeAndHttpHost().$file_name,
                        'path'      =>  $file_name

                    ]);
                }
            }


            return $this->sendResponse(new PostResource($post), 'post has been updated succesfuly', 200);
        }

        if ($user->id == $post->user_id) {
            $post->update([

                'content'   => $request->content
            ]);

            if ($request->has('files')) {
                $files = $request->file('files');

                foreach ($files as $file) {
                    $file_name = $this->saveFile($file, '/posts');

                    $post->medias()->create([

                        'url'       =>  $file_name,
                        'full_file' =>  $request->getSchemeAndHttpHost().$file_name,
                        'path'      =>  $file_name

                    ]);
                }
            }

            return $this->sendResponse(new PostResource($post), 'post has been updated succesfuly', 200);
        }
        return $this->sendResponse(null, 'you can\'t update this comment', 200);
    }

    // to delete a post
    public function deletePost(Request $request)
    {
        $post = Post::find($request->post_id);
        $comments_ids = Comment::where('post_id', $request->post_id)->pluck('id');
        $replies = Reply::whereIn('comment_id', $comments_ids);

        $post->medias()->forceDelete();
        $post->likes()->detach();
        $post->comments()->detach();
        $replies->delete();
        $post->forceDelete();

        return $this->sendResponse(null, 'deleted successfully.', 200);
    }
}

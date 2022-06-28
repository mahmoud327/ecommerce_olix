<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace'=>'Api'],function ()
{

    Route::group(['middleware' => 'auth:api'],function ()
    {
        // post routes
        Route::get('posts/{id}','PostController@postsOfOrganization');
        Route::post('add_post','PostController@addPost');
        Route::post('update_post','PostController@updatePost');
        Route::post('delete_post','PostController@deletePost');
        
        // like routes
        Route::post('like','LikeController@like');
        
        // comment routes
        Route::get('comments/{id}','CommentController@commentsOfPost');
        Route::post('add_comment','CommentController@addComment'); 
        Route::post('update_comment','CommentController@updateComment'); 
        Route::post('delete_comment','CommentController@deleteComment'); 
        
        // reply routes
        Route::get('replies/{id}','ReplyController@repliesOfComment');
        Route::post('add_reply','ReplyController@addReply'); 
        Route::post('update_reply','ReplyController@updateReply'); 
        Route::post('delete_reply','ReplyController@deleteReply'); 
    
    });
});
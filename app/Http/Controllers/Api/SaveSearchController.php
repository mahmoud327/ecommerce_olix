<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SaveSearcedResource;
use App\Models\SearchUser;
use App\Models\Category;
use App\Models\User;
use Auth;

class SaveSearchController extends Controller
{
    // to save search
    public function saveSearch(Request $request)
    {
        $lang = $request->header('x-localization');

        if (Category::where('id', $request->category_id)->count()) {
            $user = User::find(Auth::guard('api')->user()->id);
            $save_search = SearchUser::where('category_id', $request->category_id)->where('user_id', Auth::guard('api')->user()->id);


            if (!$save_search->count()) {
                if ($save_search->withTrashed()->count()) {
                    $save_search->restore();
                } else {
                    $user->searches()->attach($request->category_id);
                }
                return sendJsonResponse('The Search Saved Successfuly', 200);
            } else {
                SearchUser::where('category_id', $request->category_id)->where('user_id', Auth::guard('api')->user()->id)->delete();
                $string = $lang == 'ar' ? "تم حذف السيرش بنجاح" : "The Search deleted Successful";


                return sendJsonResponse($strin, 200);
            }
        } else {
            return sendJsonError('category dose not exist');
        }
    }
    // to delete save search
    public function deleteSaveSearch(Request $request)
    {
        $lang = $request->header('x-localization');

        $saved_search_for_this_user = SearchUser::where('id', $request->search_id)->where('user_id', Auth::guard('api')->user()->id);
        if ($saved_search_for_this_user->count()) {
            $saved_search_for_this_user->delete();
            $string = $lang == 'ar' ? "تم حذف السيرش بنجاح" : "The Search deleted Successful";


            return sendJsonResponse('Success', $string);
        } else {
            return sendJsonError('this search dose not exist');
        }
    }



    // to get all saved search
    public function allSavedSearch()
    {
        $saved_search_for_this_user =SearchUser::where('user_id', Auth::guard('api')->user()->id)->get();

        return sendJsonResponse(SaveSearcedResource::collection($saved_search_for_this_user), 'all saved search');
    }
}

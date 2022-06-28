<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Admin;
use App\Models\User;
use Auth;

class MarketerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:accounts', ['only' => ['index']]);
        $this->middleware('permission:create_account', ['only' => ['create','store']]);
        $this->middleware('permission:sub_account', ['only' => ['sub_account']]);
    }
    
    // to show all marketers
    public function index()
    {
        $marketers=Admin::where('marketer_code_id', '!=', null)->get();
        return view('web.admin.marketers.index', compact('marketers'));
    }

    // to show all users of marketer
    public function usersOfMarkaters($marketer_code_id=null)
    {
        $marketer_code_id = $marketer_code_id ? $marketer_code_id : Auth::guard('admins')->user()->marketer_code_id;

        if ($marketer_code_id == null) {
            $users=(array)null;
        } else {
            $users_ids = Product::where('marketer_code_id', $marketer_code_id)->pluck('user_id')->toArray();
            $users = User::whereIn('id', $users_ids)->get();
        }


        return view('web.admin.marketers.users', compact('users', 'marketer_code_id'));
    }

    // to show all users of marketer
    public function ProductsOfUsersOfMarkaters($marketer_code_id, $user_id)
    {
        $user_id = $user_id ? $user_id : Auth::guard('admins')->user()->id ;
        $products = Product::where('marketer_code_id', $marketer_code_id)->where('user_id', $user_id)->get();
        
        return view('web.admin.marketers.products', compact('products'));
    }
}

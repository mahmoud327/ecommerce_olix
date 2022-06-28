<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Requests\Web\Admin\AccountRequest;
use App\Http\Requests\Web\Admin\Account\UpdateAccount;

class AboutUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:accounts', ['only' => ['index']]);
        $this->middleware('permission:create_account', ['only' => ['create','store']]);
        $this->middleware('permission:sub_account', ['only' => ['sub_account']]);
    }
    
    public function getAboutUs()
    {
        $about_us=response()->view('web.admin.about_us.about_us');
        return   $about_us;
    }
}

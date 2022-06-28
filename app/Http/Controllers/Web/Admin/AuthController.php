<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use App\Models\Admin;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /// edit email
 

    // return login veiw
    public function login()
    {
        return view('web.admin.auth.login');
    }
    
    
    // checking if user is a client or an admin
    public function loginCheck(Request $request)
    {
        // dd($request->all());
        $rules = [
        'email'             =>'required',
        'password'             =>'required',
      ];

        $messages = [
        'email.required'    => 'يرجى إدخال اسم المستخدم',
        'password.required' => 'يرجى إدخال كلمة المرور'
      ];

        $this->validate($request, $rules, $messages);

        $credentials = [
        'email' => $request['email'],
        'password' => $request['password'],
    ];

        // Dump data
        //dd($credentials);

  
        $admin = Admin::where('email', $request->email)->first();
        // $users = user::get();

    
        if ($admin) {
            if ($admin->activate == 1) {
                if (auth()->guard('admins')->attempt($credentials)) {
                    //   session()->flash('sucess', 'تم تسجيل الدخول');

                    return redirect(route('admin.index'));
                } else {
                    //   flash()->error("حدث خطا فى البيانات");

                    return redirect(route('admin.login'));
                }
            } else {
                //   flash()->error("لايمكنك الدخول في الوقت الحالي");
                return back();
            }
        } else {
            //   flash()->error("البيانات غير صحيحة");

            return redirect(route('admin.login'));
        }
    }

 


    public function logout()
    {
        auth()->guard('admins')->logout();
        return redirect(route('admin.login'));
    }
}

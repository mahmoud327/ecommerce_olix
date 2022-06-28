<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MarketerCode;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use Hash;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admins', ['only' => ['index']]);
        $this->middleware('permission:create_admin', ['only' => ['create','store']]);
        $this->middleware('permission:update_admin', ['only' => ['edit','update']]);
        $this->middleware('permission:show_admin', ['only' => ['show']]);
        $this->middleware('permission:activate_admin', ['only' => ['admins.activate,admins.deactivate']]);
        $this->middleware('permission:delete_all_admin', ['only' => ['admins.delete_all']]);
        $this->middleware('permission:delete_admin', ['only' => ['destroy']]);
    }

    // to show all accounts
    public function index()
    {
        $admins = Admin::all();
        return view('web.admin.admins.index', compact('admins'));
    }

    // to add an account

    public function create()
    {
        $roles = Role::select('name')->get();
        return view('web.admin.admins.create', compact('roles'));
    }
  


    public function store(Request $request)
    {
        $rules = [
        'email'                   =>'required|unique:admins',
        'name'                   =>'required',
        'phone'                   =>'required|numeric',
        'password'                =>'required|confirmed',

      ];

        $messages = [
        'email.required' => 'يجب ادخال  الايميل',
        'name.required' => 'يجب ادخال  الاسم',
        'email.unique'   =>'الايميل  موجود بالفعل',

        'phone.required' =>'يجب ادخال رقم الهاتف',
        'phone.numeric' =>'يجب ان يكون الهاتف رقما',
        'password.required' =>'يجب ادخال كلمة المرور',
        'password.confirmed' =>'يجب تأكيد كلمة المرور',
      ];

        $this->validate($request, $rules, $messages);

        $request->merge(['password' => bcrypt($request->password)]);
        $admin = Admin::create($request->except(['is_marketer']));


        if ($request->is_marketer == "marketer") {
            $code = "S".$admin->name[0] . '#'  . Str::random(4);

            $marketer_code = MarketerCode::create([

            'code' => $code
          ]);

            $admin->marketer_code_id = $marketer_code->id;
            $admin->update();
        }

        if ($request->is_marketer == "organization_service") {
            $admin->organization_service_id=$request->organization_service;
            $admin->save();
        }
     


        $admin->assignRole($request->input('roles_name'));

        if ($request->has('image')) {
            $file_name = $request->file('image')->store('uploads/admins', 's3');
            \Storage::disk('s3')->setVisibility($file_name, 'public');
       
            $admin->image  = $file_name;
            $admin->save();
        }

        return back()->with('status', 'Added successfully.');
    }

    public function edit($id)
    {
        $admin=Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $adminRole = $admin->roles->pluck('name', 'name')->all();
      
        return view('web.admin.admins.edit', compact('admin', 'roles', 'adminRole'));
    }

    // to update an account
    public function update(Request $request, $id)
    {
        $admin=Admin::find($id);

        $rules = [
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required|email|unique:admins,email,'.$id,
        'password' =>'confirmed',
        'image'   =>'image|mimes:jpeg,png,jpg,gif,svg'
      ];

        $messages = [
        'name.required'        => 'ادخل الاسم',

        'email.required'        => 'ادخل البريد الالكتروني',
        'email.unique'          => ' هذا البريد يستخدمه شخص اخر',
        'password.confirmed'         => 'كلمة المرور غير متطابقة',
        'phone.required'   => 'التلفون مطلوب'
      ];

        $this->validate($request, $rules, $messages);

        $input = $request->all();

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = $request->except(['password']);
            // $input = array_except($input,array('password'));
        }
   
        $user = Admin::find($id);

        $user->update($input);

        if ($request->hasFile('image')) {
            \Storage::disk('s3')->delete($user->image);

            $file_name = $request->file('image')->store('uploads/admins', 's3');
            \Storage::disk('s3')->setVisibility($file_name, 'public');

            $admin->image = $file_name;
            $admin->update();
        }

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles_name'));
        $user->save();

        return back()->with('status', 'Added successfully.');
    }

 
    // to delete an admin
    public function destroy($id)
    {
        $admin = Admin::find($id);
        \Storage::disk('s3')->delete($admin->image);
        $admin->delete();

        return back()->with('status', '  deleted successfully');
    }


    // to deleteall an admin
    public function delete_all(Request $request)
    {
        if ($request->delete_all_id) {
            $delete_all_id = explode(",", $request->delete_all_id);

            if (in_array('on', $delete_all_id)) {
                array_shift($delete_all_id);
            }
            Admin::whereIn('id', $delete_all_id)->delete();
        }

        return back()->with('status', "Deleted successfully");
    }

    // approve post
    public function activate($id)
    {
        $admin = Admin::find($id);
        $admin->update(['activate' => 1]);
        flash()->success('تم تفعيل هذا الحساب');
        return back();
    }

    public function deactivate($id)
    {
        $admin = Admin::find($id);
        $admin->update(['activate' => 0]);
        flash()->success('تم تعطيل هذا الحساب ');
        return back();
    }
}

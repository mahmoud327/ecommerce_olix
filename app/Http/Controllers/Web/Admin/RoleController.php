<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */


    public function __construct()
    {
        $this->middleware('permission:roles', ['only' => ['index']]);
        $this->middleware('permission:create_role', ['only' => ['create','store']]);
        $this->middleware('permission:update_role', ['only' => ['edit','update']]);
        $this->middleware('permission:show_role', ['only' => ['show']]);
        $this->middleware('permission:delete_role', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('web.admin.roles.index', compact('roles'))->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $permission = Permission::get();
        return view('web.admin.roles.create', compact('permission'));
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ];

        $messages = [
            'name.unique'         => 'اسم الصلاحية موجود بالفعل',
            'name.required'           => 'اسم الصلاحية مطلوب',
            'permission.required'   => 'الصلاحيات مطلوب'
        ];

        $this->validate($request, $rules, $messages);

        $role = Role::create(['guard_name' => 'admins', 'name' => $request->input('name')]);

        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index');
        flash()->success('تمت الاضافة بنجاح');
    }
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                                     ->where("role_has_permissions.role_id", $id)->get();
        return view('web.admin.roles.show', compact('role', 'rolePermissions'));
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
                             ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')->all();
        return view('web.admin.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index');
        flash()->success("تم التعديل بنجاح");
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id, Request $request)
    {
        DB::table("roles")->where('id', $request->role_id)->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect()->route('roles.index');
    }

    
    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);


        Role::whereIn('id', $delete_all_id)->delete();

        return back()->with('status', "Deleted successfully");
    }
}

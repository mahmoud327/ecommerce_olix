<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Complainment;
use Hash;
use DB;

class ComplainmentController extends Controller
{
    public function index()
    {
        $complainments = Complainment::get();
        return view('web.admin.complainments.index', compact('complainments'));
    }

    public function destroy($id)
    {
        $complainments=Complainment::find($id);
        $complainments->delete();

        return back()->with('status', 'deleted successfully');
    }


    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        Complainment::whereIn('id', $delete_all_id)->delete();

        return back()->with('status', "Deleted successfully");
    }
}

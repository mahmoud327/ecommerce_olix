<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Contact;
use Hash;
use DB;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::get();
        return view('web.admin.contacts.index', compact('contacts'));
    }

    public function destroy($id)
    {
        $contact=Contact::find($id);
        $contact->delete();

        return back()->with('status', 'deleted successfully');
    }


    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        Contact::whereIn('id', $delete_all_id)->delete();

        return back()->with('status', "Deleted successfully");
    }
}

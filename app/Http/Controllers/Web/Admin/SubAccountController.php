<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\SubAccountRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubAccount;
use App\Models\Category;
use App\Models\Account;
use App\Models\Feature;
use App\Models\Filter;

class SubAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:sub_accounts', ['only' => ['index']]);
        $this->middleware('permission:create_sub_account', ['only' => ['create','store']]);
        $this->middleware('permission:update_sub_account', ['only' => ['update','edit']]);
        $this->middleware('permission:delete_sub_account', ['only' => ['destroy']]);
        $this->middleware('permission:sub_account_category_control_page', ['only' => ['category_control_page','change_categories']]);
        $this->middleware('permission:sub_account_feature_control_page', ['only' => ['change_features','feature_control_page']]);
        $this->middleware('permission:sub_account_filter_control_page', ['only' => ['change_filters','filter_control_page']]);
    }
    // to show sub account page
    public function index()
    {
        $sub_accounts = SubAccount::get();
        return view('web.admin.sub_accounts.index', compact('sub_accounts'));
    }



    // to add sub account page
    public function store(SubAccountRequest $request)
    {
        $account = new SubAccount;
        $account->name =  $request->name;
        $account->account_id = $request->account_id;
        $account->save();

        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }


    // to update sub account page
    public function update(SubAccountRequest $request, $id)
    {
        $account = SubAccount::find($id);
        $account->name =  $request->name;
        $account->account_id = $request->account_id;
        $account->update();

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

    // to delete sub account page
    public function destroy($id)
    {
        $account = SubAccount::find($id);
        $account->delete();
        session()->flash('delete', 'تم حذف سجل بنجاح ');
        return redirect()->back();
    }


    // to show filter control page
    public function filterControlPage($id)
    {
        $sub_account = SubAccount::find($id);
        $filters = Filter::all();
        // $filter = Filter::first();
        // return $filter->category()->first()->parents()->first();

        return view('web.admin.sub_accounts.filters', compact('filters', 'sub_account'));
    }

    // to change filters
    public function changeFilters(Request $request, $id)
    {
        $sub_account = SubAccount::find($id);
        
        $sub_account->filters()->sync($request->filters);
        
        session()->flash('edit', 'تم التعديل  بنجاح ');
        return redirect()->back();
    }


    // to show feature control page
    public function featureControlPage($id)
    {
        $sub_account = SubAccount::find($id);
        $features = Feature::all();
        return view('web.admin.sub_accounts.features', compact('features', 'sub_account'));
    }

    // to change features
    public function changeFeatures(Request $request, $id)
    {
        $sub_account = SubAccount::find($id);
        
        $sub_account->features()->sync($request->features);
        
        session()->flash('edit', 'تم التعديل  بنجاح ');
        return redirect()->back();
    }


    
    // to show category control page
    public function categoryControlPage($id)
    {
        $sub_account = SubAccount::find($id);
        $parent_categories = Category::where('parent_id', 0)->get();
        return view('web.admin.sub_accounts.categories', compact('parent_categories', 'sub_account'));
    }


    // to change categories
    public function changeCategories(Request $request, $id)
    {
        $sub_account = SubAccount::find($id);
        $sub_account->categories()->sync($request->categories);
        
        session()->flash('edit', 'تم التعديل  بنجاح ');
        return redirect()->back();
    }
}

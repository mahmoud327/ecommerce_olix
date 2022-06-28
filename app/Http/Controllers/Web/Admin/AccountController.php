<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Requests\Web\Admin\AccountRequest;
use App\Http\Requests\Web\Admin\Account\UpdateAccount;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:accounts', ['only' => ['index']]);
        $this->middleware('permission:create_account', ['only' => ['create','store']]);
        $this->middleware('permission:sub_account', ['only' => ['sub_account']]);
    }
    
    // to show all accounts
    public function index()
    {
        $accounts = Account::paginate(50);
        return view('web.admin.accounts.index', compact('accounts'));
    }

    // to add an account
    public function store(AccountRequest $request)
    {
        $account = new Account;
        $account->name = $request->name;
        $account->save();

        session()->flash('Add', 'تم اضافة سجل بنجاح ');
        return redirect()->back();
    }

    // to update an account
    public function update(AccountRequest $request, $id)
    {
        $account = Account::find($id);
        $account->name = $request->name;
        $account->update();

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

 
    // to delete an account
    public function destroy($id)
    {
        $account = Account::find($id);
        if ($account->subAccounts) {
            $account->subAccounts()->delete();
        }
        $account->delete();
        session()->flash('delete', 'تم حذف سجل بنجاح ');
        return redirect()->back();
    }


    // to show sub accounts of account
    public function subAccounts($id)
    {
        $account = Account::find($id);
        $sub_accounts = $account->subAccounts()->get();
        return view('web.admin.accounts.sub_accounts.sub_accounts_of_account', compact('account', 'sub_accounts'));
    }
}

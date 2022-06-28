<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubAccount;
use App\Http\Resources\AccountResource;

class AccountController extends BaseApiController
{
    public function getAccount()
    {
        $sub_accounts = SubAccount::get();
        return sendJsonResponse(SubAccountResource::collection($sub_accounts), 'sub_accounts');
    }
}

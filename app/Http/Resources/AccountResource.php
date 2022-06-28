<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SubAccountResource;
use App\Models\SubAccount;

class AccountResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sub_accounts=SubAccount::get();
        return [
                    'id'                    => $this->id,
                    'name'               => $this->name,
                    'sub_accounts'                  =>  SubAccountResource::collection($sub_accounts)

                ];
    }
}

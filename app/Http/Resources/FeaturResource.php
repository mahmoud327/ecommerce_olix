<?php

namespace App\Http\Resources;

use App\Models\Feature;
use App\Models\SubAccountUser;
use App\Models\FeatureSubAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class FeaturResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        // if (Auth::guard('api')->check() && blank($this->status)) {
        //     $sub_account_user_id = SubAccountUser::where('user_id', Auth::guard('api')->user()->id)->pluck('sub_account_id');
        //     // $sub_account_user_id = auth('api')->user()->subAccounts->pluck('id');

        //     $feature_sub_account = FeatureSubAccount::whereIn('sub_account_id', $sub_account_user_id)->pluck('feature_id');
        //     $features_id = Feature::whereIn('id', $feature_sub_account)->pluck('id');

        //     $this->status = in_array($this->id, json_decode($features_id)) ? 'true' : 'false';
        // }

        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'status' => $this->status ?? 'false',
        ];
    }
}

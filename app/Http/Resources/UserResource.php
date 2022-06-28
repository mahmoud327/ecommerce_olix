<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return   [
                         'id'               => $this->id,
                        'name'              => $this->name,
                        'email'             => $this->email,
                        'verify_phone'      => $this->verify_phone,
                        'mobile'            => $this->mobile,
                        'image'             => $this->image ? env('AWS_S3_URL').'/'.$this->image : env('AWS_S3_URL').'/uploads/avatar.png',
                        'account_type'      => $this->subAccounts ? optional($this->subAccounts->first())->name : null,
                        'token'             => $this->createToken('authToken')->accessToken,
                        'points'            => $this->points,
                    ];
    }
}

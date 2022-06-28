<?php

namespace App\Actions\Product;

use App\Jobs\SendOtpSms;
use App\Models\Product;
use App\Models\SubAccountUser;
use App\Models\FeatureSubAccount;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\WithAttributes;
use App\Notifications\User\ProductCreatedNotification;

class UpdateProduct
{
    use AsAction, WithAttributes;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'product'       => 'required',

            'name'          => 'required_if:place_product,true|nullable|string',
            'description'   => 'required_if:place_product,true|nullable|string',
            'username'      => 'required_if:place_product,true|string',
            'price'         => 'required_if:place_product,true|numeric',
            'latitude'      => 'required_if:place_product,true|string',
            'longitude'     => 'required_if:place_product,true|string',
            'contact'       => 'required_if:place_product,true|numeric',
            'link'          => 'nullable|string',
            'discount'      => 'nullable|numeric',
            'quantity'      => 'nullable|numeric',
            'note'          => 'nullable|string',
            'tap'           => 'required_if:place_product,true|in:1,2',
            'city_id'       => 'required_if:place_product,true|exists:cities,id',
            'category_id'   => 'required_if:place_product,true|exists:categories,id',
            'sub_filters'   => 'sometimes|nullable|array',
            'phones'        => 'nullable|array',
            'phones.*'      => 'string',

            'place_product' => 'boolean',
            'status'        => 'string',
            'byadmin'       => 'boolean',
            'user'          => 'sometimes',
        ];
    }

    /**
     * @param  $attributes
     * @return \App\Models\Product
     */
    public function handle($attributes)
    {
        $this->fill($attributes);
        $this->validateAttributes();

        $user = $this->get('user', auth('api')->user());
        $user->load('organization');

        // TODO: Separate User/Product mobile activations model/migration etc...

        if ($this->get('phones')) {
            $phone = convert2english(implode(" ", $this->get('phones')));

            if ($user->mobile != $phone) {
                $is_verified = Product::where('phone', 'LIKE', "%{$phone}%")
                    ->where('verify_phone', 1)
                    ->where('user_id', $user->id)
                    ->count();

                if (!$is_verified) {
                    $code = rand(1111, 9999);
                    $this->set('pin_code', $code);
                    $this->set('status', 'disapprove');
                    $this->set('verify_phone', 0);

                    dispatch(new SendOtpSms("Your code " . $code . " - Suiiz", $phone));
                }

            }

            $this->set('phone', (array) $phone);
        }

        $this->product->update($this->all() + [
            'name'              => ['en' => $this->get('name'), 'ar' => $this->get('name')],
            'status'            => $this->get('status'),
            'discount'          => $this->get('discount', 0),
            'quantity'          => $this->get('quantity'),
            'verify_phone'      => true,
            'user_id'           => optional($user)->id,
            'position'          => Product::max('position') + 1,
            'marketer_code_id'  => optional($user)->marketer_code_id,
            'organization_name' => $this->get('tap') == 1 ? 'personal' : 'company',
            'organization_id'   => optional($user->organization)->id,
        ]);

        $subAccounts = SubAccountUser::where('user_id', optional($user)->id)->pluck('sub_account_id');
        $subAccountsFeatures = FeatureSubAccount::whereIn('sub_account_id', $subAccounts)->pluck('feature_id');

        $this->product->features()->attach($subAccountsFeatures);

        blank($subFilters = $this->get('sub_filters')) ?: $this->product->subFilters()->sync($subFilters);

        if ($this->has('images')) {
            $this->product->update(['images' => $this->get('images')]);
        }

        $this->get('status') === 'temp' ?: $user->notify(new ProductCreatedNotification());

        return $this->product;
    }
}

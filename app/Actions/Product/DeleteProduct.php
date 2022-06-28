<?php

namespace App\Actions\Product;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\WithAttributes;

class DeleteProduct
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
            'product' => 'required',
        ];
    }

    /**
     * @param $attributes
     */
    public function handle($attributes)
    {
        $this->fill($attributes);
        $this->validateAttributes();

        $this->product->medias()->forceDelete();
        $this->product->subFilters()->detach();
        $this->product->delete();
    }
}

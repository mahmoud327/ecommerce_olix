<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFavouriteUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(0, 99999),
            "user_id"    => rand(0, 99999),
            "status"     => 1,
        ];
    }
}

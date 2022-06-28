<?php

namespace Database\Factories;
use App\Models\Organization;
use Illuminate\Support\Str;


use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{

    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'name' => $this->faker->name(),
            'description' => Str::random(10),

        ];
    }
}

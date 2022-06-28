<?php

namespace Database\Factories;
use App\Models\OrganizationType;


use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = OrganizationType::class;

    public function definition()
    {
        return [
            //
            'name' => $this->faker->name(),


        ];
    }
}

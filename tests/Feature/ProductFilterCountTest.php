<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Passport\Passport;

class ProductFilterCountTest extends TestCase
{

    ////test_get_countOfFilteredProducts_with_vaild_attribute
    public function test_get_countOfFilteredProducts_with_vaild_attribute_with_pass_data_in_body()
    {

        $mobile = '00112343' . rand(1111, 9999);
        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 1,
            'mobile'       => $mobile,

        ]);
        $product = Product::factory()->create([
            'name'        => "ggg",
            "description" => "ff",
            "price"       => 44,
            "category_id" => 79,
            'status'      => "approve",
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        Passport::actingAs($user);
        $data = ['category_id' => 2987];
        $response = $this->json('post', 'api/v1/product/count_of_filtered_products/', $data, ['Accept' => 'application/json']);
        $response->assertJsonStructure([
            "success",
            "data",
            "message",
        ]);

    }
    ////test_get_count_of_all_products is approve
    public function test_get_countOfFilteredProducts_with_vaild_attribute_without_data_in_body()
    {

        $mobile = '00112343' . rand(1111, 9999);
        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 1,
            'mobile'       => $mobile,

        ]);
        $product = Product::factory()->create([
            'name'        => "ggg",
            "description" => "ff",
            "price"       => 44,
            "category_id" => 79,
            'status'      => "approve",
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        Passport::actingAs($user);
        $data = ['category_id' => 2987];
        $response = $this->json('post', 'api/v1/product/count_of_filtered_products/', ['Accept' => 'application/json']);
        $response->assertJsonStructure([
            "success",
            "data",
            "message",
        ]);

    }

}

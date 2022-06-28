<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Passport\Passport;

class IncrementProductTest extends TestCase
{

    ////test_create_product_valid_attribute_without_send_phone
    public function test_increament_product_vaild_attribute()
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
            "category_id" => 2987,
            'status'      => "pennding",
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        Passport::actingAs($user);
        $data = ['keyword' => 'chat'];
        $response = $this->json('post', 'api/v1/product/increment/' . $product->id, $data, ['Accept' => 'application/json']);
        $response->assertJson([
            "success" => true,
            "data"    => "Update Successfully.",
            "message" => 200,
        ]);

    }
    ////test_create_product_valid_attribute_without_send_phone
    public function test_cant_increament_product_invaild_attribute()
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
            "category_id" => 2987,
            'status'      => "pennding",
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        Passport::actingAs($user);
        $response = $this->json('post', 'api/v1/product/increment/' . $product->id, ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => false,
            "message" => "you have to enter the keyword",
            "data"    => null,
        ]);

    }

    ////test_cant_get_product_details_invaild_attribute_invaild_product_id
    public function test_cant_increament_product_invaild_attribute_invaild_product_id()
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
            'status'      => "pennding",
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        Passport::actingAs($user);

        $response = $this->json('post', 'api/v1/product/increment/' . $mobile, ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => false,
            "message" => "product dose not exist",
            "data"    => null,
        ]);

    }

}

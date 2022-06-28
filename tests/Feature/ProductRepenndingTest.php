<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Passport\Passport;

class ProductRepenndingTest extends TestCase
{

    ////test repennding product when verify_phone is_equal 1
    public function test_repennding_product_valid_attribute()
    {

        $mobile = '00112343' . rand(1111, 9999);
        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 1,
            'mobile'       => $mobile,

        ]);
        $product = Product::factory()->create([
            'name'         => "ggg",
            "description"  => "ff",
            "price"        => 44,
            "category_id"  => 79,
            'status'       => "finished",
            "city_id"      => 1,
            'user_id'      => $user->id,
            "verify_phone" => 1,

        ]);
        Passport::actingAs($user);
        $response = $this->json('post', 'api/v1/product/approve/' . $product->id, ['Accept' => 'application/json']);
        $response->assertJsonStructure([
            'success',
            'data' => [

                "id",
                "name",
                "username",
                "phone",
                "organization",
                "category_id",
                "category_name",
                "user_id",
                "contact",
                "link",
                "discount",
                "note",
                "price",
                "total",
                "created_at",
                "updated_at",
                "is_favorites",
                "city_id",
                "city_name",
                "governorate_name",
                "images",
                "properties",
            ],
            "message",
        ]);

    }

    ////test repennding product with invalid attribute
    public function test_cant_repennding_product_invalid_attribute()
    {

        $mobile = '00112343' . rand(1111, 9999);
        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 1,
            'mobile'       => $mobile,

        ]);
        $product = Product::factory()->create([
            'name'         => "ggg",
            "description"  => "ff",
            "price"        => 44,
            "category_id"  => 79,
            'status'       => "finished",
            "city_id"      => 1,
            'user_id'      => $user->id,
            "verify_phone" => 1,

        ]);
        Passport::actingAs($user);
        $response = $this->json('post', 'api/v1/product/approve/.00112343' . rand(1111, 9999), ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => false,
            "message" => "product not found ",
            "data"    => null,
        ]);
    }
    public function test_can_repennding_product_valid_attribute_with_verify_phone_zero()
    {

        $mobile = '00112343' . rand(1111, 9999);
        $code = rand(1111, 9999);

        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 1,
            'mobile'       => $mobile,

        ]);
        $product = Product::factory()->create([
            'name'         => "ggg",
            "description"  => "ff",
            "price"        => 44,
            "category_id"  => 79,
            'status'       => "finished",
            "city_id"      => 1,
            "phone"        => ['01123431046'],
            'user_id'      => $user->id,
            'pin_code'     => $code,
            "verify_phone" => 0,

        ]);
        Passport::actingAs($user);
        $response = $this->json('post', 'api/v1/product/approve/' . $product->id, ['Accept' => 'application/json']);

        $response->assertJsonStructure([
            'success',
            'data' => [

                "id",
                "name",
                "username",
                "phone",
                "organization",
                "category_id",
                "category_name",
                "user_id",
                "contact",
                "link",
                "discount",
                "note",
                "price",
                "total",
                "created_at",
                "updated_at",
                "is_favorites",
                "city_id",
                "city_name",
                "governorate_name",
                "images",
                "properties",
            ],
            "message",
        ]);

    }

}

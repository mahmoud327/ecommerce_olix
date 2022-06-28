<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Passport\Passport;

class ProductDetailsTest extends TestCase
{

    public function test_get_product_details_vaild_attribute()
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

        $response = $this->json('get', 'api/v1/product/productdetails/' . $product->id, ['Accept' => 'application/json']);
        $response->assertJsonStructure([
            'success',
            'data' => [
                "id",
                "name",
                "username",
                "user_image",
                "quantity",
                "count_of_view",
                "organization",
                "category_id",
                "category_name",
                "status",
                "user_id",
                "contact",
                "link",
                "discount",
                "description",
                "note",
                "price",
                "total",
                "created_at",
                "updated_at",
                "city_name",
                "governorate_name",
                "is_favorites",
                "images",
                "features",
                "filters",
                "properties",
            ],

            'message',
        ]);
    }

    ////test_cant_get_product_details_invaild_attribute
    public function test_cant_get_product_details_invaild_attribute()
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

        $response = $this->json('get', 'api/v1/product/productdetails/invalid-id', ['Accept' => 'application/json']);
        $response->assertStatus(500);
    }
}

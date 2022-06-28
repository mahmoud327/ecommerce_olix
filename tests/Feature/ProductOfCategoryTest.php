<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Passport\Passport;

class ProductOfCategoryTest extends TestCase
{

    ////test_create_product_valid_attribute_without_send_phone
    public function test_cant_get_product_of_category_with_invaild_attribute()
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
        $response = $this->json('get', 'api/v1/product/' . $product->category_id, ['Accept' => 'application/json']);
        $response->assertJson([
            "success" => false,
            "message" => "category not found",
            "data"    => null,
        ]);

    }
    ////test_can_get_product_of_user_with_vaild_attribute_with_keyword_sort
    public function test_can_get_product_of_user_with_vaild_attribute_with_keyword_sort()
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

        $response = $this->json('get', 'api/v1/product/' . $product->category_id . '/' . 'Asc', ['Accept' => 'application/json']);
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
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
                    "verify_phone",
                    "images",
                    "properties",
                ],
            ],
            'meta' => [
                "count",
                "per_page",
                "current_page",
                "total_pages",
            ],
            'message',
        ]);

    }
    ////test_get_product_of_user_with_vaild_attribute and send keyoreds in body
    public function test_get_product_of_user_with_vaild_attribute_with_keyword()
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

        $data = ['keyword' => 'approve'];
        $response = $this->json('post', 'api/v1/product/products_of_user/', $data, ['Accept' => 'application/json']);

        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
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
                    "count_of_phone",
                    "count_of_view",
                    "count_of_chat",
                    "count_of_favourite",
                    "total",
                    "created_at",
                    "updated_at",
                    "is_favorites",
                    "city_id",
                    "city_name",
                    "governorate_name",
                    "verify_phone",
                    "images",
                    "properties",
                    "features",
                ],
            ],
            'meta' => [
                "count",
                "per_page",
                "current_page",
                "total_pages",
            ],
            'message',
        ]);

    }

}

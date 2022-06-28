<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Passport\Passport;

class ProductsearchTest extends TestCase
{

    //get all_products_without_keywords
    public function test_get_product_serach_with_filter()
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
        $response = $this->json('post', 'api/v1/product/serach-with-filter', ['Accept' => 'application/json']);

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
    //get all_products_keywords_sort
    public function test_get_product_serach_with_filter_With_Sort_price()
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

        $data = ['sort' => 'desc'];
        $response = $this->json('post', 'api/v1/product/serach-with-filter', $data, ['Accept' => 'application/json']);
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

}

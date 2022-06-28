<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Passport\Passport;
use App\Models\ProductFavouriteUser;

class ProductFavouriteTest extends TestCase
{

    //test_product_is_favorute is valid attribute
    public function test_product_is_favourite()
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
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        Passport::actingAs($user);
        $data = ['product_id' => $product->id];
        $response = $this->json('POST', 'api/v1/product/addfavourite', $data, ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => true,
            "data"    => "Success",
            "message" => "add favourite",
        ]);

    }

    //test_product_is_favorute is invalid attribute cant_favourite

    public function test_product_is_invaild_attribute_cant_is_favourite()
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
            "city_id"     => 1,
            'user_id'     => rand(0, 99999),

        ]);
        Passport::actingAs($user);
        $data = ['product_id' => 'invalid-id'];
        $response = $this->json('POST', 'api/v1/product/addfavourite', $data, ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => false,
            "message" => "The selected product id is invalid.",
            "data"    => null,
        ]);

    }

    //delete favourite with valid attrribute
    public function test_product_is_vaild_attribute_delete_favourite()
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
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        $product_favourite = ProductFavouriteUser::factory()->create([
            'product_id' => $product->id,
            "user_id"    => $user->id,
            "status"     => 1,

        ]);

        Passport::actingAs($user);
        $data = ['product_id' => $product->id];
        $response = $this->json('POST', 'api/v1/product/deletefavourite', $data, ['Accept' => 'application/json']);
        $product = Product::where('id', $product)->first();
        $this->assertNotNull($user);

        $response->assertJson([
            "success" => true,
            "data"    => "Success",
            "message" => "delete favourite",
        ]);

    }

    //delete favourite with invalid attrribute
    public function test_product_is_invaild_attribute_cant_delete_favourite()
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
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        $product_favourite = ProductFavouriteUser::factory()->create([
            'product_id' => $product->id,
            "user_id"    => $user->id,
            "status"     => 1,

        ]);
        Passport::actingAs($user);
        $data = ['product_id' => rand(0, 99999)];
        $response = $this->json('POST', 'api/v1/product/deletefavourite', $data, ['Accept' => 'application/json']);

        $product = Product::where('id', $product)->first();
        $response->assertJson([
            "success" => false,
            "message" => "The selected product id is invalid.",
            "data"    => null,
        ]);

    }

    //test_product_dont_exist_favourite_product_cant_delete_favourite
    public function test_product_dont_exist_favourite_product_cant_delete_favourite()
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
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);

        Passport::actingAs($user);
        $data = ['product_id' => $product->id];
        $response = $this->json('POST', 'api/v1/product/deletefavourite', $data, ['Accept' => 'application/json']);
        $product = Product::where('id', $product)->first();
        $response->assertJson([
            "success" => false,
            "message" => "you didn't make favourite in this product",
            "data"    => null,
        ]);

    }
    ///test if exist product is_favourite
    public function test_product_is_vaild_attribute_all_favourite()
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
            'status'      => 'approve',
            "category_id" => 79,
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);
        $product_favourite = ProductFavouriteUser::factory()->create([
            'product_id' => $product->id,
            "user_id"    => $user->id,
            "status"     => 1,

        ]);

        Passport::actingAs($user);
        $response = $this->json('POST', 'api/v1/product/allfavourite', ['Accept' => 'application/json']);
        $product = Product::where('id', $product)->first();
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

    ///test if exist product dont_exists_is_favourite
    public function test_product_dont_exist__all_favourite()
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
            'status'      => 'approve',

            "category_id" => 79,
            "city_id"     => 1,
            'user_id'     => $user->id,

        ]);

        Passport::actingAs($user);
        $response = $this->json('POST', 'api/v1/product/allfavourite', ['Accept' => 'application/json']);
        $response->assertJson([
            "success" => false,
            "message" => "dont found product favourite",
            "data"    => null,
        ]);

    }

}

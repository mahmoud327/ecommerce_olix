<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Laravel\Passport\Passport;

class ProductTest extends TestCase
{

    ////test_create_product_valid_attribute_without_send_phone
    public function test_create_product_valid_attribute_without_send_phone()
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
        $data = ['city_id' => 1, 'category_id' => 3052, 'tap' => 1, 'price' => 12, 'name' => 'suiiz', 'contact' => 1];
        $response = $this->json('post', 'api/v1/product/create/', $data, ['Accept' => 'application/json']);
        $response->assertJsonStructure([
            "success",
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
                'verify_phone',
                "images",
                "properties",
            ],
            "message",
        ]);

    }

    ////test_create_product_valid_attribute_with_send_phone_veriy_phone_zero
    public function test_create_product_valid_attribute_with_send_phone_veriy_phone_zero()
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
            "verify_phone" => 0,
            'status'       => "pennding",
            "city_id"      => 1,
            'user_id'      => $user->id,

        ]);
        Passport::actingAs($user);
        $data = ['city_id' => 1, 'category_id' => 3052, 'tap' => 1, 'price' => 12, 'name' => 'suiiz', 'contact' => 1, 'phone' => ['0112343']];
        $response = $this->json('post', 'api/v1/product/create/', $data, ['Accept' => 'application/json']);
        $this->assertEquals(0, $product->verify_phone);

        $response->assertJsonStructure([
            "success",
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
                'verify_phone',
                "images",
                "properties",
            ],
            "message",
        ]);

    }

    ////test_create_product_valid_attribute_with_send_phone_veriy_phone_one
    public function test_create_product_valid_attribute_with_send_phone_veriy_phone_one()
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
            "verify_phone" => 1,
            'status'       => "pennding",
            "city_id"      => 1,
            'user_id'      => $user->id,

        ]);
        Passport::actingAs($user);
        $data = ['city_id' => 1, 'category_id' => 3052, 'tap' => 1, 'price' => 12, 'name' => 'suiiz', 'contact' => 1, 'phone' => ['0112343']];
        $response = $this->json('post', 'api/v1/product/create/', $data, ['Accept' => 'application/json']);

        $this->assertEquals(1, $product->verify_phone);

        $response->assertJsonStructure([
            "success",
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
                'verify_phone',
                "images",
                "properties",
            ],
            "message",
        ]);

    }

    ////test_create_product_valid_attribute_with_send_phone_veriy_phone_one
    public function test_cant_create_product_invalid_attribute()
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
            "verify_phone" => 1,
            'status'       => "pennding",
            "city_id"      => 1,
            'user_id'      => $user->id,

        ]);
        Passport::actingAs($user);
        $response = $this->json('post', 'api/v1/product/create/', ['Accept' => 'application/json']);

        $response->assertJsonStructure([
            "success",
            'data',
            "message",
        ]);

    }

    ////test_update_product_valid_attribute_without_send_phone
    public function test_update_product_valid_attribute_without_send_phone()
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
        $data = ['city_id' => 1, 'category_id' => 3052, 'tap' => 1, 'price' => 12, 'name' => 'suiiz', 'contact' => 1];
        $response = $this->json('post', 'api/v1/product/update/' . $product->id, $data, ['Accept' => 'application/json']);
        $response->assertJsonStructure([
            "success",
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
                'verify_phone',
                "images",
                "properties",
            ],
            "message",
        ]);

    }

    ////test_create_product_valid_attribute_with_send_phone_veriy_phone_one
    public function test_cant_update_product_invalid_attribute()
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
            "verify_phone" => 1,
            'status'       => "pennding",
            "city_id"      => 1,
            'user_id'      => $user->id,

        ]);
        Passport::actingAs($user);
        $response = $this->json('post', 'api/v1/product/update/' . $product->id, ['Accept' => 'application/json']);

        $response->assertJsonStructure([

            "success",
            'data',
            "message",
        ]);

    }

    //test_update_product_valid_attribute_with_send_phone_verify_phone_zero
    public function test_update_product_valid_attribute_with_send_phone_verify_phone_zero()
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
        $data = ['city_id' => 1, 'category_id' => 3052, 'tap' => 1, 'price' => 12, 'name' => 'suiiz', 'contact' => 1, 'phone' => ['0112343']];
        $response = $this->json('post', 'api/v1/product/update/' . $product->id, $data, ['Accept' => 'application/json']);

        $response->assertJsonStructure([
            "success",
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
                'verify_phone',
                "images",
                "properties",
            ],
            "message",
        ]);

    }
    //test_delete_product_valid_attribute
    public function test_delete_product_valid_attribute()
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
        $response = $this->json('delete', 'api/v1/product/delete/' . $product->id, ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => true,
            "data"    => "deleted",
            "message" => "deleted successfully.",
        ]);

    }
    //test_delete_product_invalid_attribute
    public function test_delete_product_invalid_attribute()
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
        $response = $this->json('delete', 'api/v1/product/delete/' . $mobile, ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => false,
            "message" => "dont found product",
            "data"    => null,
        ]);

    }

}

<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\ProductFavouriteUser;
use Illuminate\Support\Str;
use Tests\TestCase;
use Laravel\Passport\Passport;


use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class ProductFinishTest extends TestCase
{

    ////test finish product
    public function test_finish_product_valid_attribute()
    {

        $mobile = '00112343' . rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('123456'),
            "verify_phone"    =>1,
            'mobile'          => $mobile,

         ]);
        $product =Product::factory()->create([
            'name'           =>"ggg",
            "description"    =>"ff",
            "price"          =>44,
            "category_id"    =>79,
            'status'         =>"approve",
            "city_id"        =>1,
            'user_id'        => $user->id

         ]);
       Passport::actingAs($user);
       $response=  $this->json('post','api/v1/product/finished/'.$product->id, ['Accept' => 'application/json']);
        $response->assertJson([
            "success" => true,
            "data" => "Success",
            "message" => "Updated to Finished"
        ]);


    }

    ////test finish product with invaild attribute
    public function test_cant_finish_product_invalid_attribute()
    {

        $mobile = '00112343' . rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('123456'),
            "verify_phone"    =>1,
            'mobile'          => $mobile,

         ]);
        $product =Product::factory()->create([
            'name'           =>"ggg",
            "description"    =>"ff",
            "price"          =>44,
            "category_id"    =>79,
            'status'         =>"approve",
            "city_id"        =>1,
            'user_id'        => $user->id

         ]);
       Passport::actingAs($user);

       $response=  $this->json('post','api/v1/product/finished/'.'00112343'.rand(1111,9999), ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => false,
            "message" => "product not found ",
            "data" => null
        ]);


    }



}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Product;

use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class ReSendCodeProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_resend_code_for_user_with_vaild_attribute()
    {
        $mobile = '00112343' . rand(1111,9999);
        $code = rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>$mobile,
            "verify_phone"    =>1,
            "activate"        =>1,
            'pin_code'         =>$code

         ]);

         $product =Product::factory()->create([
            'name'           =>"ggg",
            "description"    =>"ff",
            "price"          =>44,
            'status'          =>'approve',
            "category_id"    =>79,
            "city_id"        =>1,
            "phone"       =>['01123431046'],
            'user_id'        =>$user->id,

         ]);

       $data = ['product_id' => $product->id];
       $response=  $this->json('post','api/v1/product/resend_product_verify_code', $data, ['Accept' => 'application/json']);
       $response->assertJson([
            "success" => true,
            "data" => "Success",
            "message" => "the new code has been sent successfully."
        ]);


    }
    public function test_product_resend_code_for_user_inwith_vaild_attribute_cant_resend()
    {
        $mobile = '00112343' . rand(1111,9999);
        $code = rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>$mobile,
            "verify_phone"    =>1,
            "activate"        =>1,
            'pin_code'         =>$code

         ]);

         $product =Product::factory()->create([
            'name'           =>"ggg",
            "description"    =>"ff",
            "price"          =>44,
            'status'          =>'approve',
            "category_id"    =>79,
            "city_id"        =>1,
            "phone"       =>['01123431046'],
            'user_id'        =>$user->id,

         ]);

       $data = ['product_id' =>  rand(0,99999)];
       $response=  $this->json('post','api/v1/product/resend_product_verify_code', $data, ['Accept' => 'application/json']);
       $response->assertJson([
            "success" => false,
            "message" => "The selected product id is invalid.",
            "data" => null,
        ]);


    }






}

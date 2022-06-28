<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Product;
use Tests\TestCase;
use Laravel\Passport\Passport;


use function PHPUnit\Framework\assertFalse;

class VerifyCodeProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_verify_code_for_user_with_vaild_attribute()
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
            'pin_code'         =>$code


         ]);

        Passport::actingAs($user);
       $data = ['product_id' => $product->id,'pin_code'=>$code];
       $response=  $this->json('post','api/v1/product/verify_code', $data, ['Accept' => 'application/json']);

       $response->assertJsonStructure([
        'success',
        'data' => [
            "id",
            "name",
            "phone",
            "username",
            "email",
            "note",
            "description",
            "quantity",
            "organization_name",
            "city_name",
            "category_id",
            "status",
            "user_id",
            "contact",
            "link",
            "discount",
             "price",
            "count_chat",
            "count_phone",
            "count_view",
             "city_id",
             "governorate_id",
             "position",
             "byadmin",
             "verify_phone",
             "pin_code",
             "longitude",
             "latitude",
             "rejected_reason",
             "marketer_code_id",
             "old_position",
            "promote_to",
            "date_old_position",
            "created_at",
            "updated_at",
            "is_favorites",
        ],
        "message"
      ]);



    }
    public function test_product_cant_verify_code_for_user_with_invaild_attribute()
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
            'pin_code'         =>$code


         ]);

        Passport::actingAs($user);
       $data = ['product_id' =>rand(1111,9999),'pin_code'=>rand(1111,9999)];
       $response=  $this->json('post','api/v1/product/verify_code', $data, ['Accept' => 'application/json']);

       $response->assertJson([
            "success" => false,
            "message" => "The selected pin code is invalid.",
            "data" => null,
        ]);


    }






}

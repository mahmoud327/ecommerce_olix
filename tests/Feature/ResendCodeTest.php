<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class ResendCodeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_user_with_vaild_attribute_can_resen_code()
    {
        $mobile = '00112343' . rand(1111,9999);
        $code = rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>$mobile,
            "verify_phone"    =>0,
            "activate"        =>0,
            'pin_code'         =>$code

         ]);
       $data = ['phone' => $mobile];
       $response=  $this->json('POST','api/v1/resend_user_verify_code', $data, ['Accept' => 'application/json']);
       $response->assertJson([
        "success" => true,
        "data" => "Success",
        "message" => "the new code has been sent successfully."
        ]);


    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    ///test user when account doestent_exists reset password

    ///test dont user donot exist
    public function test_dont_exist_user_cant_resend_code()
    {
        $mobile = '00112343' . rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>$mobile,
            "verify_phone"    =>0,
            "activate"        =>0,

         ]);

         $data = ['phone' => '44000055'];
         $response=  $this->json('POST','api/v1/resend_user_verify_code', $data, ['Accept' => 'application/json']);
          $response->assertJson([
            "success" => false,
            "message" => "account doest exist",
            "data" => null,
        ]);


    }


    public function test_user_with_invaild_attribute_cant_be_verify_code()
    {
        $mobile = '00112343' . rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>$mobile,
            "verify_phone"    =>0,
            "activate"        =>0,

         ]);

         $data = ['mobile' => $mobile];
         $response=  $this->json('POST','api/v1/verify_code', $data, ['Accept' => 'application/json']);
          $response->assertJson([
            "success" => false,
            "message" => "The pin code field is required.",
            "data" => null,
            ]);

    }

    public function test_dont_exist_user_with_invaild_attribute__verify_code()
    {
        $mobile = '00112343' . rand(1111,9999);
        $code = rand(1111,9999);

        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>$mobile,
            "verify_phone"    =>0,
            "activate"        =>0,
            'pin_code'         =>$code

         ]);

         $data = ['mobile' =>'111','pin_code'=>$code];
         $response=  $this->json('POST','api/v1/verify_code', $data, ['Accept' => 'application/json']);
          $response->assertJson([
            "success" => false,
            "message" => "Please check your code",
            "data" => null
            ]);

    }





}

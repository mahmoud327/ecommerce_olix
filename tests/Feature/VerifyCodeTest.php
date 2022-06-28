<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class VerifyCodeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    ///test user when account is_exists reset password
    public function test_user_with_vaild_attribute_can_verify_code()
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
       $data = ['mobile' => $mobile,'pin_code'=>$code];
       $response=  $this->json('POST','api/v1/verify_code', $data, ['Accept' => 'application/json']);
       $this->assertEquals($code,$user->pin_code);

       $response->assertJson([
        "success" => true,
        "data" => [
          "id" => $user->id,
          "name" => $user->name,
          "activate" => 1,
        ],
        "message" => "updated successfully"
    ]);


    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    ///test user when account doestent_exists reset password

    ///test dont user donot exist
    public function test_user_with_invaild_attribute_cant_verify_code()
    {
        $mobile = '00112343' . rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>$mobile,
            "verify_phone"    =>0,
            "activate"        =>0,

         ]);

         $data = ['mobile' => $mobile,'pin_code'=>'1111111'];
         $response=  $this->json('POST','api/v1/verify_code', $data, ['Accept' => 'application/json']);
          $response->assertJson([
            "success" => false,
            "message" => "Please check your code",
            "data" => null
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

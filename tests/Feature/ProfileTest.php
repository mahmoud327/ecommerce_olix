<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;
use Laravel\Passport\Passport;

use function PHPUnit\Framework\assertFalse;

class ProfileTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    ///test_update_name
    public function test_profile_update_name_user_can_update_profile()
    {
        $user =User::factory()->create([
            'password'        => bcrypt('123456'),
            "verify_phone"    =>1,

         ]);

       Passport::actingAs($user);
       $data = ['name' => 'mahmoud'];
       $response=  $this->json('POST','api/v1/update_profile', $data, ['Accept' => 'application/json']);

       $response->assertJson([
        "success" => true,
        "data" =>[
          "id" => $user->id,
          "name" =>$response->json('data.name'),
        ],
        "message" => "updated successfully",
        ]);

    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    //test_update_mobile_dnt_exists
    public function test_a_update_mobile_user_with_valid_attributes_can_update_profile()
    {
        $mobile = '00112343' . rand(1111,9999);

        $code = rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('123456'),
            "verify_phone"    =>0,
            "pin_code"        =>$code,
            'mobile'          =>  $mobile,

         ]);
         Passport::actingAs($user);

         $data = ['mobile' =>$mobile];
         $response=  $this->json('POST','api/v1/update_profile', $data, ['Accept' => 'application/json']);
         $response->assertJson([
            "success" => true,
            "data" =>[
              "id"           => $user->id,
              "verify_phone" =>1,

              "mobile" =>$response->json('data.mobile'),
            ],
            "message" => "updated successfully",
            ]);
    }


      //test_mobile_exists
      public function test_mobile_exist_user_with_valid_attributes_cant_update_profile()
      {

        $mobile = '00112343' . rand(1111,9999);
          $code = rand(1111,9999);
          $user =User::factory()->create([
              'password'        => bcrypt('123456'),
              "verify_phone"    =>0,
              "pin_code"        =>$code,
              'mobile'          =>   $mobile,

           ]);
           Passport::actingAs($user);

           $data = ['mobile' =>"011232522431046"];
           $response=  $this->json('POST','api/v1/update_profile', $data, ['Accept' => 'application/json']);
           $response->assertJson([
            "success" => false,
                "message" => "phone has been token",
                "data" => null,
            ]);
      }
      //test_mobile_dont_exists
      public function test_mobile_dont_exist_user_with_valid_attributes_cant_update_profile()
      {

          $code = rand(1111,9999);
          $user =User::factory()->create([
              'password'        => bcrypt('123456'),
              "verify_phone"    =>0,
              "pin_code"        =>$code,
              "mobile"          =>null,

           ]);
           Passport::actingAs($user);
           $mobile = '00112343' . rand(1111,9999);
           $data = ['mobile' =>$mobile];
           $response=  $this->json('POST','api/v1/update_profile', $data, ['Accept' => 'application/json']);
           $response->assertJsonStructure([
            "data" =>[
                "id",
                "name",
                "email",
                "verify_phone",
                "mobile",
                "image",
                "account_type",
                "token",
                "points" ,
            ],
          "message",
        ]);
      }

}

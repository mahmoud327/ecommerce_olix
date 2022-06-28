<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class SetMarketerCodeTest extends TestCase
{

    //test user marketer when marketer  null and vaild attribute
    public function test_Marketer_with_vaild_attribute_can_set_Marketer()
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
         Passport::actingAs($user);

         $data = ['marketer_code' => 'SN#CAgw'];
         $response=  $this->json('POST','api/v1/setMarketerCode',$data);
         $response->assertJson([
            "success" => true,
            "data" =>[
              "id" => $user->id,
              "name" => $user->name,
              "email" =>$user->email,
              "points" => 1000,
            ],
            "message" => "Congratulation you got 1000 points."
            ]);

    }

    //test user marketer when marketer invaild attribute
    public function test_Marketer_with_invaild_attribute_cant_set_Marketer()
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
         Passport::actingAs($user);
         $data = ['marketer_code' => 'jjjjj'];
         $response=  $this->json('POST','api/v1/setMarketerCode',$data);
        $response->assertJson([
            "success" => false,
            "message" => "The selected marketer code is invalid.",
            "data" => null,
            ]);

    }


   //test user marketer when marketer not null
    public function test_user_marketer_code_id_not_null()
    {
        $mobile = '00112343' . rand(1111,9999);
        $user =User::factory()->create([
            'password'           => bcrypt('12345678'),
            "mobile"             =>$mobile,
            "verify_phone"       =>0,
            'marketer_code_id'   =>1,
         ]);
         Passport::actingAs($user);
         $data = ['marketer_code' => 'Suiiz-A-177942'];
         $response=  $this->json('POST','api/v1/setMarketerCode', $data, ['Accept' => 'application/json']);
         $response->assertJson([
            "success" => true,
            "data" =>[
              "id" => $user->id,
              "name" => $user->name,
              "email" =>$user->email,
              "points" => null,
            ],
            "message" => "Sorry, you already got 1000 points befor."
            ]);
    }

  

}

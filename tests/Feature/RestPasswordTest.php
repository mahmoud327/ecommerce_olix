<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class RestPasswordTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    ///test user when account is_exists reset password
    public function test_user_with_can_reset_password()
    {
        $code = rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>"01123431046",
            "verify_phone"    =>1,
            "activate"        =>1,
            "pin_code"        =>$code,

         ]);

         $data = ['mobile' => '01123431046'];

       $response=  $this->json('POST','api/v1/reset_password', $data, ['Accept' => 'application/json']);

        $this->assertEquals($code,$user->pin_code);

       $response->assertJson([
        "success" => true,
        "data" => "Success",
        "message" => " successfully sent code."
        ]);

    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    ///test user when account doestent_exists reset password
    public function test_user_with_account_doestnot_exist()
    {
        $code = rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>"01123431046",
            "verify_phone"    =>0,
            "activate"        =>0,
            "pin_code"        =>$code,
         ]);
       $data = ['mobile' => '011111111'];
       $response=  $this->json('POST','api/v1/reset_password', $data, ['Accept' => 'application/json']);
       $response->assertJson([
            "success" => false,
            "message" => "the account dont exist",
            "data" => null,
        ]);


    }



}

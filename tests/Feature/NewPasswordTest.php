<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class NewPasswordTest extends TestCase
{

    ///test user when account is_exists reset password
    public function test_user_with_vaild_attribute_can_new_password()
    {
        $mobile = '00112343' . rand(1111, 9999);
        $user = User::factory()->create([
            'password'     => bcrypt('12345678'),
            "mobile"       => $mobile,
            "verify_phone" => 1,
            "activate"     => 1,
        ]);

        $data = ['mobile' => $mobile, 'password' => '12345678', 'password_confirmation' => '12345678'];
        $response = $this->json('POST', 'api/v1/new_password', $data, ['Accept' => 'application/json']);

        $response->assertJson([
            "success" => true,
            "data"    => "Success",
            "message" => "updated successfully",
        ]);

    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    ///test user when account doestent_exists reset password
    public function test_user_with_invaild_attribute_cant_new_password()
    {
        $mobile = '00112343' . rand(1111, 9999);
        $user = User::factory()->create([
            'password'     => bcrypt('12345678'),
            "mobile"       => $mobile,
            "verify_phone" => 1,
            "activate"     => 1,

        ]);

        $data = ['mobile' => $mobile, 'password' => '12345678555', 'password_confirmation' => '12345678'];
        $response = $this->json('POST', 'api/v1/new_password', $data, ['Accept' => 'application/json']);
        $response->assertJson([
            "success" => false,
            "message" => "The password confirmation does not match.",
            "data"    => null,
        ]);

    }
    ///test dont user donot exist
    public function test_dont_user_exist_cant_new_password()
    {
        $mobile = '00112343' . rand(1111, 9999);
        $user = User::factory()->create([
            'password'     => bcrypt('12345678'),
            "mobile"       => $mobile,
            "verify_phone" => 1,
            "activate"     => 1,

        ]);

        $data = ['mobile' => "112323565454", 'password' => '12345678', 'password_confirmation' => '12345678'];
        $response = $this->json('POST', 'api/v1/new_password', $data, ['Accept' => 'application/json']);
        $response->assertJson([
            "success" => false,
            "message" => "Please check your phone",
            "data"    => null,
        ]);

    }

}

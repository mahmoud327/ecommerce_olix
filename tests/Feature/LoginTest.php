<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_verified_user_with_valid_attributes_can_login()
    {
        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 1,

        ]);

        $data = ['mobile' => $user->mobile, 'password' => '123456', 'mobile_type' => 'ios'];
        $response = $this->json('POST', 'api/v1/login', $data, ['Accept' => 'application/json']);

        $this->assertEquals([

            "id"           => $response->json('data.id'),
            "name"         => $response->json('data.name'),
            "email"        => $response->json('data.email'),
            "verify_phone" => $response->json('data.verify_phone'),
        ],
            [
                "id"           => $user->id,
                "name"         => $user->name,
                "email"        => $user->email,
                "verify_phone" => 1,

            ]);

    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_unverified_user_with_valid_attributes_can_login()
    {

        $code = rand(1111, 9999);
        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 0,
            "pin_code"     => $code,

        ]);

        $data = ['mobile' => $user->mobile, 'password' => '123456', 'mobile_type' => 'ios'];
        $response = $this->json('POST', 'api/v1/login', $data, ['Accept' => 'application/json']);
        ///if account dont activate send code
        $this->assertEquals($code, $user->pin_code);

    }

    public function test_unverified_user_with_invalid_password_cant_login()
    {
        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 0,

        ]);

        $data = [
            'mobile'      => $user->mobile,
            'password'    => 'invaild-password',
            'mobile_type' => 'ios',
        ];

        $response = $this->json('POST', 'api/v1/login', $data, ['Accept' => 'application/json']);

        $response->assertJson([

            "success" => false,
            "message" => "Please check your password",
            "data"    => null,
        ]);

    }

    public function test_verified_user_with_invalid_password_cant_login()
    {
        $user = User::factory()->create([
            'password'     => bcrypt('123456'),
            "verify_phone" => 1,

        ]);

        $data = [
            'mobile'      => $user->mobile,
            'password'    => 'invaild-password',
            'mobile_type' => 'ios',
        ];

        $response = $this->json('POST', 'api/v1/login', $data, ['Accept' => 'application/json']);

        $response->assertJson([

            "success" => false,
            "message" => "Please check your password",
            "data"    => null,
        ]);

    }

}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class RegisterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    ///test user when mobile is_token
    public function test_user_with_mobile_taken_cant_register()
    {
        $user =User::factory()->create([
            'password'        => bcrypt('12345678'),
            "mobile"          =>"01123431046",
            "verify_phone"    =>0,
            "activate"        =>0
         ]);

         $data = ['mobile' => '01123431046', 'name' =>  $user->name,'password' => '12345678','mobile_type'=>'ios' ,'fcm_token' =>'dFVh3jnkR3SBq_Hnbv2J2g:APA91bGtSU8ovNqrzE8GHhinmO6z5kPCfsI9fuB81kQgxVppMzUCleSWjCdGYZck9HtAEl_yOsosvQpcft41xtcH-7yAzygX72TskQHrNVnuNxkHdqvHocbp7UAq0i9rratrI1Cj4sQ6'];

       $response=  $this->json('POST','api/v1/register', $data, ['Accept' => 'application/json']);

        $this->mock(User::class, function (MockInterface $moc) {
             $moc->shouldReceive('sendOtpNotification')->andReturn('ss');
          });

       $response->assertJson([
            "success" => false,
            "message" => "Mobile already exist please login ",
            "data" => null,
        ]);


    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
   ///register account and send bin_code
    public function test_user_with_valid_attributes_can_register()
    {

         $mobile = '00112343' . rand(1111,9999);
         $data = ['mobile' => $mobile, 'name' =>  'full name','password' => '12345678','mobile_type'=>'ios' ,'fcm_token' =>'dFVh3jnkR3SBq_Hnbv2J2g:APA91bGtSU8ovNqrzE8GHhinmO6z5kPCfsI9fuB81kQgxVppMzUCleSWjCdGYZck9HtAEl_yOsosvQpcft41xtcH-7yAzygX72TskQHrNVnuNxkHdqvHocbp7UAq0i9rratrI1Cj4sQ6'];
         $response=  $this->json('POST','api/v1/register', $data, ['Accept' => 'application/json']);

        $user=User::where('mobile',$mobile)->first();
        $this->assertNotNull($user);
        $response->assertJson([
            "success" => true,
            "data" =>  [
            "id" =>   $response->json('data.id'),
            "name" =>   'full name',
            "email" =>  null,

            ],
            "message" => "users"


        ]);

    }



}

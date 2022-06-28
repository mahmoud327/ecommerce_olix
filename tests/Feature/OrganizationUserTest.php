<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\OrganizationType;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductFavouriteUser;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;
use Laravel\Passport\Passport;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;


class OrganizationUserTest extends TestCase
{

    ////test_get_organization_user_with_valid_attibute if user in organization
    public function test_get_organization_user_with_valid_attibute()
    {

        $mobile = '00112343' . rand(1111,9999);
        $organization_type =OrganizationType::factory()->create([
            'name'                   =>'dd',
         ]);

        $organization =Organization::factory()->create([
            'name'                   => bcrypt('123456'),
            "description"            =>'jjj',
            'organization_type_id'    => $organization_type->id,
         ]);

        $user =User::factory()->create([
            'password'        => bcrypt('123456'),
            "verify_phone"    =>1,
            'mobile'          => $mobile,
            'organization_id' =>$organization->id

         ]);

       Passport::actingAs($user);
       $response=  $this->json('get','api/v1/get_organization_user/', ['Accept' => 'application/json']);

        $response->assertJsonStructure([
            "success",
            "data" =>[
              "id",
              "name",
              "link" ,
              "description",
              "phones" ,
              "latitude",
              "langitude",
              "background_cover",
              "image",
            ],
            'message'
        ]);

    }
    ////test_get_organization_user_with_valid_attibute if user in  dont_organization
    public function test_get_organization_user_with_valid_attibute_user_in_dont_organization()
    {

        $mobile = '00112343' . rand(1111,9999);
        $user =User::factory()->create([
            'password'        => bcrypt('123456'),
            "verify_phone"    =>1,
            'mobile'          => $mobile,

         ]);

       Passport::actingAs($user);

        $response=  $this->json('get','api/v1/get_organization_user/', ['Accept' => 'application/json']);
        $response->assertJson([
            "success" => false,
            "message" => "dont found organization for user",
            "data" => null,
        ]);

    }





}

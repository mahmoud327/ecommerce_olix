<?php

namespace Tests\Feature\Refactoring\Products;

use Tests\TestCase;
use App\Models\Product;

class ListProductsTest extends TestCase
{
    /**
     * @var int
     */
    public $defaultPagination = 15;

    /**
     * @var array
     */
    public $defaultResponseStructure = [
        'success',
        'code',
        'http_code',
        'locale',
        'message',
        'data' => [
            '*' => [
                "id",
                "name",
                "note",
                "isFavorite",
                "discount",
                "price",
                "finalPrice",
                "featuredImage" => [
                    "id",
                    "original",
                    "large",
                    "medium",
                    "thumb",
                    "order",
                    "is_featured",
                ],
                "cityName",
                "governorateName",
                "phonesCount",
                "viewsCount",
                "chatsCount",
                "favouritesCount",
                "createdAt",
                "updatedAt",
            ],
        ],
        'additional',
        'links',
        'meta',
    ];

    /**
     * @test
     */
    public function test_guest_or_user_can_list_all_products()
    {
        $productsCount = Product::query()
            ->where('status', "approve")
            ->count();

        $queryString = http_build_query([]);

        $response = $this->get(route('v1.products.index') . "?{$queryString}");

        $response->assertSuccessful();

        // Pagination Assertions
        $this->assertEquals(1, $response->json('meta.current_page'));
        $this->assertEquals($productsCount, $response->json('meta.total'));
        $this->assertEquals((int) ceil($productsCount / $this->defaultPagination) ?: 1, $response->json('meta.last_page'));
        $this->assertEquals($this->defaultPagination, $response->json('meta.per_page'));

        // Response Structure Assertions
        $response->assertJsonStructure($this->defaultResponseStructure);
    }

    /**
     * @test
     */
    // public function test_guest_or_user_can_list_filtered_products()
    // {
    //     $product = Product::factory()->create([
    //         'name'        => "ProductName99",
    //         "description" => "ff",
    //         "price"       => 44,
    //         "category_id" => 79,
    //         'status'      => "approve",
    //         "city_id"     => 1,
    //     ]);

    //     $productsCount = Product::query()
    //         ->where('status', "approve")
    //         ->where('name', 'like', '%')
    //         ->category(1)
    //         ->count();

    //     $queryString = [
    //         'filter[name]'        => '',
    //         'filter[description]' => '',
    //         'filter[category]'    => '1',
    //         'filter[governorate]' => '',
    //         'filter[price_range]' => '',
    //         'filter[sub_filters]' => '',
    //         'filter[city]'        => '',
    //         'filter[favorite_by]' => '',
    //     ];

    //     $response = $this->get(route('v1.products.index') . "?{$queryString}");

    //     $response->assertSuccessful();

    //     // Pagination Assertions
    //     $this->assertEquals(1, $response->json('meta.current_page'));
    //     $this->assertEquals($productsCount, $response->json('meta.total'));
    //     $this->assertEquals(ceil($productsCount / $this->defaultPagination), $response->json('meta.last_page'));
    //     $this->assertCount($this->defaultPagination, $response->json('data'));
    //     $this->assertEquals($this->defaultPagination, $response->json('meta.per_page'));

    //     // Response Structure Assertions
    //     $response->assertJsonStructure($this->defaultResponseStructure);
    // }

}

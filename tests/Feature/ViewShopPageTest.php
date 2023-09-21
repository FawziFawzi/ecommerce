<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewShopPageTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_shop_page_loads_correctly()
    {
//        Steps:

        //1- Arrange

        //2- Act
        $response = $this->get('/shop');

        //3- Assert
        $response->assertStatus(200);
        $response->assertSee('Featured');
    }

    public function test_featured_product_is_visible()
    {
        //Arrange
        $featuredProduct = Product::factory()->create([
            'featured'=>true,
            'name'=>'Laptop 2',
            'price'=>149999,
        ]);

        //Act
        $response = $this->get('/');

        //Assert
        $response->assertSee($featuredProduct->name);
        $response->assertSee('$ 1,499.99');
    }


    public function test_not_featured_product_is_not_visible()
    {
        //Arrange
        $notFeaturedProduct =Product::factory()->create([
            'featured'=>false,
            'name'=>'Laptop 1',
            'price'=>149999,
        ]);

        //Act
        $response = $this->get('/');

        //Assert
        $response->assertDontSee($notFeaturedProduct->name);
        $response->assertDontSee('$ 1499.99');
    }

    public function test_pagination_for_products_works()
    {
        //Page 1 Products
        for ($i =11; $i <20; $i++) {
            Product::factory()->create([
                'featured'=>true,
                'name'=>'Product '.$i,
            ]);
        }

        //Page 2 Products
        for ($i =21; $i <30; $i++) {
            Product::factory()->create([
                'featured'=>true,
                'name'=>'Product '.$i,
            ]);
        }

        $response = $this->get('/shop');
        $response->assertSee('Product 11');
        $response->assertSee('Product 19');

        $response = $this->get('/shop?page=2');
        $response->assertSee('Product 21');
        $response->assertSee('Product 29');
    }

    // SORTING

    public function test_sort_products_low_to_high()
    {
        Product::factory()->create([
            'featured'=>true,
            'name'=>'Product Middle',
            'price'=>15000,
        ]);

        Product::factory()->create([
            'featured'=>true,
            'name'=>'Product Low',
            'price'=>10000,
        ]);

        Product::factory()->create([
            'featured'=>true,
            'name'=>'Product High',
            'price'=>20000,
        ]);

        $response = $this->get('/shop?sort=low_high');

        $response->assertSeeInOrder(['Product Low','Product Middle','Product High']);
    }


    public function test_sort_products_high_to_low()
    {
        Product::factory()->create([
            'featured'=>true,
            'name'=>'Product Middle',
            'price'=>15000,
        ]);

        Product::factory()->create([
            'featured'=>true,
            'name'=>'Product Low',
            'price'=>10000,
        ]);

        Product::factory()->create([
            'featured'=>true,
            'name'=>'Product High',
            'price'=>20000,
        ]);

        $response = $this->get('/shop?sort=high_low');

        $response->assertSeeInOrder(['Product High','Product Middle','Product Low']);
    }
}

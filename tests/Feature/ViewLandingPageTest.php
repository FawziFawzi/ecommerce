<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewLandingPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_landing_page_loads_correctly()
    {
//        Steps:

        //1- Arrange

        //2- Act
        $response = $this->get('/');

        //3- Assert
        $response->assertStatus(200);
        $response->assertSee('Laravel Ecommerce');
        $response->assertSee('Includes multiple products');
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
}

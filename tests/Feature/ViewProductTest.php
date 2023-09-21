<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_product_details()
    {
        $product = Product::factory()->create([
            'name'=>'Laptop 1',
            'slug'=>'laptop-1',
            'details'=>'15 inch, 2 TB SSD, 32GB RAM',
            'price'=>249999,
            'description'=>'This is a description for laptop 1.',
        ]);

        $response = $this->get('/shop/'.$product->slug);

        $response->assertStatus(200);
        $response->assertSee('Laptop 1');
        $response->assertSee('2 TB SSD');
        $response->assertSee('2,499.99');
        $response->assertSee('This is a description for laptop 1');


    }

    // STOCK LEVELS

    public function test_stock_level_high()
    {
        $product = Product::factory()->create(['quantity' => 10]);
        $response = $this->get('/shop/'.$product->slug);

        $response->assertSee('In Stock');

    }

    // Not Working Yet

    public function test_stock_level_low()
    {
        $product = Product::factory()->create(['quantity' => 1]);
        $response = $this->get('/shop/'.$product->slug);

        $response->assertSee('Low Stock');

    }
    ////////

    public function test_stock_level_none()
    {
        $product = Product::factory()->create(['quantity' => 0]);
        $response = $this->get('/shop/'.$product->slug);

        $response->assertSee('Not Available');

    }


    public function test_show_related_products()
    {
        $product1 = Product::factory()->create(['name' => 'Product 1']);
        $product2 = Product::factory()->create(['name' => 'Product 2']);
        $response = $this->get('/shop/'.$product1->slug);
        $response->assertSee('Product 2');
        $response->assertViewHas('mightAlsoLike');
    }
}

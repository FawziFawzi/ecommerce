<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryInShopPageTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_category_page_show_correct_products()
    {
        $laptop1 = Product::factory()->create([
            'name'=>'Laptop 1'
        ]);

        $laptop2 = Product::factory()->create([
            'name'=>'Laptop 2'
        ]);

        $laptopsCategory=Category::create([
            'name'=>'laptops',
            'slug'=>'laptops'
        ]);

        $laptop1->categories()->attach($laptopsCategory->id);
        $laptop2->categories()->attach($laptopsCategory->id);

        $response = $this->get('/shop?category=laptops');

        $response->assertSee('Laptop 1');
        $response->assertSee('Laptop 2');
    }

    public function test_category_page_dont_show_correct_products()
    {
        $laptop1 = Product::factory()->create([
            'name'=>'Laptop 1'
        ]);

        $laptop2 = Product::factory()->create([
            'name'=>'Laptop 2'
        ]);

        $laptopsCategory=Category::create([
            'name'=>'laptops',
            'slug'=>'laptops'
        ]);

        $laptop1->categories()->attach($laptopsCategory->id);
        $laptop2->categories()->attach($laptopsCategory->id);

        $desktop1 = Product::factory()->create([
            'name'=>'Desktop 1'
        ]);
        $desktop2 = Product::factory()->create([
            'name'=>'Desktop 2'
        ]);


        $desktopsCategory=Category::create([
            'name'=>'Desktops',
            'slug'=>'desktops'
        ]);

        $desktop1->categories()->attach($desktopsCategory->id);
        $desktop2->categories()->attach($desktopsCategory->id);

        $response = $this->get('/shop?category=laptops');

        $response->assertDontSee('Desktop 1');
        $response->assertDontSee('Desktop 2');
    }
}

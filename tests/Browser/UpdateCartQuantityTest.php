<?php

namespace Tests\Browser;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateCartQuantityTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     */
    public function testUpdateItemQuantityInCart(): void
    {
        $product = Product::factory()->create([
            'name'=>'Laptop 1',
            'slug'=>'laptop-1'
        ]);

        $this->browse(function (Browser $browser) use ($product) {
            $browser->visit('/shop/'.$product->slug)
                    ->assertSee('Laptop 1')
                    ->press('Add to Cart')
                    ->assertPathIs('/cart')
                    ->select('.quantity',2)
                    ->pause(1000)
                    ->assertSee('Quantity updated!!')

            ;
        });
    }
}

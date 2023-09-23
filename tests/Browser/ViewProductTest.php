<?php

namespace Tests\Browser;

use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ViewProductTest extends DuskTestCase
{

    use DatabaseMigrations;
    /**
     * A Dusk test example.
     */
//    public function testExample(): void
//    {
//        $this->browse(function (Browser $browser) {
//
//            $product = Product::factory()->create(['quantity' => 1]);
//
//            $browser->visit('/shop/'.$product->slug)
//                    ->assertSee('Low Stock');
//        });
//    }
}

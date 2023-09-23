<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     */
    public function testUserCanLogin(): void
    {
        $user = User::factory()->create(['email' => 'user@user.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->visit('/login')
                    ->assertSee('Returning Customer')
                    ->type('email','user@user.com')
                    ->type('password','password')
                    ->press('Login')
                    ->assertPathIs('/')
                    ->assertSee('Laravel');
        });
    }
}

<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends DuskTestCase
{
     use RefreshDatabase;
    public function test_admin_can_login_and_see_dashboard()
    {
        $this->browse(function (Browser $browser) {

            $admin = User::factory()->create([
                'email' => 'admin@test.com',
                'password' => '12345678',
                'role' => 'admin',
            ]);
            

          $browser->visit('/login')
    ->type('email', $admin->email)
    ->type('password', '12345678')
    ->press('Entrar')
    ->waitForText('Administración', 10)
    ->assertSee('Dashboard');
        });
    }

    public function test_provider_can_login_and_see_dashboard()
    {
        $this->browse(function (Browser $browser) {

            $provider = User::factory()->create([
                'email' => 'provider@test.com',
                'password' => '12345678',
                'role' => 'provider',
            ]);

                $browser->visit('/login')
    ->type('email', $provider->email)
    ->type('password', '12345678')
    ->press('Entrar')
    ->waitForText('Mis Productos', 10)
    ->assertSee('Dashboard');
        });
    }
        public function guest_cannot_access_dashboard()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('/dashboard')
                ->assertPathIs('/login');
    });
}
    
}

<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class LoginTest extends DuskTestCase
{
    public function testLogin()
    {
      $this->browse(function ($browser) {
          $browser->visit('/login')
                  ->type('email', 'admin@admin.com')
                  ->type('password', 'password')
                  ->press('Log in')
                  ->assertPathIs('/dashboard')
                  ->assertSee('Admin Dashboard');
      });
    }
}

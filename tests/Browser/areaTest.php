<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class areaTest extends DuskTestCase
{
    public function test_admin_can_access_area()
    {
        $user = User::find(2);
        $this->browse(function ($browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->assertSee('Admin Dashboard')
                    ->visit('/area')
                    ->assertSee('Area List')
                    ->press('Add Area')
                    ->pause(3000)
                    ->assertSee('Area Name')
                    ->type('name', 'Nulla quis lorem')
                    ->type('description', 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Vivamus suscipit tortor eget felis porttitor volutpat.')
                    ->press('Save')
                    ->pause(3000)
                    ->with('#area_table', function ($table) {
                        $table->assertSee('Nulla quis lorem');
                    });
        });
    }
}

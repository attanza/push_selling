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
                    ->pause(2000)
                    ->assertSee('Area Name')
                    ->type('name', 'Nulla quis lorem')
                    ->type('description', 'Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Vivamus suscipit tortor eget felis porttitor volutpat.')
                    ->press('Save')
                    ->pause(2000)
                    ->with('#area_table', function ($table) {
                        $table->assertSee('Nulla quis lorem')
                          ->click('.btn-default');
                    })
                    ->pause(2000)
                    ->assertSee('Area Name')
                    ->assertInputValue('name', 'Nulla quis lorem')
                    ->clear('name')
                    ->type('name', 'Vivamus suscipit tortor eget felis porttitor volutpat.')
                    ->press('Save')
                    ->pause(2000)
                    ->with('#area_table', function ($table) {
                        $table->assertSee('Vivamus suscipit tortor eget felis porttitor volutpat.')
                        ->click('.btn-danger');
                    })
                    ->pause(2000)
                    ->press('OK')
                    ->pause(2000)
                    ->with('#area_table', function ($table) {
                        $table->assertDontSee('Vivamus suscipit tortor eget felis porttitor volutpat.');
                    });
        });
    }
}

<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use Faker\Factory;
use Carbon\Carbon;

class ItemTest extends DuskTestCase
{
  /**
   * @group item
   */
    public function test_admin_can_access_item()
    {
        $user = User::find(2);
        $faker = Factory::create();
        $this->browse(function ($browser) use ($user, $faker) {
            $browser->loginAs($user)
                    ->visit('/items')
                    ->assertSee('Item List')
                    ->press('Add Item')
                    ->pause(2000)
                    ->assertSee('Item Code')
                    ->type('code', 'Test Item')
                    ->press('Save')
                    ->pause(1000)
                    ->assertSee('The Item Name field is required.')
                    ->clear('code')
                    ->type('code', $faker->unique()->ean8)
                    ->type('name', 'Vivamus magna justo')
                    ->type('measurement', $faker->word)
                    ->type('price', $faker->numberBetween(100000, 200000))
                    ->select('target_by')
                    ->type('target_count', $faker->numberBetween(1000, 5000))
                    ->type('start_date', '2017-08-01')
                    ->type('end_date', '2017-12-01')
                    ->press('Save')
                    ->pause(2000)
                    ->with('#item_list', function ($table) {
                        $table->assertSee('Vivamus magna justo');
                    });
        });
    }
}

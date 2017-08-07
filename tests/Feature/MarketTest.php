<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\Market;
use App\Models\Area;
use App\Models\Outlet;

class MarketTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
    /**
     * @group market
     */
    public function test_admin_can_access_market()
    {
        $user = User::find(2);
        $this->actingAs($user)
          ->get('/market')
          ->see('Market List');
    }

    /**
     * @group market
     */
    public function test_admin_can_create_market()
    {
        $faker = Factory::create();
        factory(Area::class)->create();
        $name = $faker->city;
        $postData = [
          'area_id' => 1,
          'name' => $name,
          'slug' => str_slug($name),
          'address' => $faker->address,
          'lat' => $faker->latitude,
          'lng' => $faker->longitude,
        ];
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('POST', '/api/market', $postData)
          ->assertResponseStatus(200);
    }

    /**
     * @group market
     */
    public function test_admin_can_edit_market()
    {
        factory(Area::class)->create();
        factory(Market::class)->create([
          'area_id' => 1
        ]);
        $faker = Factory::create();
        $name = $faker->city;
        $postData = [
          'area_id' => 1,
          'name' => $name,
          'slug' => str_slug($name),
          'address' => $faker->address,
          'lat' => $faker->latitude,
          'lng' => $faker->longitude,
        ];
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('PUT', '/api/market/1', $postData)
          ->assertResponseStatus(200);
    }
    /**
     * @group market
     */
    public function test_admin_can_delete_market()
    {
        factory(Area::class)->create();
        $market = factory(Market::class)->create([
          'area_id' => 1
        ]);
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/market/'.$market->id)
          ->assertResponseStatus(200);
    }

    /**
     * @group market
     */
    public function test_admin_cannot_delete_bounded_market()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/market/1')
          ->assertResponseStatus(403);
    }

    /**
     * @group market
     */
    public function test_market_cannot_be_deleted_if_outlet_exist()
    {
        factory(Area::class)->create();
        factory(Market::class)->create([
          'area_id' => 1
        ]);
        factory(Outlet::class)->create([
            'market_id' => 1
        ]);
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/market/1')
          ->assertResponseStatus(403);
    }

}

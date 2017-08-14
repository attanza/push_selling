<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\Item;
use Carbon\Carbon;

class ItemModuleTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
    /**
     * @group item
     */
    public function test_admin_can_access_item()
    {
        $user = User::find(2);
        $this->actingAs($user)
          ->get('/items')
          ->see('Item List');
    }
    /**
     * @group item
     */
    public function test_admin_can_create_item()
    {
        $faker = Factory::create();
        $postData = [
          'code' => $faker->unique()->ean8,
          'name' => $faker->streetName,
          'measurement' => $faker->word,
          'price' => $faker->numberBetween(100000, 200000),
          'target_by' => $faker->numberBetween(1, 2),
          'target_count' => $faker->numberBetween(1000, 5000),
          'start_date' => '2017-08-01',
          'end_date' => '2017-12-01',
        ];
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('POST', '/api/items', $postData)
          ->assertResponseOk();
    }
    /**
     * @group item
     */
    public function test_admin_can_edit_item()
    {
        $faker = Factory::create();
        $item = factory(Item::class)->create();
        $postData = [
          'code' => $faker->unique()->ean8,
          'name' => $faker->streetName,
          'measurement' => $faker->word,
          'price' => $faker->numberBetween(100000, 200000),
          'target_by' => $faker->numberBetween(1, 2),
          'target_count' => $faker->numberBetween(1000, 5000),
          'start_date' => '2017-08-01',
          'end_date' => '2017-12-01',
        ];

        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('PUT', '/api/items/1', $postData)
          ->assertResponseStatus(200);
    }
    /**
     * @group item
     */
    public function test_admin_can_delete_item()
    {
        $item = factory(Item::class)->create();
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/items/'.$item->id)
          ->assertResponseStatus(200);
    }

    /**
     * @group item
     */
    public function test_admin_cannot_delete_bounded_item()
    {
        // $item = factory(Item::class)->create();
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/items/1')
          ->assertResponseStatus(403);
    }

    /**
     * @group item
     */
    public function test_supervisor_can_access_item()
    {
        $user = User::find(3);
        $this->actingAs($user)
          ->visit('/items')
          ->see('Item List');
    }

    /**
     * @group item
     */
    public function test_supervisor_cannot_add_item()
    {
        $faker = Factory::create();
        $postData = [
          'code' => $faker->unique()->ean8,
          'name' => $faker->streetName,
          'measurement' => $faker->word,
          'price' => $faker->numberBetween(100000, 200000),
          'target_by' => $faker->numberBetween(1, 2),
          'target_count' => $faker->numberBetween(1000, 5000),
          'start_date' => '2017-08-01',
          'end_date' => '2017-12-01',
        ];
        $user = User::find(3);
        $this->actingAs($user, 'api')
          ->json('POST', '/api/items', $postData)
          ->assertResponseStatus(403);
    }

    /**
     * @group item
     */
    public function test_seller_can_access_item()
    {
        $user = User::find(4);
        $this->actingAs($user)
          ->visit('/items')
          ->see('Item List');
    }

    /**
     * @group item
     */
    public function test_seller_cannot_add_item()
    {
        $faker = Factory::create();
        $postData = [
          'code' => $faker->unique()->ean8,
          'name' => $faker->streetName,
          'measurement' => $faker->word,
          'price' => $faker->numberBetween(100000, 200000),
          'target_by' => $faker->numberBetween(1, 2),
          'target_count' => $faker->numberBetween(1000, 5000),
          'start_date' => '2017-08-01',
          'end_date' => '2017-12-01',
        ];
        $user = User::find(4);
        $this->actingAs($user, 'api')
          ->json('POST', '/api/items', $postData)
          ->assertResponseStatus(403);
    }

}

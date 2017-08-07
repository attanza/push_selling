<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\Area;

class AreaModuleTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group area
     */
    public function test_admin_can_access_area()
    {
        $user = User::find(2);
        $this->actingAs($user)
          ->get('/area')
          ->see('Area List');
    }
    /**
     * @group area
     */
    public function test_admin_cannot_submit_blank_data()
    {
        $faker = Factory::create();
        $postData = [
          'name' => '',
          'description' => $faker->paragraph
        ];
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('POST', '/api/area', $postData)
          ->assertResponseStatus(422);
    }

    /**
     * @group area
     */
    public function test_admin_can_add_area()
    {
        $faker = Factory::create();
        $postData = [
          'name' => $faker->city,
          'description' => $faker->paragraph
        ];
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('POST', '/api/area', $postData)
          ->assertResponseStatus(200);
    }

    /**
     * @group area
     */
    public function test_admin_can_edit_area()
    {
        $faker = Factory::create();
        $item = factory(Area::class)->create();
        $postData = [
          'name' => $faker->city,
          'description' => $faker->paragraph
        ];

        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('PUT', '/api/area/1', $postData)
          ->assertResponseStatus(200);
    }

    /**
     * @group area
     */
    public function test_admin_can_delete_area()
    {
        $area = factory(Area::class)->create();
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/area/'.$area->id)
          ->assertResponseStatus(200);
    }

    /**
     * @group area
     */
    public function test_admin_cannot_delete_bounded_area()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/area/1')
          ->assertResponseStatus(403);
    }

    /**
     * @group area
     */
    public function test_supervisor_cannot_access_area()
    {
        $user = User::find(3);
        $this->actingAs($user)
          ->get('/area')
          ->assertRedirectedTo('/dashboard');
    }

    /**
     * @group area
     */
    public function test_seller_cannot_access_area()
    {
        $user = User::find(4);
        $this->actingAs($user)
          ->get('/area')
          ->assertRedirectedTo('/dashboard');
    }
}

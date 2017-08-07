<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\Stokiest;
use App\Models\Area;

class StokiestTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
    /**
     * @group stokiest
     */
    public function test_admin_can_access_stokiest()
    {
        $user = User::find(2);
        $this->actingAs($user)
          ->get('/stokiest')
          ->see('Stokiest List');
    }
    /**
     * @group stokiest
     */
    public function test_admin_can_access_create_stokiest_page()
    {
        $user = User::find(2);
        $this->actingAs($user)
          ->get('/stokiest/create')
          ->see('Create Stokiest');
    }
    /**
     * @group stokiest
     */
    public function test_admin_cannot_submit_blank_data()
    {
        $user = User::find(2);
        $this->actingAs($user, 'api')
          ->json('post', '/api/stokiest')
          ->assertResponseStatus(422);
    }
    /**
     * @group stokiest
     */
    public function test_admin_can_create_stokiest()
    {
        $faker = Factory::create();
        factory(Area::class)->create();
        $postData = [
            'code' => '1234',
            'area_id' => 1,
            'name' => $faker->company,
            'owner' => $faker->name,
            'pic' => $faker->name,
            'phone1' => $faker->e164PhoneNumber,
            'phone2' => $faker->e164PhoneNumber,
            'email' => $faker->unique()->email,
            'address' => $faker->address,
            'lat' => $faker->latitude,
            'lng' => $faker->longitude,
        ];
        $user = User::find(2);
        $this->actingAs($user, 'api')
            ->json('post', '/api/stokiest', $postData)
            ->assertResponseStatus(200);
    }

    /**
     * @group stokiest
     */
    public function test_admin_can_view_stokiest()
    {
        factory(Area::class)->create();
        $stokiest = factory(Stokiest::class)->create([
            'code' => '1234',
            'area_id' => 1
        ]);

        $user = User::find(2);
        $this->actingAs($user)
            ->get('/stokiest/1234')
            ->see($stokiest->name);
    }
    /**
     * @group stokiest
     */
    public function test_admin_can_edit_stokiest()
    {
        $faker = Factory::create();
        factory(Area::class)->create();
        $stokiest = factory(Stokiest::class)->create([
            'code' => '1234',
            'area_id' => 1
        ]);
        $postData = [
            'code' => '1234',
            'area_id' => 1,
            'name' => $faker->company,
            'owner' => $faker->name,
            'pic' => $faker->name,
            'phone1' => $faker->e164PhoneNumber,
            'phone2' => $faker->e164PhoneNumber,
            'email' => $faker->unique()->email,
            'address' => $faker->address,
            'lat' => $faker->latitude,
            'lng' => $faker->longitude,
        ];
        $user = User::find(2);
        $this->actingAs($user, 'api')
            ->json('put', '/api/stokiest/'.$stokiest->id, $postData)
            ->assertResponseStatus(200);
    }
    /**
     * @group stokiest
     */
    public function test_admin_can_set_location()
    {
        $faker = Factory::create();
        factory(Area::class)->create();
        $stokiest = factory(Stokiest::class)->create([
            'code' => '1234',
            'area_id' => 1
        ]);
        $postData = [
            'lat' => $faker->latitude,
            'lng' => $faker->longitude,
        ];
        $user = User::find(2);
        $this->actingAs($user, 'api')
            ->json('post', '/api/stokiest/1/set_location', $postData)
            ->assertResponseStatus(200);
    }
}

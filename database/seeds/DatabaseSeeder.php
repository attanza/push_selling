<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        $this->role_seeder();

        // Create Admin User
        $this->createAdmin();

        $this->seedArea();
        // $this->seedMarket();
        // $this->seedStokiest();
        // $this->seedItems();

    }

    private function createAdmin()
    {
        App\User::truncate();
        App\User::create([
          'name' => 'Superuser',
          'username' => 'superuser',
          'email' => 'superuser@superuser.com',
          'password' => bcrypt('password'),
        ]);
        App\User::create([
          'name' => 'Administrator',
          'username' => 'administrator',
          'email' => 'admin@admin.com',
          'password' => bcrypt('password'),
        ]);

        DB::table('role_user')->insert([
          'user_id' => 1,
          'role_id' => 5
        ]);
        DB::table('role_user')->insert([
          'user_id' => 2,
          'role_id' => 4
        ]);
    }

    private function role_seeder(){
      DB::table('roles')->truncate();
      DB::table('role_user')->truncate();

      DB::table('roles')->insert([
        'slug' => 'seller',
        'name' => 'Seller'
      ]);
      DB::table('roles')->insert([
        'slug' => 'manager',
        'name' => 'Manager'
      ]);
      DB::table('roles')->insert([
        'slug' => 'supervisor',
        'name' => 'Supervisor'
      ]);
      DB::table('roles')->insert([
        'slug' => 'admin',
        'name' => 'Administrator'
      ]);
      DB::table('roles')->insert([
        'slug' => 'superuser',
        'name' => 'Superuser'
      ]);
    }

    private function seedArea()
    {
        App\Models\Area::truncate();
        App\Models\Stokiest::truncate();
        App\Models\Market::truncate();
        App\Models\Outlet::truncate();
        App\Models\Media::truncate();

        $areas = factory(App\Models\Area::class, 5)->create()->each(function($a){
          factory(App\Models\Stokiest::class)->create(['area_id' => $a->id]);
          factory(App\Models\Market::class)->create(['area_id' => $a->id])
            ->each(function($m){
              factory(App\Models\Outlet::class)->create(['market_id' => $m->id]);
            });
        });
    }

    // factory(User::class, 10)->create()->each(function ($user) {
    //     factory(Post::class, 5)->create(['user_id'=>$user->id]);
    // });

    private function seedMarket()
    {
        App\Models\Market::truncate();
        $market = factory(App\Models\Market::class, 5)->create()->each(function ($m) {
          $m->outlets()->save(factory(App\Models\Outlet::class)->make());
        });
    }

    private function seedStokiest()
    {
        App\Models\Stokiest::truncate();
        $stokiest = factory(App\Models\Stokiest::class, 10)->create();
    }

    private function seedItems()
    {
        App\Models\Item::truncate();
        App\Models\Media::truncate();
        $stokiest = factory(App\Models\Item::class, 3)->create();
    }
}

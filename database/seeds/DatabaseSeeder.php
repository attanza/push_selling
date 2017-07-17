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

        // App\Models\Area::truncate();
        // $users = factory(App\Models\Area::class, 10)->create();
        //
        // App\Models\Market::truncate();
        // $market = factory(App\Models\Market::class, 10)->create();

    }

    private function role_seeder(){
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
}

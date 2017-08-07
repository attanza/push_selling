<?php

use Illuminate\Database\Seeder;

class InitialSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUser();
        $this->role_seeder();
    }

    public function createUser()
    {
        App\User::truncate();
        DB::table('role_user')->truncate();

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

        App\User::create([
          'name' => 'Supervisor',
          'username' => 'supervisor',
          'email' => 'supervisor@supervisor.com',
          'password' => bcrypt('password'),
        ]);

        App\User::create([
          'name' => 'Seller',
          'username' => 'seller',
          'email' => 'seller@seller.com',
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
        DB::table('role_user')->insert([
          'user_id' => 3,
          'role_id' => 3
        ]);

        DB::table('role_user')->insert([
          'user_id' => 4,
          'role_id' => 1
        ]);
    }

    public function role_seeder(){
      DB::table('roles')->truncate();

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

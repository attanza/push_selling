<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Models\Role;
use DB;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->createUsers();
    }

    public function test_non_register_user_cannot_access_pages()
    {
        $this->visit('/')
          ->seePageIs('/login')
          ->see('Log in')
          ->type('dani@dani.com', 'email')
          ->type('password', 'password')
          ->seePageIs('/login');
    }

    public function test_admin_can_access_admin_dashboard()
    {
        $user = User::find(1);
        $this->actingAs($user)
          ->get('/dashboard')
          ->see('Admin Dashboard');
    }

    public function test_supervisor_can_access_supervisor_dashboard()
    {
        $user = User::find(2);
        $this->actingAs($user)
          ->get('/dashboard')
          ->see('Supervisor Dashboard');
    }

    public function test_seller_can_access_seller_dashboard()
    {
        $user = User::find(3);
        $this->actingAs($user)
          ->get('/dashboard')
          ->see('Seller Dashboard');
    }

    private function createUsers()
    {
        // Admin
        DB::table('roles')->insert([
          'name' => 'Administrator',
          'slug' => 'admin'
        ]);
        factory(User::class)->create([
          'email' => 'admin@admin.com'
        ]);
        DB::table('role_user')->insert([
          'role_id' => 1,
          'user_id' => 1
        ]);

        // Supervisor
        DB::table('roles')->insert([
          'name' => 'Supervisor',
          'slug' => 'supervisor'
        ]);
        factory(User::class)->create([
          'email' => 'supervisor@supervisor.com'
        ]);
        DB::table('role_user')->insert([
          'role_id' => 2,
          'user_id' => 2
        ]);

        // Supervisor
        DB::table('roles')->insert([
          'name' => 'Seller',
          'slug' => 'seller'
        ]);
        factory(User::class)->create([
          'email' => 'seller@seller.com'
        ]);
        DB::table('role_user')->insert([
          'role_id' => 3,
          'user_id' => 3
        ]);

    }
}

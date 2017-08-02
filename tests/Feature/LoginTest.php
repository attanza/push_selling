<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;
use App\User;
use DB;

abstract class LoginTest extends BaseTestCase
{
    use DatabaseMigrations;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->createRole();
        $this->createRoleUser();
        $this->createUser();
        $this->user = User::find(1);
    }

    public function testUserLogin()
    {
      $this->visit('/')
           ->see('Log in')
           ->type('admin@admin.com', 'name')
           ->type('password', 'password')
           ->press('Log in')
           ->seePageIs('/dashboard');
    }

    public function test_a_non_regietered_user_cannot_login()
    {
        $this->visit('/login')
        ->type('dani@dani.com', 'name')
        ->type('password', 'password')
        ->press('Log in')
        ->seePageIs('/login');
    }

    private function createUser()
    {
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'username' => 'Administrator',
            'password' => bcrypt('password'),
        ]);

        return $user;
    }

    private function createRole()
    {
        $role = DB::table('roles')->insert([
            'name' => 'Administrator',
            'slug' => 'admin'
        ]);

        $role = DB::table('roles')->insert([
            'name' => 'Seller',
            'slug' => 'seller'
        ]);

        return $role;
    }

    private function createRoleUser()
    {
        $role_user = DB::table('role_user')->insert([
            'role_id' => 1,
            'user_id' => 1
        ]);
    }
}

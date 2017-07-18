<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use DB;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    private $user;

    protected function setUp()
    {
        parent::setUp();
        $this->createRole();
        $this->createRoleUser();
        $this->user = $this->createUser();
    }

    public function test_a_guest_should_not_see_dashboard()
    {
        $this->get('/dashboard')
            ->assertRedirect(route('login'));
    }

    public function test_an_admin_user_can_see_dashboard()
    {
        $this->actingAs($this->user)
            ->get('/dashboard')
            ->assertSeeText('Dashboard');
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
            'role_id' => 2,
            'user_id' => 1
        ]);
    }
}

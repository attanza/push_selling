<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
    /**
     * @group profile
     */
    public function test_admin_can_access_profile()
    {
        $user = User::find(2);
        $this->actingAs($user)
          ->get('/profile/'.$user->username)
          ->see('Your Profile');
    }
    /**
     * @group profile
     */
    public function test_admin_can_access_all_user_profile_page()
    {
        $user = User::find(2);
        $supervisor = User::find(3);
        $seller = User::find(4);
        $this->actingAs($user)
          ->get('/profile/'.$supervisor->username)
          ->see('Your Profile')
          ->get('/profile/'.$seller->username)
          ->see('Your Profile');
    }

}

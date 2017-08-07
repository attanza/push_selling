<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\Transaction;
use App\Models\Item;
use App\Models\Outlet;
use Carbon\Carbon;

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
    /**
     * @group transaction
     */
    public function test_seller_can_access_transaction()
    {
        $user = User::find(4);
        $this->actingAs($user)
          ->get('/transaction')
          ->see('Transaction List');
    }

    /**
     * @group transaction
     */
    public function test_supervisor_can_access_transaction()
    {
        $user = User::find(3);
        $this->actingAs($user)
          ->get('/transaction')
          ->see('Transaction List');
    }

    /**
     * @group transaction
     */
    public function test_admin_cannot_access_transaction()
    {
        $user = User::find(2);
        $this->actingAs($user)
          ->get('/transaction')
          ->assertRedirectedTo('/dashboard');
    }

    /**
     * @group transaction
     */
    public function test_seller_can_submit_transaction()
    {
        $user = User::find(4);
        $item = Item::find(1);
        $outlet = Outlet::find(1);
        $faker = Factory::create();
        $postData = [
          'code' => $faker->unique()->ean8,
          'item_id' => $item->id,
          'outlet_id' => $outlet->id,
          'seller_id' => $user->id,
          'qty' => $faker->numberBetween(100, 300),
          'description' => $faker->paragraph
        ];
        $this->actingAs($user, 'api')
          ->json('POST', '/api/transaction', $postData)
          ->assertResponseStatus(200);
    }

    /**
     * @group transaction
     */
    public function test_supervisor_cannot_submit_transaction()
    {
        $user = User::find(3);
        $item = Item::find(1);
        $outlet = Outlet::find(1);
        $faker = Factory::create();
        $postData = [
          'code' => $faker->unique()->ean8,
          'item_id' => $item->id,
          'outlet_id' => $outlet->id,
          'seller_id' => $user->id,
          'qty' => $faker->numberBetween(100, 300),
          'description' => $faker->paragraph
        ];
        $this->actingAs($user, 'api')
          ->json('POST', '/api/transaction', $postData)
          ->assertResponseStatus(403);
    }

    /**
     * @group transaction
     */
    public function test_seller_cannot_delete_verfied_transaction()
    {
        $user = User::find(4);
        $transaction = factory(Transaction::class)->create([
          'item_id' => 1,
          'outlet_id' => 1,
          'seller_id' => 4,
          'verified' => 1
        ]);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/transaction/'.$transaction->id)
          ->assertResponseStatus(403);
    }

    /**
     * @group transaction
     */
    public function test_seller_can_delete_not_verfied_transaction()
    {
        $user = User::find(4);
        $transaction = factory(Transaction::class)->create([
          'item_id' => 1,
          'outlet_id' => 1,
          'seller_id' => 4,
        ]);
        $this->actingAs($user, 'api')
          ->json('delete', '/api/transaction/'.$transaction->id)
          ->assertResponseStatus(200);
    }

    /**
     * @group transaction
     */
    public function test_seller_cannot_edit_other_seller_transaction()
    {
        $user = User::find(4);
        $item = Item::find(1);
        $outlet = Outlet::find(1);
        $transaction = Transaction::find(1);
        $faker = Factory::create();
        $postData = [
          'code' => $faker->unique()->ean8,
          'item_id' => $item->id,
          'outlet_id' => $outlet->id,
          'seller_id' => $user->id,
          'qty' => $faker->numberBetween(100, 300),
          'description' => $faker->paragraph
        ];
        $this->actingAs($user, 'api')
          ->json('put', '/api/transaction/'.$transaction->id, $postData)
          ->assertResponseStatus(403);
    }

    /**
     * @group transaction
     */
    public function test_seller_can_edit_owned_transaction()
    {
        $user = User::find(4);
        $item = Item::find(1);
        $outlet = Outlet::find(1);
        $transaction = factory(Transaction::class)->create([
          'item_id' => $item->id,
          'outlet_id' => $outlet->id,
          'seller_id' => $user->id,
        ]);
        $faker = Factory::create();
        $postData = [
          'code' => $faker->unique()->ean8,
          'item_id' => $item->id,
          'outlet_id' => $outlet->id,
          'seller_id' => $user->id,
          'qty' => $faker->numberBetween(100, 300),
          'description' => $faker->paragraph
        ];
        $this->actingAs($user, 'api')
          ->json('put', '/api/transaction/'.$transaction->id, $postData)
          ->assertResponseStatus(200);
    }

    /**
     * @group transaction
     */
    public function test_non_supervisor_cannot_verify_transaction()
    {
        $user = User::find(4);
        $item = Item::find(1);
        $outlet = Outlet::find(1);
        $transaction = factory(Transaction::class)->create([
          'item_id' => $item->id,
          'outlet_id' => $outlet->id,
          'seller_id' => $user->id,
        ]);
        $this->actingAs($user, 'api')
          ->json('get', '/api/transaction/'.$transaction->id.'/verified')
          ->assertResponseStatus(403);
    }

    /**
     * @group transaction
     */
    public function test_supervisor_can_verify_transaction()
    {
        $user = User::find(4);
        $item = Item::find(1);
        $outlet = Outlet::find(1);
        $transaction = factory(Transaction::class)->create([
          'item_id' => $item->id,
          'outlet_id' => $outlet->id,
          'seller_id' => $user->id,
        ]);
        $supervisor = User::find(3);

        $this->actingAs($supervisor, 'api')
          ->json('get', '/api/transaction/'.$transaction->id.'/verified')
          ->assertResponseStatus(200);
    }

    /**
     * @group transaction
     */
    // public function test_seller_can_export_transaction()
    // {
    //     $user = User::find(4);
    //     $current = Carbon::now();
    //     $start_date = $current->addDays(-7);
    //     $end_date = $current->addDays(20);
    //     $string_date = $start_date.','.$end_date;
    //     $this->actingAs($user)
    //       ->get('/export-data/transaction/'.$string_date)
    //       ->assertResponseStatus(200);
    // }
}

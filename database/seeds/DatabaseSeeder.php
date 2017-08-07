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
        Artisan::call('migrate:refresh');
        $this->call(InitialSeed::class);
        $this->seedArea();
        $this->seedItems();
        $this->createSellers();
        $this->seedOutletSeller();
        $this->seedTransaction();
    }
    private function seedArea()
    {
        $areas = factory(App\Models\Area::class, 5)->create()->each(function($a){
          factory(App\Models\Stokiest::class)->create(['area_id' => $a->id]);
          factory(App\Models\Market::class)->create(['area_id' => $a->id])
            ->each(function($m){
              factory(App\Models\Outlet::class)->create(['market_id' => $m->id]);
            });
        });
    }

    private function seedItems()
    {
        factory(App\Models\Item::class, 3)->create();
    }

    private function createSellers()
    {
        $users = factory(App\User::class, 3)
           ->create()
           ->each(function ($user) {
                $user->roles()->attach(1);
                factory(App\Models\SellerTarget::class)->create([
                  'user_id' => $user->id,
                  'item_id' => rand(1,3),
                  'creator_id' => 3
                ]);
            });
    }

    private function seedOutletSeller()
    {
        for ($i=1; $i < 16; $i++) {
            DB::table('outlet_sellers')->insert([
                'outlet_id' => $i,
                'seller_id' => rand(5,7),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function seedTransaction()
    {
        for ($i=1; $i < 26; $i++) {
          factory(App\Models\Transaction::class)->create([
              'seller_id' => rand(5,7),
              'item_id' => rand(1,3),
              'outlet_id' => rand(1,15),
          ]);
        }
    }
}

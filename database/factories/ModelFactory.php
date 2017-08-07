<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $name = $faker->name;
    return [
        'name' => $name,
        'username' => str_slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('password'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Area::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->city,
    'description' => $faker->paragraph
  ];
});

$factory->define(App\Models\Market::class, function (Faker\Generator $faker) {
  $name = $faker->city;
  return [
    'name' => $name,
    'slug' => str_slug($name),
    'address' => $faker->address,
    'lat' => $faker->latitude,
    'lng' => $faker->longitude,
  ];
});

$factory->define(App\Models\Stokiest::class, function (Faker\Generator $faker) {
  return [
    'code' => $faker->unique()->ean8,
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
});

$factory->define(App\Models\Item::class, function (Faker\Generator $faker) {
  $start_date = Carbon\Carbon::now();
  $end_date = Carbon\Carbon::now()->addMonths(8);

  return [
    'code' => $faker->unique()->ean8,
    'name' => $faker->streetName,
    'measurement' => $faker->word,
    'price' => $faker->numberBetween(100000, 200000),
    'target_by' => $faker->numberBetween(1, 2),
    'target_count' => $faker->numberBetween(1000, 5000),
    'start_date' => $start_date,
    'end_date' => $end_date,
  ];
});

$factory->define(App\Models\Outlet::class, function (Faker\Generator $faker) {
  return [
    'code' => $faker->unique()->ean8,
    'name' => $faker->streetName,
    'owner' => $faker->name,
    'pic' => $faker->name,
    'phone1' => $faker->e164PhoneNumber,
    'phone2' => $faker->e164PhoneNumber,
    'email' => $faker->unique()->email,
    'address' => $faker->address,
    'lat' => $faker->latitude,
    'lng' => $faker->longitude,
  ];
});

$factory->define(App\Models\SellerTarget::class, function (Faker\Generator $faker) {
  $start_date = Carbon\Carbon::now();
  $end_date = Carbon\Carbon::now()->addMonths(6);
  return [
    'name' => $faker->sentence,
    'target_count' => $faker->numberBetween(1000, 5000),
    'start_date' => $start_date,
    'end_date' => $end_date,
    'description' => $faker->paragraph
  ];
});

$factory->define(App\Models\Transaction::class, function (Faker\Generator $faker) {
    return [
        'code' => $faker->unique()->ean8,
        'qty' => $faker->numberBetween(100, 300),
        'description' => $faker->paragraph
    ];
});

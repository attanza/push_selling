<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $name = $faker->name;
    return [
        'name' => $name,
        'username' => str_slug($name),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
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
    'area_id' => 1,
    'name' => $name,
    'slug' => str_slug($name),
    'address' => $faker->address,
    'lat' => $faker->latitude,
    'lng' => $faker->longitude,

  ];
});

$factory->define(App\Models\Stokiest::class, function (Faker\Generator $faker) {
  $name = $faker->city;
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

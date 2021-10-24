<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $name = $faker->firstName;
    $user = $faker->bothify($name . '#?##?');
    return [
        'user' => $name,
        'name' => $name,
        'last_name' => $faker->lastName,
        'num_id' => rand(500000, 50000000),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret'),
        'remember_token' => Str::random(10),
        'email_verified_at' => now(),
    ];
});

$factory->define(App\Models\Permisologia\Role::class, function (Faker $faker) {
    $rol = $faker->numerify('Rol ####');
    return [
        'name' => $rol,
        'slug' => $rol,
        'description' => 'Rol de prueba',
        'from_at' => \Carbon\Carbon::parse('08:00:00'),
        'to_at' => \Carbon\Carbon::parse('17:00:00'),
        'special' => null
    ];
});

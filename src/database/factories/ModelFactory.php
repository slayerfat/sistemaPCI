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

$factory->define(PCI\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'status'         => true,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(PCI\Models\UserDetail::class, function (Faker\Generator $faker) {
    return [
        'ci'            => rand(999999, 99999999),
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->firstName,
        'first_surname' => $faker->lastName,
        'last_surname'  => $faker->lastName,
        'phone'         => $faker->phoneNumber,
        'cellphone'     => $faker->phoneNumber,
    ];
});

$factory->define(PCI\Models\Nationality::class, function (Faker\Generator $faker) {
    return ['desc' => $faker->word];
});

$factory->define(PCI\Models\Gender::class, function (Faker\Generator $faker) {
    return ['desc' => $faker->word];
});

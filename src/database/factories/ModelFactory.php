<?php

// se decidio hacerlo de esta forma porque
// tienen la misma estructura
$models = [
    PCI\Models\Gender::class,
    PCI\Models\Nationality::class,
    PCI\Models\Parish::class,
    PCI\Models\Position::class,
    PCI\Models\State::class,
    PCI\Models\Town::class,
];

foreach ($models as $model) {
    $factory->define($model, function (Faker\Generator $faker) {
        return ['desc' => $faker->word];
    });
}

$factory->define(PCI\Models\Address::class, function (Faker\Generator $faker) {
    return [
        'building' => $faker->buildingNumber,
        'street'   => $faker->streetAddress,
        'av'       => $faker->word,
    ];
});

$factory->define(PCI\Models\Department::class, function (Faker\Generator $faker) {
    return [
        'desc'  => $faker->word,
        'phone' => $faker->phoneNumber,
    ];
});

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

$factory->define(PCI\Models\WorkDetail::class, function (Faker\Generator $faker) {
    return [
        'join_date'      => $faker->date,
        'departure_date' => $faker->date,
    ];
});

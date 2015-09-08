<?php

// se decidio hacerlo de esta forma porque
// tienen la misma estructura
$models = [
    PCI\Models\Category::class,
    PCI\Models\Gender::class,
    PCI\Models\ItemType::class,
    PCI\Models\Maker::class,
    PCI\Models\MovementType::class,
    PCI\Models\Nationality::class,
    PCI\Models\NoteType::class,
    PCI\Models\Parish::class,
    PCI\Models\PetitionType::class,
    PCI\Models\Position::class,
    PCI\Models\Profile::class,
    PCI\Models\State::class,
    PCI\Models\SubCategory::class,
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

$factory->define(PCI\Models\Attendant::class, function (Faker\Generator $faker) {
    return [
        'selection' => $faker->dateTime,
        'status'    => true
    ];
});

$factory->define(PCI\Models\Department::class, function (Faker\Generator $faker) {
    return [
        'desc'  => $faker->word,
        'phone' => $faker->phoneNumber,
    ];
});

$factory->define(PCI\Models\Depot::class, function (Faker\Generator $faker) {
    return [
        'rack'  => rand(1, 5),
        'shelf' => rand(1, 10),
    ];
});


$factory->define(PCI\Models\Employee::class, function (Faker\Generator $faker) {
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

$factory->define(PCI\Models\Item::class, function (Faker\Generator $faker) {
    return [
        'asoc'     => 'C',
        'priority' => '50',
        'desc'     => $faker->sentence,
        'stock'    => rand(0, 10000),
        'minimun'  => rand(0, 10000),
        'due'      => $faker->dateTime,
    ];
});

$factory->define(PCI\Movement\Item::class, function (Faker\Generator $faker) {
    return [
        'creation' => $faker->dateTime,
    ];
});

$factory->define(PCI\Movement\Note::class, function (Faker\Generator $faker) {
    return [
        'creation' => $faker->dateTime,
        'comments' => $faker->paragraph,
        'status'   => true,
    ];
});

$factory->define(PCI\Movement\Note::class, function (Faker\Generator $faker) {
    return [
        'request_date' => $faker->dateTime,
        'comments'     => $faker->paragraph,
        'status'       => true,
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

$factory->define(PCI\Models\WorkDetail::class, function (Faker\Generator $faker) {
    return [
        'join_date'      => $faker->date,
        'departure_date' => $faker->date,
    ];
});

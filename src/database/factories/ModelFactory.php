<?php

// se decidio hacerlo de esta forma porque
// tienen la misma estructura
$models = PCI\Database\AuxEntitiesSeeder::getModels();

$faker = Faker\Factory::create('es_ES');

foreach ($models as $model) {
    $factory->define($model, function () use ($faker) {
        return ['desc' => $faker->word];
    });
}

$factory->define(PCI\Models\Address::class, function () use ($faker) {
    return [
        'parish_id' => 1,
        'building'  => $faker->buildingNumber,
        'street'    => $faker->streetAddress,
        'av'        => $faker->word,
    ];
});

$factory->define(PCI\Models\Attendant::class, function () use ($faker) {
    return [
        'user_id'   => 1,
        'selection' => $faker->dateTime,
        'status'    => true
    ];
});

$factory->define(PCI\Models\Department::class, function () use ($faker) {
    return [
        'desc'  => $faker->word,
        'phone' => $faker->phoneNumber,
    ];
});

$factory->define(PCI\Models\Depot::class, function () use ($faker) {
    return [
        'user_id' => 1,
        'rack'    => rand(1, 5),
        'shelf'   => rand(1, 10),
    ];
});


$factory->define(PCI\Models\Employee::class, function () use ($faker) {
    return [
        'user_id'        => 1,
        'nationality_id' => 1,
        'gender_id'      => 1,
        'address_id'     => 1,
        'ci'             => rand(999999, 99999999),
        'first_name'     => $faker->firstName,
        'last_name'      => $faker->firstName,
        'first_surname'  => $faker->lastName,
        'last_surname'   => $faker->lastName,
        'phone'          => $faker->phoneNumber,
        'cellphone'      => $faker->phoneNumber,
    ];
});

$factory->define(PCI\Models\Item::class, function () use ($faker) {
    return [
        'sub_category_id' => rand(1, 2),
        'maker_id'        => rand(1, 2),
        'item_type_id'    => rand(1, 2),
        'asoc'            => $faker->randomElement(['a', 'b', 'c']),
        'priority'        => rand(1, 100),
        'desc'            => $faker->sentence,
        'stock'           => rand(0, 10000),
        'minimum'         => rand(0, 10000),
        'due'             => $faker->dateTime,
    ];
});

$factory->define(PCI\Models\Movement::class, function () use ($faker) {
    return [
        'note_id'          => 1,
        'movement_type_id' => 1,
        'creation'         => $faker->dateTime,
    ];
});

$factory->define(PCI\Models\Note::class, function () use ($faker) {
    return [
        'user_id'      => 1,
        'attendant_id' => 1,
        'note_type_id' => 1,
        'petition_id'  => 1,
        'creation'     => $faker->dateTime,
        'comments'     => $faker->paragraph,
        'status'       => true,
    ];
});

$factory->define(PCI\Models\Petition::class, function () use ($faker) {
    return [
        'user_id'          => 1,
        'petition_type_id' => 1,
        'request_date'     => $faker->dateTime,
        'comments'         => $faker->paragraph,
        'status'           => true,
    ];
});

$factory->define(PCI\Models\User::class, function () use ($faker) {
    return [
        'profile_id'        => 2,
        'name'              => $faker->word,
        'email'             => $faker->email,
        'password'          => bcrypt(str_random(10)),
        'remember_token'    => str_random(10),
        'confirmation_code' => str_random(32),
    ];
});

$factory->define(PCI\Models\WorkDetail::class, function () use ($faker) {
    return [
        'join_date'      => $faker->date,
        'departure_date' => $faker->date,
    ];
});

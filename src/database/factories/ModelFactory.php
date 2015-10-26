<?php

// se decidio hacerlo de esta forma porque
// tienen la misma estructura
$models = PCI\Database\AuxEntitiesSeeder::getModels();

$faker = Faker\Factory::create();

foreach ($models as $model) {
    $factory->define($model, function () use ($faker) {
        return ['desc' => $faker->text(40)];
    });
}

$factory->define(PCI\Models\Address::class, function () use ($faker) {
    return [
        'parish_id' => factory(PCI\Models\Parish::class)->create()->id,
        'building'  => $faker->buildingNumber,
        'street'    => $faker->streetAddress,
        'av'        => $faker->word,
    ];
});

$factory->define(PCI\Models\Attendant::class, function () use ($faker) {
    return [
        'user_id' => factory(PCI\Models\User::class)->create()->id,
        'selection' => $faker->dateTime,
        'status' => true,
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
        'number' => rand(1, 2),
        'rack'    => rand(1, 5),
        'shelf'   => rand(1, 10),
    ];
});

$factory->define(PCI\Models\Employee::class, function () use ($faker) {
    return [
        'user_id'        => 1,
        'nationality_id' => factory(PCI\Models\Nationality::class)->create()->id,
        'gender_id'      => factory(PCI\Models\Gender::class)->create()->id,
        'address_id'     => factory(PCI\Models\Address::class)->create()->id,
        'ci'             => rand(999999, 99999999),
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->firstName,
        'first_surname' => $faker->lastName,
        'last_surname'  => $faker->lastName,
        'phone'          => '0' . rand(400, 499) . rand(100, 999) . rand(1000, 9999),
        'cellphone'      => '0' . rand(400, 499) . rand(100, 999) . rand(1000, 9999),
    ];
});

$factory->define(PCI\Models\Item::class, function () use ($faker) {
    return [
        'sub_category_id' => rand(1, 2),
        'maker_id'        => rand(1, 2),
        'item_type_id'    => rand(1, 2),
        'stock_type_id' => rand(1, 3),
        'asoc'            => $faker->randomElement(['a', 'b', 'c']),
        'priority'        => rand(1, 100),
        'desc'            => $faker->sentence,
        'minimum'         => rand(0, 10000),
    ];
});

$factory->defineAs(PCI\Models\Item::class, 'full', function () use ($factory) {
    $item = $factory->raw(PCI\Models\Item::class);

    return array_merge($item, [
        'sub_category_id' => factory(PCI\Models\SubCategory::class)->create()->id,
        'maker_id'        => factory(PCI\Models\Maker::class)->create()->id,
        'item_type_id'    => factory(PCI\Models\ItemType::class)->create()->id,
        'stock_type_id' => factory(PCI\Models\StockType::class)->create()->id,
    ]);
});

$factory->define(PCI\Models\Movement::class, function () use ($faker) {
    return [
        'movement_type_id' => 1,
        'note_id' => factory(PCI\Models\Note::class)->create()->id,
        'creation'         => $faker->dateTime,
    ];
});

$factory->define(PCI\Models\Note::class, function () use ($faker) {
    return [
        'user_id'      => 1,
        'to_user_id' => factory(PCI\Models\User::class)->create()->id,
        'note_type_id' => 1,
        'attendant_id' => factory(PCI\Models\Attendant::class)->create()->id,
        'petition_id'  => factory(PCI\Models\Petition::class)->create()->id,
        'creation'     => $faker->dateTime,
        'comments'     => $faker->paragraph,
        'status'       => true,
    ];
});

$factory->define(PCI\Models\Parish::class, function () use ($faker) {
    return [
        'desc'    => $faker->text(40),
        'town_id' => factory(\PCI\Models\Town::class)->create()->id,
    ];
});

$factory->define(PCI\Models\Petition::class, function () use ($faker) {
    return [
        'user_id'          => 1,
        'petition_type_id' => factory(\PCI\Models\PetitionType::class)->create()->id,
        'request_date'     => $faker->dateTime,
        'comments'         => $faker->paragraph,
        'status'           => true,
    ];
});

$factory->define(PCI\Models\SubCategory::class, function () use ($faker) {
    return [
        'desc'        => $faker->text(40),
        'category_id' => factory(\PCI\Models\Category::class)->create()->id,
    ];
});

$factory->define(PCI\Models\NoteType::class, function () use ($faker) {
    return [
        'desc'             => $faker->text(40),
        'movement_type_id' => factory(\PCI\Models\MovementType::class)->create()->id,
    ];
});

$factory->define(PCI\Models\Town::class, function () use ($faker) {
    return [
        'desc'     => $faker->text(40),
        'state_id' => 1,
    ];
});

$factory->define(PCI\Models\User::class, function () use ($faker) {
    return [
        'profile_id'        => 2,
        'name'              => $faker->userName,
        'email'             => $faker->email,
        'password'          => bcrypt(str_random(10)),
        'remember_token'    => str_random(10),
        'confirmation_code' => str_random(32),
    ];
});

$factory->defineAs(PCI\Models\User::class, 'admin', function () use ($factory) {
    $item = $factory->raw(PCI\Models\User::class);

    return array_merge($item, [
        'profile_id'        => PCI\Models\User::ADMIN_ID,
        'confirmation_code' => null,
    ]);
});

$factory->define(PCI\Models\WorkDetail::class, function () use ($faker) {
    return [
        'department_id' => factory(\PCI\Models\Department::class)->create()->id,
        'position_id'   => factory(\PCI\Models\Position::class)->create()->id,
        'employee_id'   => factory(\PCI\Models\Employee::class)->create()->id,
        'join_date'      => $faker->date,
        'departure_date' => $faker->date,
    ];
});

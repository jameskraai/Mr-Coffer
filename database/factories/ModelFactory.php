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

$factory->define(MrCoffer\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(MrCoffer\Bank::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(MrCoffer\Account\Type::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(\MrCoffer\Account\Account::class, function (Faker\Generator $faker) {
    return [
        'name'    => $faker->title,
        'user_id' => function () {
            return factory(MrCoffer\User::class)->create()->id;
        },
        'number'  => $faker->numberBetween(100, 1000),
        'type_id' => function () {
            return factory(MrCoffer\Account\Type::class)->create()->id;
        },
        'bank_id'  => function () {
            return factory(MrCoffer\Bank::class)->create()->id;
        },
    ];
});


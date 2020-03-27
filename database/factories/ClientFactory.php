<?php

/** @var Factory $factory */

use App\Model;
use App\Models\Client;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name'    => $faker->name,
        'email'   => $faker->email,
        'user_id' => function () {

            return factory(User::class)
                ->create()
                ->each(function () {
                    $user = factory(User::class)->make();
                    $user->assignRole(config('desafio.role-default'));

                });
        }
    ];
});

<?php

/** @var Factory $factory */

use App\Model;
use App\Models\Client;
use App\Models\Phone;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Phone::class, function (Faker $faker) {
    return [
        'phone'     => $faker->numerify('###########'),
        'client_id' => function () {
            return factory(Client::class)->create()->id;
        }
    ];
});

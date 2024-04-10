<?php

use Illuminate\Support\Str;

use Faker\Generator as Faker;

$factory->define(App\FlightCallSigns::class, function (Faker $faker) {
    $str = rand(); $randStr = strtoupper(substr(hash("sha256", $str), 0, 6));

    return [
    'flight_name' =>$randStr,
    // 'flight_name' =>str_random(2)->randomNumber(4, true)->unique(),
    'airline' => $faker->name.' airline',
    'further_description' => $faker->sentence,
    ];

});

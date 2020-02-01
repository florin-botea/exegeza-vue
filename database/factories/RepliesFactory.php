<?php

use Faker\Generator as Faker;

$factory->define(App\Replies::class, function (Faker $faker) {
    return [
			'author' 	=> $faker->randomDigit,
			'text'		=> $faker->text
    ];
});

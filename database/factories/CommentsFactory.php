<?php

use Faker\Generator as Faker;

$factory->define(App\Comments::class, function (Faker $faker) {
    return [
			'target' 	=> $faker->randomDigit,
			'author' 	=> $faker->randomDigit,
			'title' 	=> $faker->title(10),
			'text'		=> $faker->text,
			'flag1'		=> $faker->word(7),
			'flag2'		=> $faker->word(7),
    ];
});

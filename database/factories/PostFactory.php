<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1,20),
        'created_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'updated_at' => $faker->date('Y-m-d H:i:s', 'now'),
        'subject' => $faker->realText(15),
        'body1' => $faker->realText(15),
        'body2' => $faker->realText(15),
        'body3' => $faker->realText(15),
        'category_id' => $faker->numberBetween(1,5) //1~5のランダムな数字を入れる
    ];
});
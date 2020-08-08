<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;


$factory->define(Project::class, function (Faker $faker) {

    $user = factory(User::class)->create();

    return [
        'user_id' => $user->id,
        'name' => $faker->title,
        'description' => $faker->sentence,
    ];
});

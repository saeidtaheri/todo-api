<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\Todo;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    
    $project = factory(Project::class)->create();

    return [
        'project_id' => $project->id,
        'title' => $faker->title,
        'body' => $faker->sentence,
    ];
});
